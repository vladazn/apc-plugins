<?php

namespace infxEsdSmsDelivery\Subscriber;

use Doctrine\Common\Collections\ArrayCollection;
use Enlight\Event\SubscriberInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Shopware\Components\Model\ModelManager;

class CheckoutSubscriber implements SubscriberInterface
{
    private $pluginDir = null;

    public function __construct($pluginBaseDirectory)
    {
        $this->pluginDir = $pluginBaseDirectory;
    }
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'sOrder::setPaymentStatus::after' => 'onPaymentStatusChange',
            'sOrder::sSaveOrder::after' => 'onSaveOrder',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Checkout' => 'onCheckoutConfirm',
            'Enlight_Controller_Action_PreDispatch_Frontend_Checkout' => 'onCheckoutFinish'
        ];
    }

    /**
     * @param \Enlight_Event_EventArgs $args
     *
     * @return ArrayCollection
     */
     public function onSaveOrder(\Enlight_Hook_HookArgs $args)
     {
         $orderNumber = $args->getReturn();
         if(empty($orderNumber))    return;
         $phone = Shopware()->Session()->get('smsPhone');
         if(empty($phone))  return;

         //send user sms
         $orderId = Shopware()->Db()->fetchOne('SELECT `id` FROM `s_order` WHERE `ordernumber` = ?',array($orderNumber));
         $sql = "UPDATE `s_order_attributes` SET `infx_confirm_sms_phone` = ? WHERE orderID = ? ;";
         Shopware()->Db()->query($sql,array($phone,$orderId));
         Shopware()->Session()->offsetSet('smsPhone','');

         //check payment status
         $availableDownloads = Shopware()->Config()->get('downloadAvailablePaymentStatus');
         $paymentStatus = Shopware()->Db()->fetchOne('SELECT `cleared` FROM `s_order` WHERE `id` = ?;',[$orderId]);
         if(!in_array($paymentStatus,$availableDownloads)){
             return;
         }

         //get serials
         $serials = $this->getSerials($orderId);

         //send message
         $message = Shopware()->Container()->get('infx_esd_sms_delivery.message_bird_api_service');
         $message->sendMessage($phone,$serials,$this->pluginDir,$orderId);

         return;

     }


     public function onCheckoutConfirm(\Enlight_Event_EventArgs $args){
         $controller = $args->getSubject();
         $request = $controller->Request();
         $actionName = $request->getActionName();
         $view = $controller->View();
        if($actionName != 'confirm'){
            return;
        }
        $view->addTemplateDir($this->pluginDir.'/Resources/views/');

        $userData = $view->sUserData;
        $phone = $userData['billingaddress']['phone'];
        if(!empty($phone)){
            $view->userPhone = $phone;
        }
        $view->smsConfirm = true;

        return;
    }

    public function onCheckoutFinish(\Enlight_Event_EventArgs $args){
        $controller = $args->getSubject();
        $request = $controller->Request();
        $actionName = $request->getActionName();
        $phone = $request->getParam('smsPhone');
        if($request->getParam('smsConfirm') && $phone){
            Shopware()->Session()->offsetSet('smsPhone',$phone);
        }
        return;
    }

    public function onPaymentStatusChange(\Enlight_Hook_HookArgs $args){

        $data = $args->getArgs();
        $orderId = $data[0];
        $paymentStatusId = $data[1];

        //check payment status
        $availableDownloads = Shopware()->Config()->get('downloadAvailablePaymentStatus');
        if(!in_array($paymentStatusId,$availableDownloads)){
            return;
        }

        //check if user phone is available
        $phone = Shopware()->Db()->fetchOne('SELECT `infx_confirm_sms_phone` FROM `s_order_attributes` WHERE `orderID` = ?',[$orderId]);
        if(empty($phone)){
            return;
        }

        //collect serials
        $serials = $this->getSerials($orderId);

        //send message
        $message = Shopware()->Container()->get('infx_esd_sms_delivery.message_bird_api_service');
        $message->sendMessage($phone,$serials,$this->pluginDir,$orderId);
        return;
    }

    public function getSerials($orderId){
        $orderDetails = Shopware()->Db()->fetchAll('SELECT `esdarticle`, `id` FROM `s_order_details` WHERE `ordernumber` = (SELECT `ordernumber` FROM `s_order` WHERE `id` = ?)',array($orderId));
        $userId = Shopware()->Db()->fetchOne('SELECT `userID` FROM `s_order` WHERE `id` = ?',[$orderId]);
        $sql = 'SELECT serialnumber FROM s_articles_esd_serials, s_order_esd
                    WHERE userID = ?
                    AND orderID = ?
                    AND orderdetailsID = ?
                    AND s_order_esd.serialID = s_articles_esd_serials.id';

        foreach($orderDetails as $detail){
            if($detail['esdarticle'] == 1){
                $getSerial = Shopware()->Db()->fetchAll($sql, [$userId, $orderId, $detail['id']]);
                foreach ($getSerial as $serial) {
                    $numbers[] = $serial['serialnumber'];
                }
            }
        }
        if(empty($numbers)){
            return;
        }
        $serials = implode($numbers,", ");

        return $serials;
    }






}
