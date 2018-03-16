<?php

namespace ShopwarePlugins\GcEmotionComponents\Subscriber;

use Enlight\Event\SubscriberInterface;

class Frontend implements SubscriberInterface {

    protected $bootstrap;

    public function __construct($bootstrap) {
        $this->bootstrap = $bootstrap;
    }

    public static function getSubscribedEvents() {
        return array(
            'Enlight_Controller_Action_PostDispatch_Frontend' => array('onPostDispatchFrontend', 100),
        );
    }

    public function onPostDispatchFrontend(\Enlight_Controller_ActionEventArgs $args) {
        $controller = $args->getSubject();
        $view = $controller->View();

        if(!$view->hasTemplate()) {
            return;
        }
        $view->addTemplateDir($this->bootstrap->Path() . 'Views/');
        
    }

}
