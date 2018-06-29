<?php

namespace TimeAmazonIntegration\Subscriber;

use Enlight\Event\SubscriberInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\Query;
use TimeAmazonIntegration\Components\Orders;
use TimeAmazonIntegration\Components\OrderStatus;
use TimeAmazonIntegration\Components\Inventory;
use TimeAmazonIntegration\Components\ApiClient;
use TimeAmazonIntegration\Components\ShopwareOrder;

class CronSubscriber implements SubscriberInterface
{

    private $pluginDir = null;
    private $component = null;
    private $params = null;
    private $db = null;
    private $orderComponent = null;
    private $endpoint = null;

    public function __construct(){
        $this->db = Shopware()->Db();
    }
   /**
    * @return array
    */
    public static function getSubscribedEvents(){
        return [
             // 'sOrder::handleESDOrder::replace' => 'onEsdOrderHandle',
        ];
    }

    public function getUserIdByOrder($orderId){
        $sql = 'SELECT `userID` FROM `s_order` WHERE `id` = ?;';
        return Shopware()->Db()->fetchOne($sql,$orderId);
    }

    public function onEsdOrderHandle(\Enlight_Event_EventArgs $args)
    {
        list($basketRow, $orderID, $orderDetailsID) = $args->getArgs();
        $subject = $args->getSubject();
        if($subject->sUserData){
            return $subject->executeParent($args->getMethod(),[$basketRow, $orderID, $orderDetailsID]);
        }
        $userId = $this->getUserIdByOrder($orderID);
        $userEmail = $this->getUserEmailById($userId);
        $quantity = $basketRow['quantity'];
        $basketRow['assignedSerials'] = [];
        // Check if current order number is an esd variant.
        $esdArticle = $subject->getVariantEsd($basketRow['ordernumber']);
        if (!$esdArticle['id']) {
            return $basketRow;
        }
        if (!$esdArticle['serials']) {
            // No serial number is needed
            $subject->db->insert('s_order_esd', [
                'serialID' => 0,
                'esdID' => $esdArticle['id'],
                'userID' => $userId,
                'orderID' => $orderID,
                'orderdetailsID' => $orderDetailsID,
                'datum' => new Zend_Db_Expr('NOW()'),
            ]);
            return $basketRow;
        }
        $availableSerials = $subject->getAvailableSerialsOfEsd($esdArticle['id']);
        if ((count($availableSerials) <= $subject->config->get('esdMinSerials')) || count($availableSerials) <= $quantity) {
            // Not enough serial numbers anymore, inform merchant
            $context = [
                'sArticleName' => $basketRow['articlename'],
                'sMail' => $userEmail,
            ];
            $mail = Shopware()->TemplateMail()->createMail('sNOSERIALS', $context);
            if ($subject->config->get('sESDMAIL')) {
                $mail->addTo($subject->config->get('sESDMAIL'));
            } else {
                $mail->addTo($subject->config->get('sMAIL'));
            }
            $mail->send();
        }
        // Check if enough serials are available, if not, an email has been sent, and we can return
        if (count($availableSerials) < $quantity) {
            return $basketRow;
        }
        for ($i = 1; $i <= $quantity; ++$i) {
            // Assign serial number
            $serialId = $availableSerials[$i - 1]['id'];
            // Update basket row
            $basketRow['assignedSerials'][] = $availableSerials[$i - 1]['serialnumber'];
            $subject->db->insert('s_order_esd', [
                'serialID' => $serialId,
                'esdID' => $esdArticle['id'],
                'userID' => $userId,
                'orderID' => $orderID,
                'orderdetailsID' => $orderDetailsID,
                'datum' => new Zend_Db_Expr('NOW()'),
            ]);
        }
        return $basketRow;
    }


}
