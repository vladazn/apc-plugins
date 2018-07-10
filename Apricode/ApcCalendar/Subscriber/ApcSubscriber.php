<?php
namespace ApcCalendar\Subscriber;
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
            'Theme_Inheritance_Template_Directories_Collected' => 'onDirCollect',
        ];
    }

    public function onDirCollect(\Enlight_Event_EventArgs $args){
        $dirs = $args->getReturn();
        $dirs[] = $this->pluginDir . '/Resources/views/';
        return $dirs;
    }
}
