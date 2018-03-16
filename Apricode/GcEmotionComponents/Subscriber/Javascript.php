<?php

namespace ShopwarePlugins\GcEmotionComponents\Subscriber;

use Enlight\Event\SubscriberInterface;
use Doctrine\Common\Collections\ArrayCollection;

class Javascript implements SubscriberInterface {

    public static function getSubscribedEvents() {
        return array(
            'Theme_Compiler_Collect_Plugin_Javascript' => 'addJsFiles'
        );
    }

    /**
     * Provide the file collection for js files
     *
     * @param Enlight_Event_EventArgs $args
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function addJsFiles(\Enlight_Event_EventArgs $args) {
        $jsFiles = array(
            dirname(__DIR__) . '/Views/frontend/_public/src/js/emotion-component.js',
            dirname(__DIR__) . '/Views/frontend/_public/src/js/gc_video_component.js',
            dirname(__DIR__) . '/Views/frontend/_public/src/js/gc_product_slider.js'
        );
        return new ArrayCollection($jsFiles);
    }

}
