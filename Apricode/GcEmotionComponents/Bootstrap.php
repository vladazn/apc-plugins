<?php

/**
 * GcEmotionComponents
 *
 * @link 
 * @copyright Copyright (c) 2017, GenusCode
 * @author GenusCode;
 * @package Shopware
 * @subpackage GcEmotionComponents
 * @version 1.0.0 initial release of the plugin 
 */

use ShopwarePlugins\GcEmotionComponents\Bootstrap\Install,
    ShopwarePlugins\GcEmotionComponents\Bootstrap\Update,
    ShopwarePlugins\GcEmotionComponents\Bootstrap\Uninstall;

class Shopware_Plugins_Frontend_GcEmotionComponents_Bootstrap extends Shopware_Components_Plugin_Bootstrap {

    public function getVersion() {
        return '1.0.0';
    }

    public function getLabel() {
        return 'Gc Emotion Components';
    }
    
    /**
     * Reads Plugins Meta Information
     * @return array
     */
    public function getInfo() {
        return array(
            'version' => $this->getVersion(),
            'copyright' => 'Copyright &copy; 2017, Gc',
            'label' => $this->getLabel(),
            'source' => '',
            'autor' => 'Gc',
            'supplier' => 'Gc',
            'description' => 'Plugin for new Emotion Components',
            'support' => 'http://www.genuscode.com/',
            'link' => 'http://www.genuscode.com/'
        );
    }

    /**
     * Registers plugin namespace
     * @return void
     */
    public function afterInit() {
        Shopware()->Loader()->registerNamespace(
                'ShopwarePlugins\\GcEmotionComponents', __DIR__ . '/'
        );

    }

    public function install() {
        $install = new Install();
        return $install->run();
    }

    /**
     * Update the Plugin
     * @return bool
     */
    public function update($version) {
        $update = new Update();
        return $update->run($version);
    }

    /**
     * Uninstall the Plugin
     * @return array
     */
    public function uninstall() {
        $uninstall = new Uninstall();
        return $uninstall->run();
    }

    /**
     * Subscriber to "Enlight_Controller_Front_StartDispatch" event
     */
    public function onStartDispatch() {
        $subscribers = array(
            new \ShopwarePlugins\GcEmotionComponents\Subscriber\Backend($this),
            new \ShopwarePlugins\GcEmotionComponents\Subscriber\Emotion($this),
            new \ShopwarePlugins\GcEmotionComponents\Subscriber\Frontend($this),
            new \ShopwarePlugins\GcEmotionComponents\Subscriber\Less(),
            new \ShopwarePlugins\GcEmotionComponents\Subscriber\Javascript()
        );

        foreach ($subscribers as $subscriber) {
            $this->get('events')->addSubscriber($subscriber);
        }
    }

}
