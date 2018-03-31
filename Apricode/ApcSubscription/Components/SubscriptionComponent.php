<?php

namespace ApcSubscription\Components;

class SubscriptionComponent
{

    private $days = [
        '1' => 1,
        '2' => 7,
        '3' => 30,
        '4' => 365
    ];

    public function checkForOrder(){


        $sql = 'SELECT * FROM `s_plugin_subscription_details` WHERE `next_order_date` <= ? AND `completed` IS NULL;';
        $activeSubscriptions = Shopware()->Db()->fetchAll($sql,array(date('Y-m-d')));

        foreach($activeSubscriptions as $data){
            $this->placeOrder($data);
        }
    }

    private function placeOrder($data){

        $this->saveOrder($data);
        $this->scheduleNextOrder($data);

    }

    private function scheduleNextOrder($data){
        $sql = 'SELECT COUNT(*) FROM `s_plugin_subscription_details` WHERE `parent_id` = ? ;';
        $count = Shopware()->Db()->fetchOne($sql,array($data['detail_id']));

        $sql = 'UPDATE `s_plugin_subscription_details` SET `next_order_date` = `next_order_date` + INTERVAL ? DAY WHERE `id` = ? ;';
        if($this->checkIntervalSwitch($data,$count-1)){
            Shopware()->Db()->query($sql,array(($data['cycle_2']*$this->days[$data['cycle_type_2']]),$data['id']));
            return;
        }elseif($this->checkForIntervalOne($data,$count-1)){
            Shopware()->Db()->query($sql,array(($data['cycle_1']*$this->days[$data['cycle_type_1']]),$data['id']));
            return;
        }elseif($this->checkForIntervalTwo($data,$count-1)){
            Shopware()->Db()->query($sql,array(($data['cycle_2']*$this->days[$data['cycle_type_2']]),$data['id']));
            return;
        }else{
            $sql = 'UPDATE `s_plugin_subscription_details` SET `completed` = 1, `next_order_date` = NULL WHERE `id` = ?;';
            Shopware()->Db()->query($sql,array($data['id']));
            $sql = 'UPDATE `s_order` SET `status` = 2 WHERE `id` = ?;';
            Shopware()->Db()->query($sql,[$data['order_id']]);
            return;
        }

    }

    private function checkForIntervalOne($data,$count){
        if($data['active_1'] != 1){
            return false;
        }
        $cycleCount = ($data['duration_1']*$this->days[$data['duration_type_1']])/($data['cycle_1']*$this->days[$data['cycle_type_1']]);
        if($count < $cycleCount){
            return true;
        }

        return false;

    }


    private function checkIntervalSwitch($data,$count){
        if($data['active_1'] != 1){
            return false;
        }
        if($data['active_2'] != 1){
            return false;
        }
        $cycleCount = ($data['duration_1']*$this->days[$data['duration_type_1']])/($data['cycle_1']*$this->days[$data['cycle_type_1']]);
        if($count == $cycleCount){
            return true;
        }

        return false;

    }


    private function checkForIntervalTwo($data,$count){
        if($data['active_2'] != 1){
            return false;
        }

        $cycleCount = 0;
        $cycleCount += ($data['duration_1']*$this->days[$data['duration_type_1']])/($data['cycle_1']*$this->days[$data['cycle_type_1']]);
        $cycleCount += ($data['duration_2']*$this->days[$data['duration_type_2']])/($data['cycle_2']*$this->days[$data['cycle_type_2']]);

        if($count <= $cycleCount-1){
            return true;
        }

        return false;

    }

