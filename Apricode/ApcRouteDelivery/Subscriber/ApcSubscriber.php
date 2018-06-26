<?php

namespace ApcRouteDelivery\Subscriber;

use Enlight\Event\SubscriberInterface;


class ApcSubscriber implements SubscriberInterface
{

    private $pluginDir = null;
    private $component = null;

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

    public function __construct($pluginBaseDirectory){
        $this->component = Shopware()->Container()->get('apc_route_delivery.zip_component');
        $this->pluginDir = $pluginBaseDirectory;
    }
   /**
    * @return array
    */
    public static function getSubscribedEvents(){
        return [
            'Theme_Inheritance_Template_Directories_Collected' => 'onDirCollect',
            'sOrder::sSaveOrder::after' => 'onSaveOrder',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Checkout' => 'onCheckoutFinish',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Account' => 'onOpenOrders',
            'Shopware_CronJob_RouteDailyCheck' => 'onRouteCheck',
            'Shopware_Modules_Order_SendMail_Filter' => 'onOrderMailSend'
        ];
    }

    public function onDirCollect(\Enlight_Event_EventArgs $args){
        $dirs = $args->getReturn();
        $dirs[] = $this->pluginDir . '/Resources/views/';
        return $dirs;
    }

    public function onSaveOrder(\Enlight_Hook_HookArgs $args){
        $orderNumber = $args->getReturn();
        if(empty($orderNumber)){
            return;
        }
        $this->component->assignOrder($orderNumber);

    }

    public function onOrderMailSend(\Enlight_Event_EventArgs $args){
        // $mail = $args->getReturn();
        $subject = $args->get('subject');
        $context = $args->get('context');
        $context['weeks'] = $this->weeks;
        $context['months'] = $this->months;
        $sql = 'SELECT `apc_routes`.`new_date` FROM `apc_routes`
                LEFT JOIN `apc_routes_zip` ON `apc_routes_zip`.`route_id` = `apc_routes`.`id`
                WHERE `apc_routes_zip`.`zip` = ? ORDER BY `new_date` ASC;
        ;';
        $context['apcDeliveryDate'] = Shopware()->Db()->fetchOne($sql,$context['shippingaddress']['zipcode']);
        try{

            $mail = Shopware()->TemplateMail()->createMail('sORDER', $context);
            $mail->addTo($subject->sUserData['additional']['user']['email']);
        }catch(\Exception $e){
            var_dump($e->getMessage());exit;
        }
        return $mail;

    }

    public function onCheckoutFinish(\Enlight_Event_EventArgs $args){
        $controller = $args->getSubject();
        $request = $controller->Request();
        $actionName = $request->getActionName();
        if(strtolower($actionName) == 'finish'){
            $view = $controller->View();

            $orderNumber = $view->sOrderNumber;
            if(empty($orderNumber)){
                return;
            }
            $sql = 'SELECT `s_order_attributes`.`apc_delivery_date` FROM `s_order_attributes`
                    LEFT JOIN `s_order` ON `s_order`.`id` = `s_order_attributes`.`orderID`
                    WHERE `s_order`.`ordernumber` = ?
            ;';
            $view->apcDeliveryDate = Shopware()->Db()->fetchOne($sql,$orderNumber);
        }elseif(strtolower($actionName) == 'shippingpayment' || strtolower($actionName) == 'confirm'){
            $view = $controller->View();
            $userData = $view->sUserData;
            $key = $request->getParam('debug');
            if($key){
                $this->component->sendTestOrderMail();
                // var_dump($userData);exit;
            }
            $sql = 'SELECT `apc_routes`.`new_date` FROM `apc_routes`
                    LEFT JOIN `apc_routes_zip` ON `apc_routes_zip`.`route_id` = `apc_routes`.`id`
                    WHERE `apc_routes_zip`.`zip` = ? ORDER BY `new_date` ASC;
            ;';
            $view->apcDeliveryDate = Shopware()->Db()->fetchOne($sql,$userData['shippingaddress']['zipcode']);
        }
    }

    public function onOpenOrders(\Enlight_Event_EventArgs $args){
        $controller = $args->getSubject();
        $request = $controller->Request();
        $actionName = $request->getActionName();
        if(strtolower($actionName) != 'orders'){
            return;
        }
        $view = $controller->View();

        $orders = $view->sOpenOrders;
        if(empty($orders)){
            return;
        }
        $sql = 'SELECT `s_order_attributes`.`apc_delivery_date` FROM `s_order`, `s_order_attributes`
                WHERE `s_order`.`id` = `s_order_attributes`.`orderID`
                AND `s_order`.`ordernumber` = ?
            ;';
        foreach($orders as &$order){
            $order['apcDeliveryDate'] = Shopware()->Db()->fetchOne($sql,$order['ordernumber']);
        }
        $view->sOpenOrders = $orders;
    }

    public function onRouteCheck(){
        $this->component->cronFunction();
    }

}
