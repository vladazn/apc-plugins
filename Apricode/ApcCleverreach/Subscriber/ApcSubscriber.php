<?php
namespace ApcCleverreach\Subscriber;
use Doctrine\Common\Collections\ArrayCollection;
use Enlight\Event\SubscriberInterface;

class ApcSubscriber implements SubscriberInterface
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
            'Enlight_Controller_Dispatcher_ControllerPath_Frontend_Newsletter' => 'onGetNewsletterControllerPath',
            'Shopware_Modules_Admin_SaveRegister_Successful' => 'onRegisterSuccess'
        ];
    }

    public function onGetNewsletterControllerPath(\Enlight_Event_EventArgs $args) {
        return $this->pluginDir .  '/Controllers/Replacements/Newsletter.php';
    }

    public function onRegisterSuccess(\Enlight_Event_EventArgs $args) {
        $userId = $args->get('id');

        $sql = 'SELECT `email` FROM `s_user` WHERE `id` = ?;';
        $email = Shopware()->Db()->fetchOne($sql,$userId);
        Shopware()->Container()->get('apc_cleverreach.api')->newsletterEmail($email);
    }


}
