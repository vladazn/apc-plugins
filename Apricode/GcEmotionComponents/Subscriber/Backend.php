<?php

namespace ShopwarePlugins\GcEmotionComponents\Subscriber;

use Enlight\Event\SubscriberInterface;

class Backend implements SubscriberInterface {

    protected $bootstrap;

    public function __construct($bootstrap) {
        $this->bootstrap = $bootstrap;
    }

    public static function getSubscribedEvents() {
        return array(
            'Enlight_Controller_Action_PostDispatchSecure_Backend_Emotion' => array('onPostDispatchBackendEmotion', 100),
        );
    }

    /**
     * Post Dispatch Backend
     * @return void
     */
    public function onPostDispatchBackendEmotion(\Enlight_Controller_ActionEventArgs $arguments) {
        $controller = $arguments->getSubject();
        $request = $controller->Request();
        $View = $controller->View();
        $View->addTemplateDir($this->bootstrap->Path() . 'Views/');
        
        if ($request->getActionName() == 'index') {
            $View->extendsTemplate('backend/gc_slider/GcExtendApp.js');
        }

        $View->extendsTemplate('backend/emotion/view/detail/elements/gc_banner_slider.js');
        $View->extendsTemplate('backend/emotion/view/detail/elements/gc_textelement.js');
        $View->extendsTemplate('backend/emotion/view/detail/elements/gc_newsletter_widget.js');
        $View->extendsTemplate('backend/emotion/view/detail/elements/gc_partner_element.js');
        $View->extendsTemplate('backend/emotion/view/detail/elements/gc_content_block.js');
        $View->extendsTemplate('backend/emotion/view/detail/elements/gc_category_module.js');
        $View->extendsTemplate('backend/emotion/view/detail/elements/gc_category_module.js');
        

    }

}
