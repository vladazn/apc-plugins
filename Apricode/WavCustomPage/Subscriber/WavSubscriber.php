<?php

namespace WavCustomPage\Subscriber;

use \Enlight\Event\SubscriberInterface;

class WavSubscriber implements SubscriberInterface {


    private $router;

    public function __construct($pluginDir) {
        $this->pluginDir = $pluginDir;
        $this->router = Shopware()->Front()->Router();
    }

    public static function getSubscribedEvents() {
        return array(
            // 'Theme_Inheritance_Template_Directories_Collected' => 'onDirCollect',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Custom' => 'onPostDispatchCustom',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Forms' => 'onPostDispatchForms'
        );
    }

    public function onDirCollect(\Enlight_Event_EventArgs $args){
        $dirs = $args->getReturn();
        $dirs[] = $this->pluginDir . '/Resources/views/';
        return $dirs;
    }
    public function onPostDispatchForms(\Enlight_Controller_ActionEventArgs $args) {
        $controller = $args->getSubject();
        $request = $controller->Request();
        $response = $controller->Response();
        $view = $controller->View();

        if($request->getParam('isCustom')){
            $view->addTemplateDir($this->pluginDir . '/Resources/views/');
        }
    }
    public function onPostDispatchCustom(\Enlight_Controller_ActionEventArgs $args) {
        $controller = $args->getSubject();
        $request = $controller->Request();
        $response = $controller->Response();
        $view = $controller->View();
        if (!$request->isDispatched() || $response->isException() || !$view->hasTemplate()) {
            return;
        }

        $id = $request->getParam('sCustom',null);
        if($id == null) {
           return;
        }

        $sql =  "SELECT
                `s_cms_static_attributes`.`wav_emotion_id`
                FROM `s_cms_static_attributes`
                WHERE
                `s_cms_static_attributes`.`cmsStaticID` = ?
                ;";

        $ids = Shopware()->Db()->fetchOne($sql,$id);
        $ids = trim($ids,'|');
        $ids = explode('|',$ids);
        if(!empty($ids)){
            $view->addTemplateDir($this->pluginDir . '/Resources/views/');
        }
       $sqlFullscreen = "SELECT `fullscreen`,`id` FROM `s_emotion` WHERE `id` IN(".str_repeat('?,',count($ids)-1)."?) ;";

       $data = Shopware()->Db()->fetchAll($sqlFullscreen,$ids);
       $topEmotion = array();
       $staticEmotions = array();
       foreach($data as $item) {
           if($item['fullscreen'] == 1) {
               $topEmotion[] = $item['id'];
               continue;
           }
           $staticEmotions[] = $item['id'];
       }

       $view->assign('wavTopEmotions',$topEmotion);
       $view->assign('wavBottomEmotions',$staticEmotions);

       $sql = "SELECT
               `s_cms_static_attributes`.`wav_form_id`
               FROM `s_cms_static_attributes`
               WHERE
               `s_cms_static_attributes`.`cmsStaticID` = ?
               ;";

       $formId = Shopware()->Db()->fetchOne($sql,$id);
       if($formId){
           $view->assign('formId',$formId);
       }
    }
}
