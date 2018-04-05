<?php

class Shopware_Controllers_Widgets_ApcArticleReserve extends \Enlight_Controller_Action {
    
    public function expireAction(){
        $this->get('front')->Plugins()->ViewRenderer()->setNoRender();
        $this->get('apc_article_reserve.reservation_component')->checkExpiration();
    }
    
    public function sceduleAction() {
        $sessionId = Shopware()->Session()->get('sessionId');
        $cartTimeLeft = $this->get('apc_article_reserve.reservation_component')->getCartTimeLeft($sessionId);
        $this->View()->cartTimeLeft = $cartTimeLeft;
    }
    
    public function timerAction() {
        $ordernumber = $this->Request()->getParam('ordernumber');
        $timeleft = $this->get('apc_article_reserve.reservation_component')->getTimeleft($ordernumber);
        
        $isReservedBySessionUser = $this->get('apc_article_reserve.reservation_component')->getReservedBySessionUser($ordernumber);
        $this->View()->timeleft = $timeleft;
        $this->View()->isReservedBySessionUser = $isReservedBySessionUser;
    }
}