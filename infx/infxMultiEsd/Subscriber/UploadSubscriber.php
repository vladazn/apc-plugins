<?php

namespace infxMultiEsd\Subscriber;

use Doctrine\Common\Collections\ArrayCollection;
use infxMultiEsd\Components\DownloadComponent;
use Enlight\Event\SubscriberInterface;

class UploadSubscriber implements SubscriberInterface
{
    private $pluginDir = null;

    public function __construct($pluginBaseDirectory)
    {
        $this->pluginDir = $pluginBaseDirectory;
    }
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatch_Backend_Article' => 'onEsdUpload',
            'Enlight_Controller_Action_PostDispatch_Frontend' => 'onFrontendPostDispatch',
        ];
    }

    /**
     * @param \Enlight_Event_EventArgs $args
     *
     * @return ArrayCollection
     */
    public function onEsdUpload(\Enlight_Event_EventArgs $args){
        $controller = $args->getSubject();
        $request = $controller->Request();

        $actionName = $request->getActionName();
        if($actionName != 'uploadEsdFile'){
            return;
        }
        $component = new DownloadComponent;
        $component->checkFiles();

        return;

    }
    public function onFrontendPostDispatch(\Enlight_Event_EventArgs $args){
        $controller = $args->getSubject();
        $view = $controller->View();
        $view->addTemplateDir($this->pluginDir.'/Resources/views/');

        return;

    }


}
