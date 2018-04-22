<?php

namespace ApcProductColors\Subscriber;

use Enlight\Event\SubscriberInterface;


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
            'Legacy_Struct_Converter_Convert_List_Product' => 'onProductConvert'
        ];
    }

    public function onDirCollect(\Enlight_Event_EventArgs $args){
        $dirs = $args->getReturn();
        $dirs[] = $this->pluginDir . '/Resources/views/';
        return $dirs;
    }

    public function onProductConvert(\Enlight_Hook_HookArgs $args){
        $article = $args->getReturn();
        $colors = $this->checkForColors($article['articleID']);
        if($colors){
            $article['add_colors'] = $colors;
        }
        $args->setReturn($article);
    }

    private function checkForColors($articleId){
        $sql = 'SELECT `s_article_configurator_options_attributes`.`add_colors` FROM `s_article_configurator_options_attributes`,
                        `s_article_configurator_option_relations`,
                        `s_articles_details`
                        WHERE `s_articles_details`.`id` = `s_article_configurator_option_relations`.`article_id`
                        AND `s_article_configurator_option_relations`.`option_id` = `s_article_configurator_options_attributes`.`optionID`
                        AND `s_articles_details`.`articleID` = ?
                ;';
        $colors = Shopware()->Db()->fetchCol($sql,$articleId);
        if(empty($colors)){
            return false;
        }
        return array_filter(array_unique($colors));
    }


}
