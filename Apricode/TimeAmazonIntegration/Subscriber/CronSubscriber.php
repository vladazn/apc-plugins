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
    private $endpoints = [
        'marketpalce_na' => 'https://mws.amazonservices.com',
        'marketpalce_eu' => 'https://mws-eu.amazonservices.com',
        'marketpalce_in' => 'https://mws.amazonservices.in',
        'marketpalce_cn' => 'https://mws.amazonservices.com.cn',
        'marketpalce_jp' => 'https://mws.amazonservices.jp',
        'marketpalce_au' => 'https://mws.amazonservices.com.au',
    ];
    private $endpoint = null;

    public function __construct(){
        $this->db = Shopware()->Db();
    }
   /**
    * @return array
    */
    public static function getSubscribedEvents(){
        return [
            'Shopware_CronJob_ApcAmazonSync' => 'onOrderSync',
            'Shopware_CronJob_ApcAmazonStatusSync' => 'onDataSync',
        ];
    }

    public function onDataSync(){
        $sql = 'SELECT * FROM `apc_amazon_users`;';
        $users = $this->db->fetchAll($sql);
        $shopareOrderComponent = new ShopwareOrder();
        $marketplaceSql = 'SELECT `marketpalce_na`,`marketpalce_jp`,`marketpalce_cn`,`marketpalce_eu`,`marketpalce_au`,`marketpalce_in` FROM `apc_amazon_users` WHERE `id` = ?;';

        foreach($users as $user){
            $this->params = [
                'awsKey' => $user['aws_key'],
                'secretKey' => $user['secret_key'],
                'MWSAuthToken' => $user['mws_auth_token'],
                'sellerId' => $user['seller_id'],
                'MarketplaceId' => $user['marketpalce_id'],
                'taxId' => 1,
                'taxRate' => $user['tax_rate'],
                'lastUpdate' => $this->db->fetchOne('SELECT `date` FROM `apc_amazon_log` ORDER BY `id` DESC')
            ];

            $marketplaces = $this->db->fetchRow($marketplaceSql,$user['id']);
                foreach($marketplaces as $key => $marketplace){
                    if(empty($marketplace)){
                        continue;
                    }
                    $this->params['marketplaceIds'] = explode(',',$marketplace);
                    $this->endpoint = $this->endpoints[$key];
                $this->syncStock();
                $this->syncOrderStatus();
            }
        }
    }

    public function onOrderSync(){
        $k = 0;
        $sql = 'SELECT * FROM `apc_amazon_users`;';
        $users = $this->db->fetchAll($sql);
        $shopareOrderComponent = new ShopwareOrder();
        $marketplaceSql = 'SELECT `marketpalce_na`,`marketpalce_jp`,`marketpalce_cn`,`marketpalce_eu`,`marketpalce_au`,`marketpalce_in` FROM `apc_amazon_users` WHERE `id` = ?;';
        $sql = 'SELECT `amazon_id` FROM `s_order_attributes` WHERE `amazon_id` IS NOT NULL;';
        $amazonOrderIds = $this->db->fetchCol($sql);
        foreach($users as $user){
            $this->params = [
                'awsKey' => $user['aws_key'],
                'secretKey' => $user['secret_key'],
                'MWSAuthToken' => $user['mws_auth_token'],
                'sellerId' => $user['seller_id'],
                'taxId' => $this->db->fetchOne('SELECT `id` FROM `s_core_tax` WHERE `tax` = ?',$user['tax_rate']),
                'taxRate' => $user['tax_rate'],
                'shopId' => $user['shop_id'],
                'customShipping' => $user['custom_shipping'],
                'lastUpdate' => $this->db->fetchOne('SELECT `date` FROM `apc_amazon_log` ORDER BY `id` DESC')
            ];
            $marketplaces = $this->db->fetchRow($marketplaceSql,$user['id']);
            foreach($marketplaces as $key => $marketplace){
                if(empty($marketplace)){
                    continue;
                }
                $this->params['marketplaceIds'] = explode(',',$marketplace);
                $this->endpoint = $this->endpoints[$key];
                $this->orderComponent = new Orders($this->params['awsKey'],$this->params['secretKey'],$this->endpoint);
                if(!$orders = $this->getOrders()){
                    continue;
                }
                foreach($orders as $order){
                    if($order['OrderStatus'] != 'Unshipped'){
                        continue;
                    }
                    if(in_array($order['AmazonOrderId'],$amazonOrderIds)){
                        continue;
                    }
                    if($order['FulfillmentChannel'] == 'FBA'){
                        $fba = true;
                    }else{
                        $fba = false;
                    }
                    $currentOrder = [];
                    $currentOrder = [
                        'AmazonOrderId' => $order['AmazonOrderId'],
                        'date' => $order['PurchaseDate'],
                        'total' => $order['OrderTotal'],
                        'FBA' => $fba,
                        'shopId' => $this->params['shopId'],
                        'customShipping' => $this->params['customShipping'],
                        'user' => [
                            'email' => $order['BuyerEmail'],
                            'shipping_address' => $order['ShippingAddress'],
                        ]
                    ];
                    $orderDetails = $this->getOrderDetails($order['AmazonOrderId']);
                    $detailCount = 0;
                    foreach($orderDetails as $detail){
                        $currentOrder['details'][$detailCount] = [
                            'title' => $detail['Title'],
                            'seller_sku' => $detail['SellerSKU'],
                            'quantity' => $detail['QuantityOrdered'],
                            'price' => $detail['ItemPrice'],
                            'tax' => $detail['ItemTax'],
                            'shipping_price' => $detail['ShippingPrice'],
                        ];
                        $detailCount++;
                    }
                    $response = $shopareOrderComponent->addOrder($currentOrder, ['id' => $this->params['taxId'], 'rate' => $this->params['taxRate']]);
                    if($response['success'] == true){
                        $sql = 'INSERT INTO `s_order_attributes` SET `amazon_id` = ?, `orderID` = ?;';
                        $this->db->query($sql,[$order['AmazonOrderId'],$response['data']['id']]);
                        $shopareOrderComponent->handleStock();
                        $shopareOrderComponent->handleAutoShipping($response['data']['id']);
                        $shopareOrderComponent->handleEsdArticles($response['data']['id']);
                        $shopareOrderComponent->setPaymentStatus($response['data']['id']);
                        $shopareOrderComponent->esdEmailNotify($response['data']['id']);
                        $shopareOrderComponent->invoiceNotify($response['data']['id']);
                        $k++;
                    }
                }
                if(Shopware()->Config()->get('wav_canceled_orders_import')){
                    $response = $this->checkForCanceledOrders();
                    if($response > 0){
                        $k++;
                    }
                }
            }
        }
        if($k > 0){
            $this->insertlog();
        }
    }

    public function insertlog(){
        $sql = 'INSERT INTO apc_amazon_log SET `date` = ?;';
        $this->db->query($sql,date('Y-m-d H:i:s'));
    }

    public function checkForCanceledOrders(){
        if(!$orders = $this->getOrders(true)){
            return;
        }
        $k = 0;
        foreach($orders as $order){
            if($order['OrderStatus'] != 'Canceled'){
                continue;
            }
            $sql = 'UPDATE `s_order` LEFT JOIN `s_order_attributes` ON `s_order`.`id` = `s_order_attributes`.`orderID` SET `s_order`.`status` = 4, `s_order`.`cleared` = 20  WHERE `s_order_attributes`.`amazon_id` = ?;';
            $this->db->query($sql,$order['AmazonOrderId']);
            $sql = 'SELECT `s_order`.`ordernumber` FROM `s_order` LEFT JOIN `s_order_attributes` ON `s_order`.`id` = `s_order_attributes`.`orderID` WHERE `s_order_attributes`.`amazon_id` = ?;';
            $ordernumber = $this->db->fetchOne($sql,$order['AmazonOrderId']);
            if($order['FulfillmentChannel'] == 'FBA'){
                $fba = true;
            }else{
                $fba = false;
            }
            if(Shopware()->Config()->get('wav_auto_stock') && !$fba){
                $this->updateStockAfterOrderCanceled($ordernumber);
            }
            elseif(Shopware()->Config()->get('wav_auto_stock_fba') && $fba){
                $this->updateStockAfterOrderCanceled($ordernumber);
            }
            $k++;
        }
        return $k;
    }

    public function updateStockAfterOrderCanceled($ordernumber){
        $sql = 'SELECT `articleordernumber`, `quantity` FROM `s_order_details` WHERE `ordernumber` = ?;';
        $articles = $this->db->fetchAll($sql,$ordernumber);
        $sql = 'UPDATE `s_articles_details` SET `instock` = `instock` + ? WHERE `ordernumber` = ?';
        foreach($articles as $article){
            $this->db->query($sql,[$article['quantity'],$article['articleordernumber']]);
        }
    }

    public function getOrderListParam(){
        $buildParams = [
                   "AWSAccessKeyId"=> $this->params['awsKey'],
                   "Action"=> 'ListOrders',
                   "MWSAuthToken"=> $this->params['MWSAuthToken'],
                   "SellerId"=>$this->params['sellerId'],
                   "OrderStatus.Status.1"=>"Unshipped",
                   "SignatureVersion"=>"2",
                   "SignatureMethod"=>"HmacSHA256",
                   "LastUpdatedAfter"=>gmdate("Y-m-d\TH:i:s\Z",strtotime($this->params['lastUpdate'])),
        ];
        $count = 0;
        foreach($this->params['marketplaceIds'] as $id){
            $count++;
            $buildParams["MarketplaceId.Id.".$count] = $id;
        }
        return $buildParams;
    }

    public function getOrderDetailsParam($orderID){
        $buildParams = [
                   "AWSAccessKeyId"=> $this->params['awsKey'],
                   "Action"=> 'ListOrderItems',
                   "MWSAuthToken"=> $this->params['MWSAuthToken'],
                   "SellerId"=>$this->params['sellerId'],
                   "AmazonOrderId"=>$orderID,
                   "SignatureVersion"=>"2",
                   "SignatureMethod"=>"HmacSHA256",
                   "LastUpdatedAfter"=>gmdate("Y-m-d\TH:i:s\Z",strtotime($this->params['lastUpdate'])),
        ];
        $count = 0;
        foreach($this->params['marketplaceIds'] as $id){
            $count++;
            $buildParams["MarketplaceId.Id.".$count] = $id;
        }
        return $buildParams;
    }

    public function xml2array($xmlObject, $out = array ()){
        foreach ( (array) $xmlObject as $index => $node )
            $out[$index] = ( is_object ( $node ) ) ? $this->xml2array ( $node ) : $node;

        return $out;
    }
    public function getOrders($canceled = false){

        $builderParams = $this->getOrderListParam();

        if($canceled){
            $builderParams['OrderStatus.Status.1'] = 'Canceled';
        }
        $result = $this->orderComponent->getOrders($builderParams);
        $orders = $result['ListOrdersResult']['Orders']['Order'];
        if($orders['LatestShipDate']){
            $finalOrders = [$orders];
        }else{
            $finalOrders = $this->xml2array($orders);
        }

        if(empty($finalOrders)){
            return false;
        }
        return $finalOrders;
    }
    public function getOrderDetails($orderId){

        $builderParams = $this->getOrderDetailsParam($orderId);
        $response = $this->orderComponent->getOrders($builderParams);

        $orderDetails = $response['ListOrderItemsResult']['OrderItems']['OrderItem'];
        if($orderDetails['QuantityOrdered']){
            $finalOrders = [$orderDetails];
        }else{
            $finalOrders = $this->xml2array($orderDetails);
        }
        return $finalOrders;
    }

    public function syncStock(){
        $sql = 'SELECT `s_articles_details`.`instock`, `s_articles_attributes`.`seller_sku`
                    FROM `s_articles_details`
                    LEFT JOIN `s_articles_attributes`
                    ON `s_articles_details`.`id` = `s_articles_attributes`.`articledetailsID`
                    WHERE `s_articles_attributes`.`seller_sku` IS NOT NULL
                    AND `s_articles_attributes`.`sync_stock` = 1
                    ;';
        $articles = $this->db->fetchAll($sql);
        if($articles){
            $inventoryComponent = new Inventory($this->params, $this->endpoint);
            $inventoryComponent->syncArticles($articles);
        }
    }
    public function syncOrderStatus(){
        $sql = 'SELECT `s_order`.`trackingcode`, `s_order_attributes`.`amazon_id`
                    FROM `s_order`
                    LEFT JOIN `s_order_attributes`
                    ON `s_order`.`id` = `s_order_attributes`.`orderID`
                    WHERE `s_order_attributes`.`amazon_id` IS NOT NULL
                    AND `s_order_attributes`.`amazon_status_updated` IS NULL
                    AND `s_order`.`status` = 7
                    ;';
        $orders = $this->db->fetchAll($sql);
        if($orders){
            $inventoryComponent = new OrderStatus($this->params,$this->endpoint);
            $inventoryComponent->syncOrders($orders);
        }
        $sql = 'UPDATE `s_order_attributes` SET `amazon_status_updated` = 1 WHERE `amazon_id` = ?;';
        foreach($orders as $order){
            $this->db->query($sql,$order['amazon_id']);
        }
    }

}
