<?php
namespace TimeAmazonIntegration\Components;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\Query;
use TimeAmazonIntegration\Components\AmazonUrlBuilder;
use TimeAmazonIntegration\Components\Transformers\DataTransformerFactory;
use TimeAmazonIntegration\Components\CurlHttpRequest;
use Shopware\Models\Order\Order;

class ShopwareOrder {

    private $container;
    private $config;
    private $client;
    private $db;
    private $shopId;

    public function __construct() {
        $this->config = Shopware()->Config();
		$this->client = new ApiClient(
		    //URL of shopware REST server
		    $this->config->get('wav_api_url'),
		    //Username
		    $this->config->get('wav_api_username'),
		    //User's API-Key
            $this->config->get('wav_api_key')
		);
        $this->db = Shopware()->Db();
        $this->fbaStatus = $this->db->fetchOne('SELECT `id` FROM `s_core_states` WHERE `name` = "apc_amazon_fba"');
        $this->fbaShipping = $this->db->fetchOne('SELECT `id` FROM `s_premium_dispatch` WHERE `name` = "Amazon FBA"');
    }

    public function getCustomerData($user){
        $sql = 'SELECT `id` FROM `s_user` WHERE `email` = ?;';
        $userId = $this->db->fetchOne($sql,$user['email']);

        if(!empty($userId)){
            return [
                'id' => $userId,
                'address' => $this->getAddress($user)
            ];
        }

        return $this->addUser($user);
    }

    public function getAddress($user){
        $countryId = $this->db->fetchOne('SELECT `id` FROM `s_core_countries` WHERE `countryiso` = ?',$user['shipping_address']['CountryCode']);
        $words = explode(' ', $user['shipping_address']['Name']);
        $lastName = array_pop($words);
        $firstName = implode(' ', $words);
        $billingAddress = [
            'firstname' => $firstName,
            'lastname' => $lastName,
            'salutation' => 'mr',
            'street' => $user['shipping_address']['AddressLine2'],
            'city' => $user['shipping_address']['City'],
            'zipcode' => $user['shipping_address']['PostalCode'],
            'country' => $countryId
        ];
        return $billingAddress;
    }

    public function addUser($user){
        $billingAddress = $this->getAddress($user);
        $postData = array(
            'email' => $user['email'],
            'firstname' => $billingAddress['firstname'],
            'lastname' => $billingAddress['lastname'],
            'salutation' => 'mr',
            'billing' => $billingAddress
        );
        $result = $this->client->post('customers',  $postData);
        if($result['success'] == false){
            return false;
        }
        $customer = [
            'id' => $result['data']['id'],
            'address' => $billingAddress,
        ];
        $sql = 'UPDATE `s_user` SET `customergroup` = "APCAC" WHERE `id` = ?;';
        $this->db->query($sql,[$customer['id']]);
        return $customer;
    }

    public function addOrder($order, $tax){
        $this->shopId = $order['shopId'];
        $customer = $this->getCustomerData($order['user']);
        if($customer == false){
            return;
        }
        $address = $customer['address'];
        $details = $this->getOrderDetails($order['details'],$tax);
        $addressInfo = [
            "customerId" => $customer['id'],
            "countryId" => $address['country'],
            "salutation" => "mr",
            "firstName" => $address['firstname'],
            "lastName" => $address['lastname'],
            "street" => $address['street'],
            "zipCode" => $address['zipcode'],
            "city" => $address['city'],
            "stateId" => 3,
        ];
        $postData = [
            "customerId" => $customer['id'],
            "paymentId" => $this->db->fetchOne('SELECT `id` FROM `s_core_paymentmeans` WHERE `name` = "apc_amazon"'),
            "dispatchId" => $order['FBA']?$this->fbaShipping:$order['customShipping'],
            "partnerId" => "",
            "shopId" => $order['shopId'],
            "invoiceAmount" => $order['total']['Amount'],
            "invoiceAmountNet" => $order['total']['Amount'],
            "invoiceShipping" => 0,
            "invoiceShippingNet" => 0,
            "orderTime" => date('Y-m-d H:i:s', strtotime($order['date'])),
            "net" => 0,
            "taxFree" => 0,
            "languageIso" => "1",
            "currency" => $order['total']['CurrencyCode'],
            "currencyFactor" => 1,
            "details" => $details,
            "documents" => [],
            "billing" => $addressInfo,
            "shipping" => $addressInfo,
            "paymentStatusId" => 17,
            "orderStatusId" => $order['FBA']?$this->fbaStatus:0
        ];
        $this->details = $details;
        return $response = $this->client->post('orders', $postData);

    }

    public function setPaymentStatus($orderId){
        $em = Shopware()->Models();
        $order = $em->getRepository('Shopware\Models\Order\Order')->findOneById($orderId);
        if(empty($order)){
            return;
        }
        $paymentStatus = $em->getRepository('Shopware\Models\Order\Status')->findOneById(12);
        $order->setPaymentStatus($paymentStatus);
        $em->persist($order);
        $em->flush();
    }

    public function handleStock($details = null){
        $details = $this->details;
        $sql = 'UPDATE `s_articles_details` SET `instock` = `instock` + ? WHERE `ordernumber` =?;';
        if($order['FBA'] && !$this->config->get('wav_auto_stock_fba')){
            foreach($details as $detail){
                $this->db->query($sql,[$detail['quantity'],$detail['articleNumber']]);
            }
        }
        if(!$order['FBA'] && !$this->config->get('wav_auto_stock')){
            foreach($details as $detail){
                $this->db->query($sql,[$detail['quantity'],$detail['articleNumber']]);
            }
        }
    }

