<?php

namespace ShopwarePlugins\GcEmotionComponents\Bootstrap;

use ShopwarePlugins\GcEmotionComponents\Components\Emotion;

/**
 * Uninstaller of the plugin.
 *
 * Class Uninstall
 * @package ShopwarePlugins\GcEmotionComponents\Bootstrap
 */
class Uninstall {

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
     * Runs plugin uninstallation
     */
    public function run() {
        $this->removeTextFields();
        $this->emotionComponent->removeEmotionComponents();
        return array('success' => true, 'invalidateCache' => array('backend', 'frontend'));
    }

    private function removeTextFields() {
        try {
            $service = $this->bootstrap->get('shopware_attribute.crud_service');
            $service->delete(
                    's_emotion_attributes', 'gc_emotion_color_from'
            );
            $service->delete(
                    's_emotion_attributes', 'gc_emotion_color_to'
            );
            $service->delete(
                    's_emotion_attributes', 'gc_emotion_has_padding'
            );
           
            Shopware()->Models()->generateAttributeModels(array('s_articles_attributes'));
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
