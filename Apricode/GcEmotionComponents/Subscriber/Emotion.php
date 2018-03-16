<?php

namespace ShopwarePlugins\GcEmotionComponents\Subscriber;

use Enlight\Event\SubscriberInterface;

class Emotion implements SubscriberInterface {

    protected $bootstrap;

    public function __construct($bootstrap) {
        $this->bootstrap = $bootstrap;
    }

    public static function getSubscribedEvents() {
        return array(
            'Enlight_Controller_Action_PostDispatch_Widgets' => array('onPostDispatchWidgetsEmotion', 100),
            'Enlight_Controller_Action_PostDispatchSecure_Widgets_Emotion' => array('onPostDispatchEmotion', 100)
        );
    }

    public function onPostDispatchWidgetsEmotion(\Enlight_Controller_ActionEventArgs $args) {
        $controller = $args->getSubject();
        $view = $controller->View();
        
        if(!$view->hasTemplate()) {
            return;
        }
        $view->addTemplateDir($this->bootstrap->Path() . 'Views/');
    }
    
    public function onPostDispatchEmotion(\Enlight_Controller_ActionEventArgs $args){
       
        $controller = $args->getSubject();
        $request = $controller->Request();
        $view = $controller->View();
        $view->addTemplateDir($this->bootstrap->Path() . 'Views/');
        
        $actionName = $request->getActionName();
        if ($actionName != "index"){
            
            $gcSliderFlag = $request->getParam('gcSlider');
            
            if($gcSliderFlag){
                $productBoxLayout = 'gcSlider';
                $view->assign('productBoxLayout',$productBoxLayout);
            }
            
        }
        
    }

}
