<?php

namespace ShopwarePlugins\GcEmotionComponents\Bootstrap;

use ShopwarePlugins\GcEmotionComponents\Components\Emotion;

/**
 * Updates existing versions of the plugin
 *
 * Class Update
 * @package ShopwarePlugins\GcEmotionComponents\Bootstrap
 */
class Update {

    private $bootstrap = null;
    private $version = null;
    private $emotionComponent = null;

    /**
     * Constructor method of class
     */
    public function __construct() {
        $this->bootstrap = $this->Plugin();
        $this->emotionComponent = $this->getEmotionComponent();
    }

    /**
     * Runs plugin update
     */
    public function run($version) {
        $this->version = $version;
        $this->registerEvents();
        $this->emotionComponent->createEmotionComponents($version);
        
        if (version_compare($this->version, '1.0.0', '<=')) {
           
        }
        
        return array('success' => true, 'invalidateCache' => array('backend', 'frontend'));
    }

    /**
     * Registers Events
     * @return bool
     */
    private function registerEvents() {
        return true;
    }
    
    /**
     * Returns emotion component instance
     * @return object
     */
    private function getEmotionComponent() {
        return Emotion::getInstance($this->bootstrap);
    }

    /**
     * @return \Shopware_Plugins_Frontend_GcEmotionComponents_Bootstrap
     */
    private function Plugin() {
        return Shopware()->Plugins()->Frontend()->GcEmotionComponents();
    }

}
