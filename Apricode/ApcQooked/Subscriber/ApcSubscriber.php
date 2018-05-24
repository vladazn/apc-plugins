<?php
namespace ApcQooked\Subscriber;

use Enlight\Event\SubscriberInterface;
use Shopware\Bundle\StoreFrontBundle\Struct;

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
            'Legacy_Struct_Converter_Convert_List_Product' => 'onProductConvert',
            'Shopware_Modules_Articles_sGetArticlesByCategory_FilterResult' => 'onProductListing',
            'Shopware_Controllers_Widgets_Listing_fetchListing_preFetch' => 'onFetchListing',
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Checkout' => 'onCheckoutConfirm'
        ];
    }

    public function onDirCollect(\Enlight_Event_EventArgs $args){
        $dirs = $args->getReturn();
        $dirs[] = $this->pluginDir . '/Resources/views/';
        return $dirs;
    }

    public function onCheckoutConfirm(\Enlight_Event_EventArgs $args){
        $controller = $args->getSubject();
        $request = $controller->Request();
        $actionName = $request->getActionName();

        if($actionName != 'confirm'){
            return;
        }

        $view = $controller->View();
        $sUserData = $view->sUserData;

        $customerGroup = $sUserData['additional']['user']['customergroup'];

        $sql = "SELECT `s_core_customergroups_attributes`.`address_change` FROM `s_core_customergroups_attributes`
                LEFT JOIN `s_core_customergroups` ON `s_core_customergroups`.`id` = `s_core_customergroups_attributes`.`customerGroupID`
                WHERE `s_core_customergroups`.`groupkey` = ?;";

        $changeAddress = Shopware()->Db()->fetchOne($sql,$customerGroup);
        $sUserData['change_address'] = $changeAddress;

        $view->sUserData = $sUserData;

    }

    public function onProductConvert(\Enlight_Event_EventArgs $args){
        $article = $args->getReturn();
        $listProduct = $args->get('product');

        $container = Shopware()->Container();
        $productContext = $container->get('shopware_storefront.context_service')->getShopContext();
        $propertyService = $container->get('shopware_storefront.property_service');
        $set = $propertyService->get($listProduct, $productContext);

        if ($listProduct->hasProperties()) {
            $properties = $container->get('legacy_struct_converter')->convertPropertySetStruct($set);
            $article['sProperties'] = $properties;
            $article['apcId'] = $properties['5']['options'][0]['id'];
        }

        $args->setReturn($article);
    }

    public function onProductListing(\Enlight_Event_EventArgs $args){
        $result = $args->getReturn();
        $result['sArticles'] = $this->array_sort($result['sArticles'], 'apcId', SORT_ASC);
        $args->setReturn($result);
    }

    public function onFetchListing(\Enlight_Event_EventArgs $args){
        $controller = $args->get('subject');
        $sArticles = $controller->View()->sArticles;
        $sArticles = $this->array_sort($sArticles, 'apcId', SORT_ASC);
        $controller->View()->sArticles = $sArticles;
    }

    private function array_sort($array, $on, $order = SORT_ASC){
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                break;
                case SORT_DESC:
                    arsort($sortable_array);
                break;
            }

            foreach ($sortable_array as $k => $v) {
                array_push($new_array, $array[$k]);
            }
        }

        return $new_array;
    }

}
