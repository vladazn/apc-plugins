<?php
namespace ApcRouteDelivery\Components;

use Shopware\Components\Plugin\ConfigReader;

class ZipComponent
{
    private $pluginDir = null;
    private $db = null;
    private $customPageId = null;
    private $reminderMailTemplate = null;
    private $mapsApi = null;
    private $areaImg = null;

    private $weeks = [
        1 => 'Montag',
        2 => 'Dienstag',
        3 => 'Mittwoch',
        4 => 'Donnerstag',
        5 => 'Freitag',
        6 => 'Samstag',
        7 => 'Sonntag'
    ];

    private $months = [
        1 => 'Januar',
        2 => 'Februar',
        3 => 'März',
        4 => 'April',
        5 => 'Mai',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'August',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Dezember'
    ];

    public function __construct($pluginBaseDirectory, $pluginName, ConfigReader $configReader){
        $this->pluginDir = $pluginBaseDirectory;
        $this->db = Shopware()->Db();

        $config = $configReader->getByPluginName($pluginName);

        $this->customPageId = $config['apc_route_page'];
        $this->reminderMailTemplate = $config['apc_route_reminder_template'];
        $this->areaImg = $config['apc_route_area'];
        $this->mapsApi = $config['apc_google_maps_api'];

    }
    public function addZipCodes(){
        $row = 1;

        if (($handle = fopen(__DIR__."/Resources/csv/de_zip.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle)) !== FALSE) {
                $num = count($data)-1;
                $row++;
                if(strlen($data[0]) < 5){
                    $data[0] = '0'.$data[0];
                }
                for ($c=0; $c < $num; $c++) {
                    $final[$row][] = $data[$c];
                }
            }
            fclose($handle);
        }
        $cat = array_shift($final);

        $sql = 'INSERT INTO `apc_zip` SET `zip` = ?, `place` = ?, `state` = ?, `state_abbr` = ?, `city` = ?;';
        foreach($final as $zipInfo){
            Showpare()->Db()->query($sql,$zipInfo);
        }
    }

    public function cronFunction(){
        $this->sendOrderMail();
        $this->updateDeliveryDates();
        $this->checkReminder();
        $this->updateCustomPage();
    }

    public function prepareZipList($routeId = null){
        $selected = [];
        if($routeId){
            $sql = 'SELECT `zip` FROM `apc_routes_zip` WHERE `route_id` = ?;';
            $selected = $this->db->fetchCol($sql,$routeId);
        }
        $sql = 'SELECT * FROM `apc_zip` ORDER BY `zip` ASC ;';
        $zipList = $this->db->fetchAll($sql);
        foreach($zipList as $zipInfo){
            if(in_array($zipInfo['zip'], $selected)){
                $zipInfo['checked'] = true;
            }else{
                $zipInfo['checked'] = false;
            }
            $list[substr($zipInfo['zip'], 0, 2)][] = $zipInfo;
        }
        return $list;
    }

    public function assignOrder($orderNumber){

        $sql = 'SELECT `apc_routes`.`new_date`, `apc_routes`.`id`  FROM `apc_routes`
                LEFT JOIN `apc_routes_zip`
                ON `apc_routes`.`id` = `apc_routes_zip`.`route_id`
                LEFT JOIN `s_order_shippingaddress`
                ON `apc_routes_zip`.`zip` = `s_order_shippingaddress`.`zipcode`
                LEFT JOIN `s_order`
                ON `s_order_shippingaddress`.`orderID` = `s_order`.`id`
                WHERE `apc_routes`.`active` = 1
                AND `s_order`.`ordernumber` = ? AND `s_order`.`ordernumber`<> 0
                ORDER BY `apc_routes`.`new_date` ASC
        ;';

        $deliveryInfo = $this->db->fetchRow($sql,$orderNumber);
        if(empty($deliveryInfo)){
            $sql = 'UPDATE `s_order_attributes` SET `apc_delivery_date` = NULL, `apc_delivery_route` = NULL
                    WHERE `orderID` = (SELECT `id` FROM `s_order` WHERE `ordernumber` = ? AND `ordernumber`<> 0);
                    ;';
                    $this->db->query($sql,$orderNumber);
        }else{
            $sql = 'UPDATE `s_order_attributes` SET `apc_delivery_date` = ?, `apc_delivery_route` = ?
                    WHERE `orderID` = (SELECT `id` FROM `s_order` WHERE `ordernumber` = ? AND `ordernumber`<> 0);
                    ;';
            $this->db->query($sql,[$deliveryInfo['new_date'],$deliveryInfo['id'],$orderNumber]);
        }
    }

    public function reassignOrders($routeId){
        $sql = 'SELECT `s_order`.`ordernumber`, `s_order`.`ordertime`
                FROM `s_order` LEFT JOIN `s_order_attributes` ON `s_order_attributes`.`orderID` = `s_order`.`id`
                WHERE (`s_order_attributes`.`apc_delivery_route` = ? OR `s_order_attributes`.`apc_delivery_route` IS NULL)
                ';

        $params[] = $routeId;
        $lastDelivery = Shopware()->Db()->fetchOne('SELECT `old_date` FROM `apc_routes` WHERE `id` = ?',$routeId);
        if($lastDelivery){
            $sql .= ' AND `s_order`.`ordertime` > ?';
            $params[] = $lastDelivery;
        }
        $orderNumbers = array_unique($this->db->fetchCol($sql,$params));
        foreach($orderNumbers as $orderNumber){
            $this->assignOrder($orderNumber);
        }
        $this->updateCustomPage();
    }

    public function createRoute($params){
        $sql = 'INSERT INTO `apc_routes` SET `name` = :name, `active` = 1, `new_date` = :deliveryDate;';
        $this->db->query($sql,$params);
        $routeId = $this->db->lastInsertId('apc_routes');
        $sql = 'INSERT INTO `apc_routes_dates` SET `route_id` = ?, `date` = ?;';
        $this->db->query($sql,[$routeId,$params['deliveryDate']]);
        $this->updateCustomPage();
    }

    public function updateRouteInfo($changes){
        $changes['date'] = array_filter($changes['date']);
        asort($changes['date']);
        $sql = 'UPDATE `apc_routes` SET `name` = ?, `new_date` = ? WHERE `id` = ?;';
        $this->db->query($sql,[$changes['name'],$changes['date'][0],$changes['routeId']]);

        $this->db->query('DELETE FROM `apc_routes_dates` WHERE `route_id` = ?',$changes['routeId']);
        $sql = 'INSERT INTO `apc_routes_dates` SET `route_id` = ?, `date` = ?;';

        foreach($changes['date'] as $date){
            $this->db->query($sql,[$changes['routeId'],$date]);
        }
        $this->reassignOrders($changes['routeId']);
    }

    public function updateRouteZip($routeId,$zipCodes){
        $this->db->query('DELETE FROM `apc_routes_zip` WHERE `route_id` = ?',$routeId);
        $sql = 'INSERT INTO `apc_routes_zip` SET `route_id` = ?, `zip` = ?;';

        foreach($zipCodes as $zip => $xz){
            $this->db->query($sql,[$routeId,$zip]);
        }
        $this->reassignOrders($routeId);
    }

    public function updateCustomPage(){
        $sql = 'SELECT `apc_routes_dates`.`date`, `apc_routes`.`name`, `apc_routes`.`id` FROM `apc_routes`
                LEFT JOIN `apc_routes_dates` ON `apc_routes_dates`.`route_id` = `apc_routes`.`id`
                WHERE `apc_routes`.`active` = 1 AND `apc_routes_dates`.`date` IS NOT NULL ORDER BY `apc_routes_dates`.`date` ASC;';
        $deliveries = $this->db->fetchAll($sql);
        $template = Shopware()->Template();
        $template = $template->createTemplate($this->pluginDir.'/Resources/views/frontend/custom/table.tpl');
        $template->assign('deliveries', $deliveries);
        $template->assign('weeks', $this->weeks);
        $template->assign('months', $this->months);
        $template->assign('imagePath', $this->areaImg);
        $html = $template->fetch();

        $sql = 'UPDATE `s_cms_static` SET `html` = ? WHERE `id` = ?;';
        $this->db->query($sql,[$html,$this->customPageId]);

    }

    public function getRouteOrders($routeId){
        $sql = 'SELECT `s_order`.`ordernumber` AS `ordernumber`,
                `s_order_details`.`name` AS `product`,
                `s_order_details`.`quantity` AS `quantity`,
                `s_order_shippingaddress`.`firstname`,
                `s_order_shippingaddress`.`lastname`,
                `s_order_shippingaddress`.`street`,
                `s_order_shippingaddress`.`zipcode`,
                `s_order_shippingaddress`.`city`,
                `s_core_paymentmeans`.`description` AS `payment`
                FROM `s_order`
                LEFT JOIN `s_order_attributes` ON `s_order_attributes`.`orderID` = `s_order`.`id`
                LEFT JOIN `s_order_details` ON `s_order_details`.`orderID` = `s_order`.`id`
                LEFT JOIN `s_order_shippingaddress` ON `s_order_shippingaddress`.`orderID` = `s_order`.`id`
                LEFT JOIN `s_core_paymentmeans` ON `s_core_paymentmeans`.`id` = `s_order`.`paymentID`
                WHERE `s_order_attributes`.`apc_delivery_route` = ?

                ';
        $params[] = $routeId;
        $lastDelivery = Shopware()->Db()->fetchOne('SELECT `old_date` FROM `apc_routes` WHERE `id` = ?',$routeId);
        if($lastDelivery){
            $sql .= 'AND `s_order`.`ordertime` > ? ';
            $params[] = $lastDelivery;
        }
        $sql .= 'ORDER BY `ordernumber` DESC ;';
        $orders = $this->db->fetchAll($sql,$params);
        $finalOrders = [];
        foreach($orders as $order){
            $finalOrders[$order['payment']][] = $order;
            $total[$order['product']] += (int)$order['quantity'];
        }
        return [$finalOrders,$total];
    }

    private function checkReminder(){
        $sql = 'SELECT `s_user`.`email` FROM `s_user`
        LEFT JOIN `s_user_shippingaddress` ON `s_user_shippingaddress`.`userID` = `s_user`.`id`
        LEFT JOIN `apc_routes_zip` ON `apc_routes_zip`.`zip` = `s_user_shippingaddress`.`zipcode`
        LEFT JOIN `apc_routes` ON `apc_routes_zip`.`route_id` = `apc_routes`.`id`
        WHERE `apc_routes`.`new_date` = ?
        ;';
        $emails = $this->db->fetchCol($sql,date('Y-m-d', strtotime('+2 days')));
        foreach($emails as $email){
            $this->sendMail($email);
        }
    }

    private function sendMail($recipient){
        $mail = Shopware()->TemplateMail()->createMail($this->reminderMailTemplate);
        $mail->addTo($recipient);
        $mail->send();
    }

    private function updateDeliveryDates(){
        $this->db->query('UPDATE `apc_routes` SET `old_date` = `new_date` WHERE `new_date` <= NOW() ;');
        $routes = $this->db->fetchCol('SELECT `id` FROM `apc_routes` WHERE `new_date` <= NOW();');
        $sql = 'UPDATE `apc_routes` SET `new_date` = (SELECT `date` FROM `apc_routes_dates` WHERE `route_id` = ? LIMIT 1, 1) WHERE `id` = ?;';
        $sql .= 'DELETE FROM `apc_routes_dates` WHERE `route_id` = ? LIMIT 1 ;';
        foreach($routes as $id){
            $this->db->query($sql,[$id,$id,$id]);
        }
    }
    private function sendOrderMail(){
        $routeIds = $this->db->fetchCol('SELECT `id` FROM `apc_routes` WHERE `new_date` = ?;', date('Y-m-d'));
        if(empty($routeIds)){
            return;
        }
        foreach($routeIds as $routeId){
            $orders = [];
            list($orders,$total) = $this->getRouteOrders($routeId);
            $invoices = $this->generateInvoices($orders);

            $mail = Shopware()->TemplateMail()->createMail('sORDERLIST');
            $mail->addTo(Shopware()->Config()->get('mail'));
            $mail->addTo('fritz@arne-klett.de');

            Shopware()->Template()->addTemplateDir(__DIR__ . '/../Resources/views/');;
            Shopware()->Template()->assign('finalOrders', $orders);
            Shopware()->Template()->assign('totals', $total);
            $sql = 'SELECT `name`, `new_date` AS `date` FROM `apc_routes` WHERE `id` = ?;';
            $routeInfo = $this->db->fetchRow($sql,$routeId);
            Shopware()->Template()->assign('route', $routeInfo);

            $data = Shopware()->Template()->fetch('backend/apc_delivery/mailorders.tpl');
            try{
                $mpdf = new \mPDF('utf-8', 'A4', '', '');
                $mpdf->WriteHTML($data);
                $pdfFileContent = $mpdf->Output('', 'S');
            }catch(\Exception $e){
            }

            $mail->createAttachment(
                $pdfFileContent,
                'application/pdf',
                \Zend_Mime::DISPOSITION_ATTACHMENT,
                \Zend_Mime::ENCODING_BASE64,
                'orders.pdf'
            );
            if($invoices){
                $mail->createAttachment(
                    $invoices,
                    'application/pdf',
                    \Zend_Mime::DISPOSITION_ATTACHMENT,
                    \Zend_Mime::ENCODING_BASE64,
                    'invoices_'.date('Y-m-d').'.pdf'
                );
            }

            try {
                $result = $mail->send();
            } catch (\Exception $e) {
            }
        }

    }

    // public function sendTestOrderMail(){
    //     $routeIds = $this->db->fetchCol('SELECT `id` FROM `apc_routes` WHERE `new_date` = ?;', date('Y-m-d', strtotime('+1 day')));
    //     if(empty($routeIds)){
    //         return;
    //     }
    //     foreach($routeIds as $routeId){
    //         $orders = [];
    //         list($orders,$total) = $this->getRouteOrders($routeId);
    //         $invoices = $this->generateInvoices($orders);
    //         $mail = Shopware()->TemplateMail()->createMail('sORDERLIST');
    //         // $mail->addTo(Shopware()->Config()->get('mail'));
    //         $mail->addTo('vladimir.aznauryan@gmail.com');
    //
    //         Shopware()->Template()->addTemplateDir(__DIR__ . '/../Resources/views/');;
    //         Shopware()->Template()->assign('finalOrders', $orders);
    //         Shopware()->Template()->assign('totals', $total);
    //         $sql = 'SELECT `name`, `new_date` AS `date` FROM `apc_routes` WHERE `id` = ?;';
    //         $routeInfo = $this->db->fetchRow($sql,$routeId);
    //         Shopware()->Template()->assign('route', $routeInfo);
    //
    //         $data = Shopware()->Template()->fetch('backend/apc_delivery/mailorders.tpl');
    //
    //         $mpdf = new \mPDF('utf-8', 'A4', '', '');
    //         $mpdf->WriteHTML($data);
    //         $pdfFileContent = $mpdf->Output('', 'S');
    //
    //
    //         $mail->createAttachment(
    //             $pdfFileContent,
    //             'application/pdf',
    //             \Zend_Mime::DISPOSITION_ATTACHMENT,
    //             \Zend_Mime::ENCODING_BASE64,
    //             'orders_'.date('Y-m-d').'.pdf'
    //         );
    //         if($invoices){
    //             $mail->createAttachment(
    //                 $invoices,
    //                 'application/pdf',
    //                 \Zend_Mime::DISPOSITION_ATTACHMENT,
    //                 \Zend_Mime::ENCODING_BASE64,
    //                 'invoices_'.date('Y-m-d').'.pdf'
    //             );
    //         }
    //
    //         try {
    //             $result = $mail->send();
    //         } catch (\Exception $e) {
    //         }
    //     }
    //
    // }

    private function generateInvoices($orders){
        foreach($orders as $paymentmethod){
            foreach($paymentmethod as $order){
                if(in_array($order['ordernumber'],$done)){
                    continue;
                }
                $this->generateSingleInvoice($order['ordernumber']);
                $done[] = $order['ordernumber'];
            }
        }

        $sql = 'SELECT `s_order_documents`.`hash` FROM `s_order_documents`
                    LEFT JOIN `s_order` ON `s_order`.`id` = `s_order_documents`.`orderID`
                    WHERE `s_order`.`ordernumber` IN ('.str_repeat("?,",count($done) - 1).'?)';
        $invoices = $data = Shopware()->Db()->fetchCol($sql,$done);
        if(empty($invoices)){
            return false;
        }
        foreach($invoices as &$invoice){
            $invoice = $_SERVER['DOCUMENT_ROOT'].'files/documents/'.$invoice.'.pdf';
        }
        $invoicesDocument = $this->mergeInvoices($invoices);

        return $invoicesDocument;
    }

    private function generateSingleInvoice($ordernumber){
        $sql = 'SELECT `id` FROM `s_order` WHERE `ordernumber` = ?;';
        $orderID = $this->db->fetchOne($sql,$ordernumber);
        $currentDate = date("d.m.Y");
		$orderIdentifier = (int)$orderID;

		$document = \Shopware_Components_Document::initDocument(
			$orderIdentifier,
			1,
			[
				'date'                    => $currentDate,
				'delivery_date'           => $currentDate,
				'shippingCostsAsPosition' => false,
				'_renderer'               => "pdf",
			]
		);

		$document->render();
    }

    public function mergeInvoices($filenames)
    {
        if ($filenames) {
            $filesTotal = sizeof($filenames);
            $fileNumber = 1;
            $mpdf = new \mPDF('utf-8', 'A4', '', '');

            $mpdf->SetImportUse();

            if (!file_exists($outFile)) {
                $handle = fopen($outFile, 'w');
                fclose($handle);
            }

            foreach ($filenames as $fileName) {
                if (file_exists($fileName)) {
                    $pagesInFile = $mpdf->SetSourceFile($fileName);
                    for ($i = 1; $i <= $pagesInFile; $i++) {
                        $tplId = $mpdf->ImportPage($i);
                        $mpdf->UseTemplate($tplId);
                        if (($fileNumber < $filesTotal) || ($i != $pagesInFile)) {
                            $mpdf->WriteHTML('<pagebreak />');
                        }
                    }
                }
                $fileNumber++;
            }

            return $mpdf->Output('', 'S');

        }

    }

}
