<?php

use Doctrine\DBAL\Driver\PDOStatement;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query\Expr\Join;
use Shopware\Components\CSRFWhitelistAware;
use ApcSubscription\Models\SubscriptionDetails;

/*
 * (c) shopware AG <info@shopware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class Shopware_Controllers_Backend_Subscriptions extends Enlight_Controller_Action implements CSRFWhitelistAware {


    private $days = [
        '1' => 1,
        '2' => 7,
        '3' => 30,
        '4' => 365
    ];

    public function preDispatch() {
        $this->get('template')->addTemplateDir(__DIR__ . '/../../Resources/views/');
    }

    public function init() {

    }

    public function postDispatch() {
        $csrfToken = $this->container->get('BackendSession')->offsetGet('X-CSRF-Token');
        $this->View()->assign([ 'csrfToken' => $csrfToken ]);
    }

    public function indexAction() {

        $types = [
            '1' => 'Days',
            '2' => 'Weeks',
            '3' => 'Months',
            '4' => 'Years'
        ];

        $sql = 'SELECT * FROM `s_plugin_subscription_details` WHERE `parent_id` = "0" ORDER BY `id` DESC  ;';
        $info = Shopware()->Db()->fetchAll($sql);

        $db = Shopware()->Db();

        foreach($info as $data){
            $orderNumber = $db->fetchOne('SELECT `ordernumber` FROM `s_order_details` WHERE `id` = ?',array($data['detail_id']));
            $articleName = $db->fetchOne('SELECT `name` FROM `s_articles` WHERE `id` = (SELECT `articleID` FROM `s_order_details` WHERE `id` = ? )',array($data['detail_id']));
            $userInfo = $db->fetchRow('SELECT `firstname`,`lastname`,`customernumber`,`email` FROM `s_user` WHERE `id` = ?',array($data['user_id']));
            if($data['completed'] == 1){
                $status = 'Completed';
            }
            elseif(strtotime($data['paused_untill']) > time()){
                $status = 'Paused';
            }else{
                $status = 'Active';
            }

            $desireDate = $db->fetchOne('SELECT `deliverydate_date` FROM `s_order_attributes` WHERE `orderID` = ?',[$data['order_id']]);
            if(empty($desireDate)){
                $desireDate = 'Not Specified';
            }
            $subscriptions[] = [
                'orderNumber' => $orderNumber,
                'articleName' => $articleName,
                'userInfo' => $userInfo,
                'next_order_date' => $data['next_order_date'],
                'paused_untill' => $data['paused_untill'],
                'status' => $status,
                'orderCount' => $data['orders_count'],
                'desiredDate' => $desireDate,
            ];
        }


        // $this->View()->loadTemplate('backend/subscription_list/index.tpl');
        $this->View()->assign('subscriptions',$subscriptions);

    }


    public function getWhitelistedCSRFActions() {
        return ['index'];
    }

}
