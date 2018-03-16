<?php

namespace infxEsdSmsDelivery\Components;


class MessageBirdApiService {

    private $apiKey = null;

    private $originator = null;


    const BASE_URL = "https://rest.messagebird.com/messages"; // live

    public function __construct() {
        $config = Shopware()->Container()->get('shopware.plugin.config_reader')->getByPluginName('infxEsdSmsDelivery');
        $this->apiKey =  $config['api_key'];
        $this->originator =  $config['originator'];
        $this->messageText =  $config['message_text'];
    }

    public function sendMessage($recipients, $serials, $pluginDir,$orderId) {
        $this->removePhone($orderId);

        if(empty($this->apiKey) || empty($this->originator) || empty($this->messageText)){
            return;
        }
        $root = $pluginDir;
        $path = $root . '/Resources/lib/MessageBird/autoload.php';

        require_once($path);

        $MessageBird = new \MessageBird\Client($this->apiKey);
        $Message = new \MessageBird\Objects\Message();
        $Message->originator = $this->originator;
        $Message->recipients = $recipients;
        $Message->body = str_replace('[[serials]]',$serials,$this->messageText);

        $result = $MessageBird->messages->create($Message);
        return $result;
    }

    public function removePhone($orderId){
        $sql = 'UPDATE `s_order_attributes` SET `infx_confirm_sms_phone` = NULL WHERE orderID = ?';
        Shopware()->Db()->query($sql,[$orderId]);
    }

}

?>
