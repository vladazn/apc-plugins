<?php
namespace ApcLuxframe\Subscriber;

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
            'Enlight_Controller_Action_PostDispatchSecure_Frontend_Detail' => 'onDetailIndex',
            'Shopware_Modules_Basket_AddArticle_Added' => 'onAddArticle',
            'Shopware_Modules_Basket_UpdateArticle_FilterSqlDefault' => 'onBasktUpdateSql',
            // 'sOrder::sSaveOrder::after' => 'onSaveOrder'
        ];
    }

    public function onDirCollect(\Enlight_Event_EventArgs $args){
        $dirs = $args->getReturn();
        $dirs[] = $this->pluginDir . '/Resources/views/';
        return $dirs;
    }

    public function onDetailIndex(\Enlight_Event_EventArgs $args){
        $controller = $args->getSubject();
        $request = $controller->Request();
        $view = $controller->View();
        $article = $view->sArticle;
        $params = $request->getParams();
        $sql = 'SELECT `apc_is_luxframe`
                FROM `s_articles_attributes`
                WHERE `articledetailsID` = (SELECT `id` FROM `s_articles_details` WHERE `ordernumber` = ?);';
        $article['apc_is_luxframe'] = Shopware()->Db()->fetchOne($sql,$article['mainVariantNumber']);
        if(!$article['apc_is_luxframe']){
            return;
        }
        $params = $request->getParams();
        // var_dump($params);exit;
        if($params['width']){
            $params['lightbox_size_width'] = $params['width'];
        }
        if($params['height']){
            $params['lightbox_size_height'] = $params['height'];
        }
        $sql = 'SELECT `base_price`
                FROM `s_articles_attributes`
                WHERE `articledetailsID` = (SELECT `id` FROM `s_articles_details` WHERE `ordernumber` = ?);';

        $article['base_price'] = Shopware()->Db()->fetchOne($sql,$article['mainVariantNumber']);
        $article['lightbox_size_width'] = $params['lightbox_size_width']?$params['lightbox_size_width']:500;
        $article['lightbox_size_height'] = $params['lightbox_size_height']?$params['lightbox_size_height']:500;
        $factor = $article['lightbox_size_height']*$article['lightbox_size_width'];
        $sql = 'SELECT `apc_price_seilsystem` AS `seilsystem`,
                `apc_price_stand` AS `stand`
                FROM `s_articles_attributes`
                WHERE `articledetailsID` = (SELECT `id` FROM `s_articles_details` WHERE `ordernumber` = ?);';

        $stand = $article['sConfigurator'][2];
        $tief = $article['sConfigurator'][1];
        $additionalPrices = Shopware()->Db()->fetchRow($sql,$article['mainVariantNumber']);
        if($stand['selected_value'] == 6){
            $addPrice = $additionalPrices['stand']*$factor;
        }elseif($stand['selected_value'] == 7){
            $addPrice = $additionalPrices['seilsystem']*$factor;
        }else{
            $addPrice = 0;
        }
        $addPrice *= intval($tief['values'][$tief['selected_value']]['optionname'])/10;
        $article['price_numeric'] = $article['price'] - (500*500*$article['base_price']) + $article['base_price']*$factor + $addPrice;
        if($params['group']){
            foreach($article['sConfigurator'] as &$config){
                $config['customer_selected'] = intval($params['group'][$config['groupID']]);
            }
        }else{
            $article['price_numeric'] = 0;
        }

        $article['price'] = number_format($article['price_numeric'], 2, ',', '');
        // var_dump($article);exit;
        $mediaId = $request->getParam('lightbox_media');
        if($mediaId > 0){
            $sql = 'SELECT `path` FROM `s_media` WHERE `id` = ?;';
            $mediaPath = Shopware()->Db()->fetchOne($sql, $mediaId);
            $article['custom_media'] = $mediaPath;
            $article['custom_media_id'] = $mediaId;
        }
        $view->sArticle = $article;

        $view->preselected = $request->getParam('preselected');
    }

    public function onBasktUpdateSql(\Enlight_Event_EventArgs $args){
        // var_dump(123);exit;
        $mainSql = $args->getReturn();
        $id = $args->get('id');
        $grossPrice = $args->get('price');
        $netPrice = $args->get('netprice');
        $currencyFactor = $args->get('currencyFactor');
        $quantity = $args->get('quantity');
        $netPriceFactor = $grossPrice / $netPrice;
        // var_dump($grossPrice,$netPrice);exit;
        $request = Shopware()->Front()->Request();
        $width = $request->getParam('lightbox_size_width');
        $height = $request->getParam('lightbox_size_height');
        $db = Shopware()->Db();
        $sql = 'SELECT `apc_is_luxframe` FROM `s_articles_attributes` WHERE `articledetailsID` = (
                    SELECT `id` FROM `s_articles_details` WHERE `kind` = 1 AND `articleID` = (
                         SELECT `articleID` FROM `s_order_basket` WHERE `id` = ?)
                 );';
        $luxframe = $db->fetchOne($sql,$id);
        if(!$luxframe){
            return;
        }
        $sql = 'SELECT `base_price` FROM `s_articles_attributes` WHERE `articledetailsID` = (
                    SELECT `id` FROM `s_articles_details` WHERE `kind` = 1 AND `articleID` = (
                         SELECT `articleID` FROM `s_order_basket` WHERE `id` = ?)
                 );';
         $basePrice = $db->fetchOne($sql,$id);
         $unitPrice = $grossPrice;
         $sql = 'SELECT `apc_height`, `apc_width` FROM  `s_order_basket_attributes` WHERE `basketID` = ?;';
         $params = $db->fetchRow($sql, $id);
         $factor = $params['apc_height'] * $params['apc_width'];
         $unitPrice = $unitPrice - 500*500*$basePrice + ($basePrice*$factor);

         $addPrice = $this->getAddPriceByBasketId($id,$factor,$db);

         $grossPriceNew = $unitPrice+$addPrice;
         $netPriceNew = $grossPriceNew / $netPriceFactor;
         $sql = 'UPDATE s_order_basket SET quantity = ?,
                 price = ? + '.($grossPriceNew-$grossPrice).',
                 netprice = ? + '.($netPriceNew-$netPrice).', currencyFactor = ?, tax_rate = ? WHERE id = ? AND sessionID = ? AND modus = 0 ';
         $args->setReturn($sql);
    }

    public function getAddPriceByBasketId($id, $factor, $db){
        $productData = $db->fetchRow('SELECT `ordernumber`, `articleID` FROM `s_order_basket` WHERE `id` = ?;',$id);
        $article = Shopware()->Modules()->Articles()->sGetArticleById($productData['articleID'],3,$productData['ordernumber']);
        $sql = 'SELECT `apc_price_seilsystem` AS `seilsystem`,
                `apc_price_stand` AS `stand`
                FROM `s_articles_attributes`
                WHERE `articledetailsID` = (SELECT `id` FROM `s_articles_details` WHERE `ordernumber` = ?);';

        $stand = $article['sConfigurator'][2];
        $tief = $article['sConfigurator'][1];
        $additionalPrices = $db->fetchRow($sql,$article['mainVariantNumber']);
        if($stand['selected_value'] == 6){
            $addPrice = $additionalPrices['stand']*$factor;
        }elseif($stand['selected_value'] == 7){
            $addPrice = $additionalPrices['seilsystem']*$factor;
        }else{
            $addPrice = 0;
        }
        $addPrice *= intval($tief['values'][$tief['selected_value']]['optionname'])/10;
        return $addPrice;
    }



    public function onAddArticle(\Enlight_Event_EventArgs $args){
        // var_dump(123);exit;
        $id = $args->get('id');
        $request = Shopware()->Front()->Request();
        $width = $request->getParam('lightbox_size_width');
        $height = $request->getParam('lightbox_size_height');
        $mediaId = $request->getParam('lightbox_media');

        $width = $width?$width:500;
        if($width < 500){
            $width = 500;
        }elseif($width > 4000){
            $width = 4000;
        }

        $height = $height?$height:500;
        if($height < 500){
            $height = 500;
        }elseif($height > 4000){
            $height = 4000;
        }
        $db = Shopware()->Db();
        if($mediaId < 0){
            $sql = 'UPDATE `s_order_basket_attributes` SET `apc_height` = ?, `apc_width` = ? WHERE `basketID` = ?;';
            $db->query($sql,[$width, $height, $id]);
        }else{
            $sql = 'UPDATE `s_order_basket_attributes` SET `apc_height` = ?, `apc_width` = ?, apc_media = ? WHERE `basketID` = ?;';
            $db->query($sql,[$width, $height, $mediaId, $id]);
        }
    }

    public function getBoxParams($request){
        $width = $request->getParam('lightbox_size_width');
        $height = $request->getParam('lightbox_size_height');

        $width = $width?$width:500;
        if($width < 500){
            $width = 500;
        }elseif($width > 4000){
            $width = 4000;
        }

        $height = $height?$height:500;
        if($height < 500){
            $height = 500;
        }elseif($height > 4000){
            $height = 4000;
        }
        return [$width, $height];
    }
}
