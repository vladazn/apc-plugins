<?php

namespace ApcArticleReserve\Components;

use Shopware\Components\Plugin\ConfigReader;

class ReservationComponent
{
    private $pluginDir = null;

    private $resTime = null;

    public function __construct($pluginName, $pluginBaseDirectory, ConfigReader $configReader)
    {
        $this->pluginDir = $pluginBaseDirectory;
        $config = $configReader->getByPluginName($pluginName);
        $this->resTime = $config['apc_reserve_time'];
        if(!is_numeric($config['apc_reserve_time'])){
            $this->resTime = 15;
        }
    }

    public function getReservedBySessionUser($ordernumber) {
        $sessionId = Shopware()->Session()->get('sessionId');
        
        $sql = "SELECT `expirationdate` FROM `apc_reserve` WHERE `ordernumber` = ? ORDER BY `expirationdate` ASC LIMIT 1 ;";
        
		$expirationdate = Shopware()->Db()->fetchOne($sql, $ordernumber);
		
		$sql = "SELECT COUNT(*) FROM `apc_reserve` WHERE `expirationdate` = ? AND `session` = ? ;";
		
        return (bool) Shopware()->Db()->fetchOne($sql, [$expirationdate, $sessionId]);
    }
    
    public function checkExpiration(){
        $expired = $this->getExpiredCarts();
        foreach($expired as $data){
            $this->removeReservation($data);
        }
        Shopware()->Events()->notify('Shopware_Plugins_HttpCache_ClearCache');
    }

    public function getExpiredCarts(){
        $date = date('Y-m-d H:i:s');
        $sql = 'SELECT * FROM `apc_reserve` WHERE `expirationdate` <= ?;';
        return Shopware()->Db()->fetchAll($sql,$date);
    }

    public function removeReservation($data){
        $this->addQuantity($data['ordernumber'],$data['quantity']);
        $this->clearBasket($data['basket_id']);
        Shopware()->Db()->query('DELETE FROM `apc_reserve` WHERE `id` = ?', $data['id']);
    }

    public function addQuantity($ordernumber,$quantity){
        $sql = 'UPDATE `s_articles_details` SET `instock` = `instock` + ? WHERE `ordernumber` = ?;';
        Shopware()->Db()->query($sql,[$quantity,$ordernumber]);
    }

    public function decreaseQuantity($ordernumber,$quantity){
        $sql = 'UPDATE `s_articles_details` SET `instock` = `instock` - ? WHERE `ordernumber` = ?;';
        Shopware()->Db()->query($sql,[$quantity,$ordernumber]);
        $this->updateSession();
    }

    public function getTimeleft($ordernumber){
        $sql = 'SELECT `expirationdate` FROM `apc_reserve` WHERE `ordernumber` = ? ORDER BY `expirationdate` ASC LIMIT 1;';
        $expDate = Shopware()->Db()->fetchOne($sql,$ordernumber);
        if(empty($expDate)){
            return 0;
        }
        $now = date('Y-m-d H:i:s');
        $timeleft = strtotime($expDate) - strtotime($now);
        return $timeleft;
    }

    public function updateSession(){
        $sessionId = Shopware()->Session()->get('sessionId');
		$sql = 'SELECT `expirationdate` FROM `apc_reserve` WHERE `session` = ?';
		$date = Shopware()->Db()->fetchOne($sql,$sessionId);
		if(empty($date)){
        	$date = date('Y-m-d H:i:s', strtotime('+'.$this->resTime.' minutes'));
		}
        $sql = 'UPDATE `apc_reserve` SET `expirationdate` = ? WHERE `session` = ?;';
        Shopware()->Db()->query($sql,[$date,$sessionId]);
    }

    public function getCartTimeLeft($sessionId) {
        $sql = 'SELECT `expirationdate` FROM `apc_reserve` WHERE `session` = ?;';
        $expDate = Shopware()->Db()->fetchOne($sql,$sessionId);
        if(empty($expDate)) {
            return 0;
        }
        $now = date('Y-m-d H:i:s');
        $timeLeft = strtotime($expDate) - strtotime($now);
        if($timeLeft < 0){
            $this->checkExpiration();
            return -1;
        }
        return $timeLeft;
    }

    public function clearBasket($id){
        $sql = 'DELETE FROM `s_order_basket` WHERE `id` = ?;';
        Shopware()->Db()->query($sql,$id);
    }

    public function getUserBasketQuantity($ordernumber){
        $sql = 'SELECT `quantity` FROM `apc_reserve` WHERE `ordernumber` = ? AND `session` = ?;';
        return Shopware()->Db()->fetchOne($sql,[$ordernumber,Shopware()->Session()->get('sessionId')]);
    }


}
