<?php

namespace ShopwarePlugins\GcEmotionComponents\Subscriber;

use Enlight\Event\SubscriberInterface;
use Doctrine\Common\Collections\ArrayCollection;

class Less implements SubscriberInterface {

    public static function getSubscribedEvents() {
        return array(
            'Theme_Compiler_Collect_Plugin_Less' => 'addLessFiles'
        );
    }

    /**
     * Provide the needed less files
     *
     * @param \Enlight_Event_EventArgs $args
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function addLessFiles(\Enlight_Event_EventArgs $args) {
        $less = new \Shopware\Components\Theme\LessDefinition(
                //configuration
                array(),
                //less files to compile
                array(
            dirname(__DIR__) . '/Views/frontend/_public/src/less/all.less'
                ),
                //import directory
                dirname(__DIR__)
        );

        return new ArrayCollection(array($less));
    }

}
