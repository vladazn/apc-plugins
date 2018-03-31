<?php


namespace ApcSubscription\Subscriber;

use Doctrine\Common\Collections\ArrayCollection;
use Enlight\Event\SubscriberInterface;
use SwagEvents\Components\NameClass3;
use SwagEvents\Components\NameClass4;

class OrderSubscriber implements SubscriberInterface
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
            'sOrder::sSaveOrder::after' => 'onSaveOrder',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Account' => 'onAccountOrders',
            'Shopware_CronJob_DailySubscription' => 'onDailyCheck'
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
        if(empty($orderNumber)){
            return;
        }

        $sql = 'SELECT `id`, `orderID`, `articleordernumber` FROM `s_order_details` WHERE `ordernumber` = ? ; ';
        $articles = Shopware()->Db()->fetchAll($sql,array($orderNumber));
        $sql = 'SELECT `deliverydate_date` FROM `s_order_attributes` WHERE `orderID` = (SELECT `id` FROM `s_order` WHERE `ordernumber` = ?) ; ';
        $deliveryDate = Shopware()->Db()->fetchOne($sql,array($orderNumber));

        foreach($articles as $article){

            $sql = 'SELECT * FROM `s_articles_attributes` WHERE `articledetailsID` = (SELECT `id` FROM `s_articles_details` WHERE `ordernumber` = ?) ; ';
            $details = Shopware()->Db()->fetchRow($sql,array($article['articleordernumber']));
            if($details['is_subscription'] != 1){
                continue;
            }

            if(empty($deliveryDate)){
                $next = 'next '.$details['create_day'];
                $nextOrder = date('Y-m-d', strtotime($next));
            }else{
                $nextOrder = date('Y-m-d', strtotime($deliveryDate));
            }


            $sql = 'INSERT INTO `s_plugin_subscription_details`
                    SET
                    `duration_1` = :duration_1,
                    `duration_type_1` = :duration_type_1,
                    `cycle_1` = :cycle_1,
                    `cycle_type_1` = :cycle_type_1,
                    `active_1` = :active_1,
                    `duration_2` = :duration_2,
                    `duration_type_2` = :duration_type_2,
                    `cycle_2` = :cycle_2,
                    `cycle_type_2` = :cycle_type_2,
                    `active_2` = :active_2,
                    `next_order_date` = :next_order_date,
                    `user_id` = :user_id,
                    `detail_id` = :detail_id,
                    `order_id` = :order_id,
                    `paused_untill` = :paused_untill,
                    `orders_count` = :orders_count,
                    `parent_id` = :parent_id
            ;';

            Shopware()->Db()->query($sql,[
                'duration_1' => $details['duration_1'],
                'duration_type_1' => $details['duration_type_1'],
                'cycle_1' => $details['cycle_1'],
                'cycle_type_1' => $details['cycle_type_1'],
                'active_1' => $details['active_1'],
                'duration_2' => $details['duration_2'],
                'duration_type_2' => $details['duration_type_2'],
                'cycle_2' => $details['cycle_2'],
                'cycle_type_2' => $details['cycle_type_2'],
                'active_2' => $details['active_2'],
                'next_order_date' => $nextOrder,
                'user_id' => Shopware()->Session()->get('sUserId'),
                'detail_id' => $article['id'],
                'order_id' => $article['orderID'],
                'paused_untill' => '0000-00-00',
                'orders_count' => '0',
                'parent_id' => '0'
            ]);

        }


    

    }

    public function onAccountOrders(\Enlight_Event_EventArgs $args){
        $controller = $args->getSubject();
        $request = $controller->Request();

        $actionName = $request->getActionName();

        if($actionName != 'orders'){
            return;
        }

        $view = $controller->View();
        $view->addTemplateDir($this->pluginDir.'/Resources/views/');
        $page = $request->sPage;

        $orderData = Shopware()->Modules()->Admin()->sGetOpenOrderData(0,100);

        $sql = 'SELECT * FROM `s_plugin_subscription_details` WHERE `user_id` = ?';
        $params = Shopware()->Db()->fetchAll($sql, array(Shopware()->Session()->get('sUserId')));


        foreach($params as $param){
            $subData[$param['detail_id']] = $param;
            if(strtotime($param['paused_untill']) > strtotime(date('Y-m-d'))){
                $subData[$param['detail_id']]['paused'] = 1;
            }else{
                $subData[$param['detail_id']]['paused'] = 0;
            }
            if($param['parent_id'] == 0){
                continue;
            }
            $allSubs[] = $param['order_id'];
            $sub[$param['order_id']] = $param['parent_id'];
        }

        foreach($orderData['orderData'] as $value){
            $data[$value['id']] = $value;
        }

        foreach($data as $key => &$order){
            if(in_array($key,$allSubs)){
                $data[$sub[$key]]['subs'][] = $order;
                unset($data[$key]);
            }
        }
        $view->assign('subscriptionData',$subData);
        $view->sOpenOrders = $data;
        $view->sNumberPages = $orderData['numberOfPages'];
        $view->sPages = $orderData['pages'];



        $view->loadTemplate('frontend/account/orders.tpl');

    }

    public function onDailyCheck(){
        Shopware()->Container()->get('apc_subscription.subscription_component')->checkForOrder();
    }






}
