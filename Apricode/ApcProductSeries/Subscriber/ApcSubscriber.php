<?php

namespace ApcProductSeries\Subscriber;

use Enlight\Event\SubscriberInterface;


class ApcSubscriber implements SubscriberInterface
{

    private $pluginDir = null;

    public function __construct($pluginBaseDirectory){
        $this->pluginDir = $pluginBaseDirectory;
    }
   /**
    * @return array
    */
    public static function getSubscribedEvents(){
        return [
            'Enlight_Controller_Action_PostDispatchSecure_Frontend' => 'onPostDispatchFrontend'
        ];
    }

    public function onPostDispatchFrontend(\Enlight_Event_EventArgs $args){
        $args->getSubject()->View()->addTemplateDir($this->pluginDir . '/Resources/views/');
    }


}
