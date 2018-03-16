<?php

namespace ApcListing\Subscriber;

use Doctrine\Common\Collections\ArrayCollection;
use Enlight\Event\SubscriberInterface;

class ListingSubscriber implements SubscriberInterface
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
            'Enlight_Controller_Action_PostDispatch_Widgets_Listing' => 'onAjaxListing',
            'Enlight_Controller_Action_PreDispatch_Widgets_Listing' => 'onListingCount',
            'Enlight_Controller_Action_PostDispatch_Frontend' => 'onFrontendPostDispatch',
            'Enlight_Controller_Action_PostDispatch_Widgets' => 'onWidgetsPostDispatch',
        ];
    }

    /**
     * @param \Enlight_Event_EventArgs $args
     *
     * @return ArrayCollection
     */
    public function onAjaxListing(\Enlight_Event_EventArgs $args){
        $controller = $args->getSubject();
        $request = $controller->Request();
        $actionName = $request->getActionName();


        if($actionName != 'ajaxListing'){
            return;
        }
        if(empty($request->getParam('style'))){
            return;
        }
        $view = $controller->View();
        $view->productBoxLayout = $request->getParam('style');

     }

    public function onFrontendPostDispatch(\Enlight_Event_EventArgs $args){
        $controller = $args->getSubject();

        $view = $controller->View();
        $view->currency = Shopware()->Shop()->getCurrency()->getSymbol();
    }

    public function onListingCount(\Enlight_Event_EventArgs $args){
        $controller = $args->getSubject();
        $request = $controller->Request();
        $actionName = $request->getActionName();

        if($actionName != 'listingCount'){
            return;
        }
        $request->setPost('currency',Shopware()->Shop()->getCurrency()->getSymbol());
    }
    
    public function onWidgetsPostDispatch(\Enlight_Event_EventArgs $args){
        $controller = $args->getSubject();

        $view = $controller->View();
        $view->currency = Shopware()->Shop()->getCurrency()->getSymbol();
    }






}
