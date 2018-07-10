<?php

namespace ApcPrivateWebinar\Subscriber;

use \Enlight\Event\SubscriberInterface;

class ApcSubscriber implements SubscriberInterface {


    private $router;

    public function __construct($pluginDir) {
        $this->pluginDir = $pluginDir;
        $this->router = Shopware()->Front()->Router();
    }

    public static function getSubscribedEvents() {
        return array(
            'Theme_Inheritance_Template_Directories_Collected' => 'onDirCollect',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Forms' => 'onPostDispatchForms',
            'Shopware_Modules_Articles_GetArticleById_FilterResult' => 'onArticleStruct',
            'Shopware_Modules_Articles_sGetArticlesByCategory_FilterLoopEnd' => 'onArticleCategoryStructLoop',
            'Shopware_Modules_Articles_sGetArticlesByCategory_FilterResult' => 'onArticleCategoryStruct',
            'Shopware_CronJob_PrivateSeminarCheck' => 'onReminderCheck',
        );
    }

    public function onDirCollect(\Enlight_Event_EventArgs $args){
        $dirs = $args->getReturn();
        $dirs[] = $this->pluginDir . '/Resources/views/';
        return $dirs;
    }

    public function onArticleStruct(\Enlight_Event_EventArgs $args){
        $article = $args->getReturn();
        $attributes = $article['attributes']['core']->toArray();
        $userEmail = Shopware()->Session()->get('sUserMail');
        if($attributes['apc_private_webinar_active'] == 1 && $attributes['apc_private_webinar_email'] != $userEmail){
            $args->setReturn(null);
        }
        if($attributes['apc_private_webinar_active'] == 1 && empty($userEmail)){
            $args->setReturn(null);
        }
    }
    public function onArticleCategoryStructLoop(\Enlight_Event_EventArgs $args){
        $article = $args->getReturn();
        $attributes = $article['attributes']['core']->toArray();
        if($attributes['apc_private_webinar_active'] == 1 && $attributes['apc_private_webinar_email'] != $userEmail){
            $args->setReturn(null);
        }
        if($attributes['apc_private_webinar_active'] == 1 && empty($userEmail)){
            $args->setReturn(null);
        }
    }

    public function onArticleCategoryStruct(\Enlight_Event_EventArgs $args){
        $result = $args->getReturn();
        $result['sArticles'] = array_filter($result['sArticles']);
        $args->setReturn($result);
    }

    public function onPostDispatchForms(\Enlight_Controller_ActionEventArgs $args) {
        $controller = $args->getSubject();
        $request = $controller->Request();
        $response = $controller->Response();
        $view = $controller->View();

        $actionName = strtolower($request->getActionName());
        if($actionName != 'index') {
           return;
        }

        if($request->getParam('isWebinarForm')){
            $view->loadTemplate($this->pluginDir . '/Resources/views/frontend/webinarforms/index.tpl');
        }
    }

    public function onReminderCheck(){
        $db = Shopware()->Db();
        $sql = 'SELECT `apc_private_webinar_email` FROM `s_articles_attributes`
                    WHERE `apc_private_webinar_active` = 1
                    AND (`apc_private_webinar_user_notified` = 0 OR `apc_private_webinar_user_notified` IS NULL);';
        $emails = $db->fetchCol($sql);
        $sql = 'UPDATE `s_articles_attributes` SET `apc_private_webinar_user_notified` = 1 WHERE `apc_private_webinar_email` = ?;';
        foreach($emails as $email){
            $mail = Shopware()->TemplateMail()->createMail('apcPRIVATEWEBINARCONFIRM');
            $mail->addTo($email);
            $mail->send();
            $db->query($sql,$email);
        }
    }
    
}
