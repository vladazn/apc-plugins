<?php

class Shopware_Controllers_Widgets_InfxExitPopup extends \Enlight_Controller_Action {
	
	public function indexAction() {
		$configs = $this->get('cached_config_reader')->getByPluginName('InfxExitPopup',Shopware()->Shop());
		
	}
	
}