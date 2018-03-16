<?php

namespace ShopwarePlugins\GcEmotionComponents\Bootstrap;

use ShopwarePlugins\GcEmotionComponents\Components\Emotion;

/**
 * The install class does the basic setup of the plugin. All operations should be implemented in a way
 * that they can also be run on update of the plugin
 *
 * Class Install
 * @package ShopwarePlugins\GcEmotionComponents\Bootstrap
 */
class Install {

    private $bootstrap = null;
    private $emotionComponent = null;

    /**
     * Constructor method of class
     */
    public function __construct() {
        $this->bootstrap = $this->Plugin();
        $this->emotionComponent = $this->getEmotionComponent();
    }

    /**
     * Runs plugin installation
     */
    public function run() {
        $this->registerEvents();
        $this->registerControllers();
        $this->createTextFields();
        $this->emotionComponent->createEmotionComponents();
        
        return array('success' => true, 'invalidateCache' => array('backend', 'frontend'));
    }
    
    /**
     * Registers Events
     * @return bool
     */
    private function registerEvents() {
        $this->bootstrap->subscribeEvent('Enlight_Controller_Front_StartDispatch', 'onStartDispatch');
        return true;
    }
    
    /**
    * Registers Controllers
    * @return bool
    */
    private function registerControllers(){
        $this->bootstrap->registerController('Backend','GcBannerSliderController') ;
        $this->bootstrap->registerController('Widgets','GcCategoryController') ;
        return true;
    }

    private function createTextFields() {
         try {
            $service = $this->bootstrap->get('shopware_attribute.crud_service');
            $data = array(
                "columnType" => "string",
                "tableName" => "s_emotion_attributes",
                "columnName" => "gc_emotion_color_from",
                "label" => "Background Color From",
                "translatable" => false,
                "displayInBackend" => true,
                "configured" => false,
                "custom" => true,
                "identifier" => false,
                "core" => false,
                "deleteButton" => false
            );
            $service->update(
                    $data['tableName'], $data['columnName'], $data['columnType'], $data
            );
             $data['columnName'] = 'gc_emotion_color_to' ;
             $data['label'] = 'Background Color To' ;
            $service->update(
                    $data['tableName'], $data['columnName'], $data['columnType'], $data
            );
             
             $data['columnType'] = 'boolean' ;
             $data['columnName'] = 'gc_emotion_has_padding' ;
             $data['label'] = 'Emotion has horizontal padding' ;
            $service->update(
                    $data['tableName'], $data['columnName'], $data['columnType'], $data
            );
             
             
             $data['columnType'] = 'boolean' ;
             $data['columnName'] = 'gc_emotion_has_padding_top' ;
             $data['label'] = 'Emotion has vertical padding' ;
            $service->update(
                    $data['tableName'], $data['columnName'], $data['columnType'], $data
            );
            
            Shopware()->Models()->generateAttributeModels(array('s_emotion_attributes'));
        } catch (Exception $ex) {
            return false;
        }
        return true;
    }
    
    /**
     * Returns emotion component instance
     * @return object
     */
    private function getEmotionComponent() {
        $plugin = $this->Plugin();
        $emotion = new Emotion($plugin);
        return $emotion;
    }
    
    /**
     * @return \Shopware_Plugins_Frontend_GcEmotionComponents_Bootstrap
     */
    private function Plugin() {
        return Shopware()->Plugins()->Frontend()->GcEmotionComponents();
    }
    
    
    

}
