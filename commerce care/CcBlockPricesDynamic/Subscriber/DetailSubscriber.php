<?php

namespace CcBlockPricesDynamic\Subscriber;

use Enlight\Event\SubscriberInterface;
use Shopware\Components\Plugin\ConfigReader;

class DetailSubscriber implements SubscriberInterface {
    
    private $pluginDirectory = null;
    
    private $config = null;
    
    public function __construct($pluginName, $pluginDirectory, ConfigReader $configReader) {
        $this->pluginDirectory = $pluginDirectory;
        $this->config = $configReader->getByPluginName($pluginName);
    }

    public static function getSubscribedEvents() {
        return array( 
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Detail' => 'onPostDispatchDetail'
        );
    }
    
    public function onPostDispatchDetail(\Enlight_Controller_ActionEventArgs $args) {
        $controller = $args->get('subject');
        $request = $controller->Request();
        $response = $controller->Response();
        $view = $controller->View();
        if (!$request->isDispatched() || $response->isException() || !$view->hasTemplate() ) {
            return;
        }
        
        $view->addTemplateDir($this->pluginDirectory . '/Resources/views');
        $view->assign('CcPluginConfig',$this->config);
    }
}