<?php
namespace TimeAmazonIntegration\Components;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\Query;
use TimeAmazonIntegration\Components\AmazonUrlBuilder;
use TimeAmazonIntegration\Components\Transformers\DataTransformerFactory;
use TimeAmazonIntegration\Components\CurlHttpRequest;


class Inventory {

    private $container;
    private $params;
    private $urlBuilder = NULL;
	private $dataTransformer = NULL;
    private $mErrors = array();
    private $aws_key = NULL;
    private $secret_key = NULL;
    private $end_point = "https://mws-eu.amazonservices.com/Orders";

    public function __construct($params, $endpoint) {
        $this->params = $params;
        $this->end_point = $endpoint.'/Feeds/';
    }

    public function syncArticles($articles){
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
        $param['MWSAuthToken']       = $amazonMWSAuthToken;
        $param['FeedType']       = '_POST_INVENTORY_AVAILABILITY_DATA_';
        $param['SignatureMethod']    = 'HmacSHA256';
        $param['SignatureVersion']   = '2';
        $param['Timestamp']          = gmdate("Y-m-d\TH:i:s.\\0\\0\\0\\Z", time());
        $param['Version']            = '2009-01-01';
        $count = 0;
        foreach($amazonMarketPlaceIds as $amazonMarketPlaceId){
            $count++;
            $param['MarketplaceIdList.Id.'.$count] = $amazonMarketPlaceId;
        }
        $param['PurgeAndReplace']    = 'false';

        $secret = $amazonSecretKey;

        $url = array();
        foreach ($param as $key => $val) {

            $key = str_replace("%7E", "~", rawurlencode($key));
            $val = str_replace("%7E", "~", rawurlencode($val));
            $url[] = "{$key}={$val}";
        }
        $amazon_feed = $this->buildXml($articles,$amazonSellerId);

        //echo $amazon_feed;exit;
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

    public function buildXml($articles,$amazonSellerId){
        $xml = '<?xml version="1.0" encoding="utf-8"?>
        <AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
            <Header>
                <DocumentVersion>1.02</DocumentVersion>
                <MerchantIdentifier>'.$amazonSellerId.'</MerchantIdentifier>
            </Header>
            <MessageType>Inventory</MessageType>';
        $count = 0;
        foreach($articles as $article){
            $count++;
            $xml .='<Message>
                            <MessageID>'.$count.'</MessageID>
                            <OperationType>Update</OperationType>
                            <Inventory>
                                <SKU>'.$article['seller_sku'].'</SKU>
                                <Quantity>'.$article['instock'].'</Quantity>
                            </Inventory>
                        </Message>';
        }
        $xml .= '</AmazonEnvelope>';
        return $xml;
    }

}
?>