    public function handleEsdArticles($orderID){
        $details = $this->details;
        $orderDetailSql = 'SELECT `id` FROM `s_order_details` WHERE `orderID` = ? AND `articleordernumber` = ?;';
        foreach($details as $detail){
            if($detail['esdArticle'] != 1){
                continue;
            }
            $esdArticle = $this->getVariantEsd($detail['articleNumber']);
            if(!$esdArticle['id']) {
                continue;
            }
            $availableSerials = $this->getAvailableSerialsOfEsd($esdArticle['id']);
            if (count($availableSerials) < $detail['quantity']) {
                return;
            }
            for ($i = 1; $i <= $detail['quantity']; ++$i) {
                // Assign serial number
                $serialId = $availableSerials[$i - 1]['id'];
                // Update basket row
                $basketRow['assignedSerials'][] = $availableSerials[$i - 1]['serialnumber'];
                $this->db->insert('s_order_esd', [
                    'serialID' => $serialId,
                    'esdID' => $esdArticle['id'],
                    'userID' => $this->getUserIdByOrder($orderID),
                    'orderID' => $orderID,
                    'orderdetailsID' => $this->db->fetchOne($orderDetailSql,[$orderID,$detail['articleNumber']]),
                    'datum' => new \Zend_Db_Expr('NOW()'),
                ]);
            }
        }
    }

    private function getUserIdByOrder($orderId){
        $sql = 'SELECT `userID` FROM `s_order` WHERE `id` = ?;';
        return Shopware()->Db()->fetchOne($sql,$orderId);
    }

    private function getVariantEsd($orderNumber)
    {
        return $this->db->fetchRow(
            'SELECT s_articles_esd.id AS id, serials
            FROM  s_articles_esd, s_articles_details
            WHERE s_articles_esd.articleID = s_articles_details.articleID
            AND   articledetailsID = s_articles_details.id
            AND   s_articles_details.ordernumber= :orderNumber',
            [':orderNumber' => $orderNumber]
        );
    }

    private function getAvailableSerialsOfEsd($esdId)
    {
        return $this->db->fetchAll(
            'SELECT s_articles_esd_serials.id AS id, s_articles_esd_serials.serialnumber as serialnumber
            FROM s_articles_esd_serials
            LEFT JOIN s_order_esd
              ON (s_articles_esd_serials.id = s_order_esd.serialID)
            WHERE s_order_esd.serialID IS NULL
            AND s_articles_esd_serials.esdID= :esdId',
            ['esdId' => $esdId]
        );
    }

    public function handleAutoShipping($id){
        $details = $this->details;
        $sql = 'SELECT `s_articles_attributes`.`auto_shipping` FROM `s_articles_attributes` LEFT JOIN `s_articles_details`
                    ON `s_articles_attributes`.`articledetailsID` = `s_articles_details`.`id` WHERE `s_articles_details`.`ordernumber` = ?';
        foreach($details as $detail){
            $test = $this->db->fetchOne($sql,$detail['articleNumber']);
            if($test != 1){
                return;
            }
        }
        $sql = 'UPDATE `s_order` SET `status` = 7 WHERE `id` = ?';
        $this->db->query($sql,$id);
    }

    public function esdEmailNotify($id){
        Shopware()->Events()->notify(
                'Apc_Send_Esd_Mail',
                [
                    'id' => $id,
                    'shopId' => $this->shopId,
                ]
            );
    }
    public function invoiceNotify($id){
        $orderNumber = $this->db->fetchOne('SELECT `ordernumber` FROM `s_order` WHERE `id` = ?;',$id);
        Shopware()->Events()->filter(
                'Apc_Amazon_Order_Save',
                $orderNumber,
                [
                    'id' => $id,
                    'shopId' => $this->shopId,
                ]
            );
    }

    public function getOrderDetails($details,$tax){
        $articles = [];
        $sql = 'SELECT `s_articles`.`id` as `articleId`,
                    `s_articles_details`.`ordernumber` AS `articleNumber`,
                    `s_articles`.`name` AS `articleName`
                    FROM `s_articles` LEFT JOIN `s_articles_details`
                    ON `s_articles_details`.`articleID` = `s_articles`.`id`
                    LEFT JOIN `s_articles_attributes`
                    ON `s_articles_attributes`.`articledetailsID` = `s_articles_details`.`id`
                    WHERE `s_articles_attributes`.`seller_sku` = ?
                ;';
        $count = 0;
        $esdSql = 'SELECT COUNT(*) FROM `s_articles_esd` WHERE `articleID` = ?;';
        foreach($details as $detail){
            $detailsData = $this->db->fetchRow($sql,$detail['seller_sku']);
            $articles[$count] = $detailsData;
            $articles[$count]['quantity'] = $detail['quantity'];
            $articles[$count]['price'] = $detail['price']['Amount'];
            $articles[$count]['statusId'] = 0;
            $articles[$count]['shipped'] = 0;
            $articles[$count]['stateId'] = 0;
            $articles[$count]['taxId'] = $tax['id'];
            $articles[$count]['taxRate'] = $tax['rate'];
            $articles[$count]['esdArticle'] = $this->db->fetchOne($esdSql,$detailsData['articleId']);
            $count++;
        }

        return $articles;
    }

}
?>
