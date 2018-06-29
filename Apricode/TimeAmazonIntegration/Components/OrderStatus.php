<?php
namespace TimeAmazonIntegration\Components;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\Query;
use TimeAmazonIntegration\Components\AmazonUrlBuilder;
use TimeAmazonIntegration\Components\Transformers\DataTransformerFactory;
use TimeAmazonIntegration\Components\CurlHttpRequest;


class OrderStatus {

    private $container;
    private $params;
    private $urlBuilder = NULL;
	private $dataTransformer = NULL;
    private $mErrors = array();
    private $aws_key = NULL;
    private $secret_key = NULL;
    private $end_point = "https://mws-eu.amazonservices.com/Feeds";

    public function __construct($params,$endpoint) {
        $this->params = $params;
        $this->end_point = $endpoint.'/Feeds/';
    }

    public function syncOrders($orders){
        $leadTimeToShip1 = '1';
        //amazon mws credentials
        $amazonSellerId         = $this->params['sellerId'];
        $amazonMWSAuthToken     = $this->params['MWSAuthToken'];
        $amazonAWSAccessKeyId   = $this->params['awsKey'];
        $amazonSecretKey        = $this->params['secretKey'];
        $amazonMarketPlaceIds    = $this->params['marketplaceIds'];


        $param = array();
        $param['AWSAccessKeyId']     = $amazonAWSAccessKeyId;
        $param['Action']             = 'SubmitFeed';
        $param['Merchant']           = $amazonSellerId;
        $param['FeedType']           = '_POST_ORDER_FULFILLMENT_DATA_';
        $param['SignatureMethod']    = 'HmacSHA256';
        $param['SignatureVersion']   = '2';
        $param['Timestamp']          = gmdate("Y-m-d\TH:i:s.\\0\\0\\0\\Z", time());
        $param['Version']            = '2009-01-01';
        $count = 0;
        foreach($amazonMarketPlaceIds as $amazonMarketPlaceId){
            $count++;
            $param['MarketplaceId.Id.'.$count] = $amazonMarketPlaceId;
        }
        $param['PurgeAndReplace']    = 'false';

        $secret = $amazonSecretKey;

        $url = array();
        foreach ($param as $key => $val) {

            $key = str_replace("%7E", "~", rawurlencode($key));
            $val = str_replace("%7E", "~", rawurlencode($val));
            $url[] = "{$key}={$val}";
        }

        $amazon_feed = $this->buildXml($orders,$amazonSellerId);

        sort($url);

        $arr   = implode('&', $url);
        $shorturl = str_replace('https://','',$this->end_point);
        $shorturl = str_replace('/Feeds/','',$shorturl);
        $sign  = 'POST' . "\n";
        $sign .= $shorturl . "\n";
        $sign .= '/Feeds/'.$param['Version'].'' . "\n";
        $sign .= $arr;

        $signature      = hash_hmac("sha256", $sign, $secret, true);
        $httpHeader     =   array();
        $httpHeader[]   =   'Transfer-Encoding: chunked';
        $httpHeader[]   =   'Content-Type: application/xml';
        $httpHeader[]   =   'Content-MD5: ' . base64_encode(md5($amazon_feed, true));
        //$httpHeader[]   =   'x-amazon-user-agent: MyScriptName/1.0';
        $httpHeader[]   =   'Expect:';
        $httpHeader[]   =   'Accept:';

        $signature      = urlencode(base64_encode($signature));

        $link  = $this->end_point.''.$param['Version']."?";
        $link .= $arr . "&Signature=" . $signature;
        $ch = curl_init($link);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeader);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $amazon_feed);
        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        $errors=curl_error($ch);
        curl_close($ch);
    }

    public function buildXml($orders,$amazonSellerId){
        $xml = '<?xml version="1.0"?>
             <AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
             <Header>
             <DocumentVersion>1.01</DocumentVersion>
             <MerchantIdentifier>'.$amazonSellerId.'</MerchantIdentifier>
             </Header>
             <MessageType>OrderFulfillment</MessageType>';
        $count = 0;
        foreach($orders as $order){
            $trackingcode = $order['trackingcode']?$order['trackingcode']:'Shipped by Email';
            $count++;
            $xml .='<Message>
                        <MessageID>'.$count.'</MessageID>
                        <OrderFulfillment>
                            <AmazonOrderID>'.$order['amazon_id'].'</AmazonOrderID>
                            <FulfillmentDate>'.gmdate("Y-m-d\TH:i:s.\\0\\0\\0\\Z", time()).'</FulfillmentDate>
                            <FulfillmentData>
                                <CarrierName>Email</CarrierName>
                                <ShippingMethod>Standard Shipping </ShippingMethod>
                                <ShipperTrackingNumber>'.$trackingcode.'</ShipperTrackingNumber>
                            </FulfillmentData>
                        </OrderFulfillment>
                    </Message>';
        }
        $xml .= '</AmazonEnvelope>';
        return $xml;
    }

}
?>
