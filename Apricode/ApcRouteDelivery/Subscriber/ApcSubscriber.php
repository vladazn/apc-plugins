<?php

namespace ApcRouteDelivery\Subscriber;

use Enlight\Event\SubscriberInterface;


class ApcSubscriber implements SubscriberInterface
{

    private $pluginDir = null;
    private $component = null;

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
            'Shopware_CronJob_RouteDailyCheck' => 'onRouteCheck'
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
        }elseif(strtolower($actionName) == 'shippingpayment'){
            $view = $controller->View();
            $userData = $view->sUserData;

            $sql = 'SELECT `apc_routes`.`new_date` FROM `apc_routes`
                    LEFT JOIN `apc_routes_zip` ON `apc_routes_zip`.`route_id` = `apc_routes`.`id`
                    WHERE `apc_routes_zip`.`zip` = ?
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
