<?php

namespace ShopwarePlugins\GenCustomSearch\Subscriber;

use \Enlight\Event\SubscriberInterface;

class Search implements SubscriberInterface {

    private $bootstrap = null;

    public function __construct($bootstrap) {
        $this->bootstrap = $bootstrap;
    }

    public static function getSubscribedEvents() {
        return array(
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_AjaxSearch' => 'onPostDispatchSearch',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Search' => 'onPostDispatchSearch'
        );
    }
   
    /**
     * subscriber to Enlight_Controller_Front_StartDispatch
     */
    public function onPostDispatchSearch(\Enlight_Controller_ActionEventArgs $args) {
        $controller = $args->getSubject();
        $view = $controller->View();
        $request = $controller->Request();
        $configs = $this->bootstrap->Config();
        $shop = Shopware()->Shop();
        
        $catId = $shop->get("parentID");
        if(!$view->hasTemplate()) {
            return;
        }
        
        $actionName = strtolower($request->getActionName());
        
        $view->addTemplateDir($this->bootstrap->Path() . 'Views');
        
        if($actionName == 'index' || $actionName == 'defaultsearch') {
            
            $term = $request->getParam('sSearch');
            
            if($configs["genShowCategorySearch"]) {
                $sql = "SELECT `description`, `id`, `path`, `cmstext` FROM `s_categories` WHERE `description` LIKE ? AND `active` = 1 ;";
                $genCategories = Shopware()->Db()->fetchAll($sql,array('%' . $term . '%'));
                
                foreach($genCategories as $key => &$genCategory) {
                    
                    $genCategory["categoryImage"] = Shopware()->Modules()->Categories()->sGetCategoryContent($genCategory['id'])["media"]["source"];
                    
                    if(!empty($genCategory["path"])) {
                        $path = explode("|", $genCategory["path"]);
                        if(!in_array($catId,$path)) {
                            unset($genCategories[$key]);
                        }
                    }
                }
                $viewAssignments['genCategory'] = $genCategories;
            } else {
                $viewAssignments['genHideCategorySearch'] = true;
            }
            
            if($configs["genShowShopPageSearch"]) {
                $sql = "SELECT `id` FROM `s_core_shops` WHERE `category_id` = ? ;";
                $shopId = Shopware()->Db()->fetchOne($sql, $catId);
                    
                $sql = "SELECT `description`, `id`, `shop_ids` FROM `s_cms_static` WHERE `description` LIKE ? ;";
                $genShopPageCustom = Shopware()->Db()->fetchAll($sql,array('%' . $term . '%'));
                foreach($genShopPageCustom as $key => $entry) {
                    if(!empty($entry["shop_ids"])) {
                        $shopIds = explode("|", $entry["shop_ids"]);
                        
                        if(!in_array($shopId,$shopIds)){
                            unset($genShopPageCustom[$key]);
                        }
                    }
                }
                $viewAssignments['genShopPageCustom'] = $genShopPageCustom;
                
                $sql = "SELECT `name`, `id`, `shop_ids` FROM `s_cms_support` WHERE `name` LIKE ? ;";
                
                $genShopPageForm = Shopware()->Db()->fetchAll($sql,array('%' . $term . '%'));
                
                foreach($genShopPageForm as $key => $entry) {
                    if(!empty($entry["shop_ids"])) {
                        $shopIds = explode("|", $entry["shop_ids"]);
                        if(!in_array($shopId,$shopIds)){
                            unset($genShopPageForm[$key]);
                        }
                    }
                }
                
                $viewAssignments['genShopPageForm'] = $genShopPageForm;
            } else {
                $viewAssignments['genHideShopPageSearch'] = true;
            }
            $view->assign($viewAssignments);
        }
    }
    
    /**
     * @return \Shopware_Plugins_Core_GenCustomSearch_Bootstrap
     */
    private function Plugin() {
        return Shopware()->Plugins()->Core()->GenCustomSearch();
    }
    
}
