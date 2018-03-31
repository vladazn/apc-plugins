<?php
class Shopware_Controllers_Frontend_Subscription extends Enlight_Controller_Action
{
    public function pauseAction()
    {
        $this->View()->addTemplateDir(__DIR__ . '/../../Resources/views/');
        $this->View()->loadTemplate('frontend/subscription/pause.tpl');

        $data = $this->Request()->getParams();

        if(!in_array($data['select'],[1,2,3,4])){
            $this->View()->assign('message','Some Error Occured');
            return;
        }

        $sql = 'SELECT COUNT(*) FROM `s_plugin_subscription_details` WHERE `detail_id` = ? AND `user_id` = ? ;';
        if(Shopware()->Db()->fetchOne($sql,array($data['detailId'],Shopware()->Session()->get('sUserId'))) == 0){
            $this->View()->assign('message','Some Error Occured');
            return;
        }

        $sql = 'SELECT `next_order_date` FROM `s_plugin_subscription_details` WHERE `detail_id` = ? AND  `paused_untill` < NOW();';
        $nextOrder = Shopware()->Db()->fetchOne($sql,array($data['detailId']));
        if(empty($nextOrder)){
            $this->View()->assign('message','Some Error Occured');
            return;
        }

        $days = [
            '1' => 1*7,
            '2' => 2*7,
            '3' => 4*7,
            '4' => 6*7,
        ];

        $pausedUntill = date('Y-m-d', strtotime($nextOrder.' + '.$days[$data['select']].' days'));

        $sql = 'UPDATE `s_plugin_subscription_details`
                    SET `paused_untill` = ?,
                    `next_order_date` = ?
                    WHERE `detail_id` = ? ; ';
        Shopware()->Db()->query($sql,array($pausedUntill,$pausedUntill,$data['detailId']));

         $this->View()->assign('message','Your subscription is paused untill '.$pausedUntill);

    }

}
