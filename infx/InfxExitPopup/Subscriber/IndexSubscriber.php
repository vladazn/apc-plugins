<?php
namespace InfxExitPopup\Subscriber;
use Doctrine\Common\Collections\ArrayCollection;
use Enlight\Event\SubscriberInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Shopware\Components\Model\ModelManager;

class IndexSubscriber implements SubscriberInterface
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
            'Enlight_Controller_Action_PostDispatchSecure_Frontend' => 'onFrontendPostDispatch',
            'Enlight_Controller_Action_PreDispatch_Frontend_Newsletter' => 'onNewsletterPostDispatch'
        ];
    }

	public function onFrontendPostDispatch(\Enlight_Event_EventArgs $args){
		$controller = $args->getSubject();
        $view = $controller->View();
        $view->addTemplateDir($this->pluginDir.'/Resources/views/');
    }

	public function onNewsletterPostDispatch(\Enlight_Event_EventArgs $args){
		$controller = $args->getSubject();
		$request = $controller->Request();

        if($request->getParam('infx_newsletter')){
            Shopware()->Container()->get('infx_exit_popup.newsletter_component')->sendVoucher(Shopware()->System()->_POST['newsletter']);
        }
    }

}
