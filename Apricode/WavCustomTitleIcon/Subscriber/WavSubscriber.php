<?php

namespace WavCustomTitleIcon\Subscriber;

use \Enlight\Event\SubscriberInterface;

class WavSubscriber implements SubscriberInterface {

    private $router;

    public function __construct($pluginDir) {
        $this->pluginDir = $pluginDir;
        $this->router = Shopware()->Front()->Router();
    }

    public static function getSubscribedEvents() {
        return array(
            'Enlight_Controller_Action_PostDispatch' => ['onPostDispatchFront',199]
        );
    }
    public function onPostDispatchFront(\Enlight_Controller_ActionEventArgs $args) {
        $controller = $args->getSubject();
        $request = $controller->Request();
        $response = $controller->Response();
        $view = $controller->View();
        $db = Shopware()->Db();
        $footerMenu = $view->sMenu;
        $sql = 'SELECT `wav_title_icon` FROM `s_cms_static_attributes` WHERE `cmsStaticID` = ?;';
        $imageSql = 'SELECT `name`, `extension` FROM `s_media` WHERE `id` = ?;';
        foreach($footerMenu['gBottom2'] as &$page){
            $id = $db->fetchOne($sql,$page['id']);
            if($id){
                $media = $db->fetchRow($imageSql,$id);
                $page['wavTitleIconPath'] = 'media/image/'.$media['name'].'.'.$media['extension'];
            }
        }
        $view->sMenu = $footerMenu;

    }
}