    public function saveOrder($data){
        $tables = [
            's_order',
            's_order_billingaddress',
            's_order_details',
            's_order_shippingaddress'
        ];

        $sql = 'SELECT * FROM `s_order` WHERE `id` = ? ;';
        $order = Shopware()->Db()->fetchRow($sql,array($data['order_id']));
        $ordernumber = Shopware()->Container()->get('shopware.number_range_incrementer')->increment('invoice');
        $order['ordernumber'] = $ordernumber;
        $order['invoice_amount'] = 0;
        $order['invoice_amount_net'] = 0;
        $order['invoice_shipping'] = 0;
        $order['invoice_shipping_net'] = 0;
        $order['ordertime'] = date('Y-m-d H:i:s');
        unset($order['id']);

        foreach($order as $column => $value){
            $columns .= $column.', ';
            $values .= '"'.$value.'", ';
        }
        $columns = substr($columns, 0, -2);
        $values = substr($values, 0, -2);
        $sql = 'INSERT INTO `s_order` ('.$columns.') VALUES ('.$values.')';
        Shopware()->Db()->query($sql);

        $orderId = Shopware()->Db()->lastInsertId();
        $sql = 'INSERT INTO `s_order_attributes` SET `orderID` = ?';
        Shopware()->Db()->query($sql,array($orderId));

        //billingaddress
        $columns = '';
        $values = '';
        $sql = 'SELECT * FROM `s_order_billingaddress` WHERE `orderID` = ? ;';
        $billingaddress = Shopware()->Db()->fetchRow($sql,array($data['order_id']));
        unset($billingaddress['id']);
        $billingaddress['orderID'] = $orderId;

        foreach($billingaddress as $column => $value){

            $columns .= $column.', ';
            $values .= '"'.$value.'", ';
        }
        $columns = substr($columns, 0, -2);
        $values = substr($values, 0, -2);
        $sql = 'INSERT INTO `s_order_billingaddress` ('.$columns.') VALUES ('.$values.') ;';
        Shopware()->Db()->query($sql);
        $sql = 'INSERT INTO `s_order_billingaddress_attributes` SET `billingID` = ?';
        Shopware()->Db()->query($sql,array(Shopware()->Db()->lastInsertId()));

        //order details
        $columns = '';
        $values = '';

        $sql = 'SELECT * FROM `s_order_details` WHERE `id` = ? ;';
        $details = Shopware()->Db()->fetchRow($sql,array($data['detail_id']));
        unset($details['id']);
        $details['orderID'] = $orderId;
        $details['ordernumber'] = $ordernumber;
        $details['price'] = 0;

        foreach($details as $column => $value){

            $columns .= $column.', ';
            $values .= '"'.$value.'", ';
        }
        $columns = substr($columns, 0, -2);
        $values = substr($values, 0, -2);
        $sql = 'INSERT INTO `s_order_details` ('.$columns.') VALUES ('.$values.') ;';
        Shopware()->Db()->query($sql);

        $sql = 'INSERT INTO `s_order_details_attributes` SET `detailID` = ?';
        Shopware()->Db()->query($sql,array(Shopware()->Db()->lastInsertId()));

        //shipping address
        $columns = '';
        $values = '';

        $sql = 'SELECT * FROM `s_order_shippingaddress` WHERE `orderID` = ? ;';
        $shippingaddress = Shopware()->Db()->fetchRow($sql,array($data['order_id']));
        unset($shippingaddress['id']);
        $shippingaddress['orderID'] = $orderId;

        foreach($shippingaddress as $column => $value){

            $columns .= $column.', ';
            $values .= '"'.$value.'", ';
        }
        $columns = substr($columns, 0, -2);
        $values = substr($values, 0, -2);
        $sql = 'INSERT INTO `s_order_shippingaddress` ('.$columns.') VALUES ('.$values.') ;';
        Shopware()->Db()->query($sql);
        $sql = 'INSERT INTO `s_order_shippingaddress_attributes` SET `shippingID` = ?';
        Shopware()->Db()->query($sql,array(Shopware()->Db()->lastInsertId()));

        // s_plugin_subscription_details

        $sql = 'INSERT INTO `s_plugin_subscription_details` SET `order_id` = ?, `parent_id` = ?, `user_id` = ?;
                UPDATE `s_plugin_subscription_details` SET `orders_count` = `orders_count` + 1 WHERE `id` = ?;
        ';
        Shopware()->Db()->query($sql,array($orderId,$data['order_id'],$data['user_id'], $data['id']));

        // Order details
        $sql = 'SELECT * FROM `s_plugin_subscription_details` WHERE `id` = ?;';
        $details = Shopware()->Db()->fetchRow($sql,array($data['id']));

        $sql = 'UPDATE `s_order_attributes` SET
                    `index_number` = ?,
                    `parent_order_number` = (SELECT `ordernumber` FROM `s_order` WHERE `id` = ? ),
                    `order_days` = ?
                    WHERE `orderID` = ?
                ;';

        $count = $details['orders_count']-1;
        if($details['active_1']){
            $cycleCount = ($details['duration_1']*$this->days[$details['duration_type_1']])/($details['cycle_1']*$this->days[$details['cycle_type_1']]);
            if($count <= $cycleCount){
                $days = $count*$this->days[$details['cycle_type_1']];
            }else{
                if($details['active_2']){
                    $days = (($count-$cycleCount)*$this->days[$details['cycle_type_2']]);
                }
            }
        }elseif($details['active_2']){
                $days = $count * $this->days[$details['cycle_type_2']];
        }

        if($days >= 365 ){
            $finalDay = floor($days/365).' years';
        }elseif($days >= 30){
            $finalDay = floor($days/30).' months';
        }elseif($days >= 7){
            $finalDay = floor($days/7).' weeks';
        }else{
            $finalDay = $days.' days';
        }

        $params = [
            $details['orders_count'],
            $details['order_id'],
            $finalDay,
            $orderId
        ];

        Shopware()->Db()->query($sql,$params);

    }

    private function checkExpiration($data){
        $sql = 'SELECT * FROM `s_plugin_subscription_details` WHERE `id` = ? ;';
        $order = Shopware()->Db()->fetchRow($sql,array($data['id']));
        if($order['active_1']*$order['duration_1'] + $order['active_2']*$order['duration_2'] != $order['orders_count']){
            return false;
        }


        return true;
    }

}
