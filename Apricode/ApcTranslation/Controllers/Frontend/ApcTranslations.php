<?php
class Shopware_Controllers_Frontend_ApcTranslations extends \Enlight_Controller_Action {

    public function indexAction(){
        $this->get('apc_translation.csv_reader')->run();
        var_dump(123);exit;
    }

}
?>
