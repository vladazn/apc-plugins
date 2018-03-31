<?php

/**
 * GenCustomSearch plugin extends the functionality of shopware ajax search and shopware search.
 */

use ShopwarePlugins\GenCustomSearch\Bootstrap\Install,
    ShopwarePlugins\GenCustomSearch\Bootstrap\Uninstall;

class Shopware_Plugins_Core_GenCustomSearch_Bootstrap extends Shopware_Components_Plugin_Bootstrap
{

    /**
     * Get Capabilities of this plugin and return them as an array
     * @return array
     */
    public function getCapabilities() {
        return array('install' => true, 'update' => true, 'enable' => true);
    }

    public function getVersion()
    {
        return '1.0.3';
    }

    public function getLabel()
    {
        return 'GenCustomSearch';
    }

     public function getInfo() {
        return array(
            'version' => $this->getVersion(),
            'copyright' => 'Copyright &copy; 2017, GenusCode',
            'label' => $this->getLabel(),
            'source' => '',
            'autor' => 'GenusCode',
            'supplier' => 'GenusCode',
            'description' => 'The plugin extends the default functionality of the Shopware search, adding a capability to make a search for categories, subcategories, shop and support pages.',
            'support' => 'contact@genuscode.com',
            'link' => 'http://www.genuscode.com'
        );
    }
    /**
     * Registers plugin namespace
     * @return void
     */
    public function afterInit() {
        Shopware()->Loader()->registerNamespace(
                'ShopwarePlugins\\GenCustomSearch', __DIR__ . '/'
        );
    }

    /**
     * Subscriber to "Enlight_Controller_Front_StartDispatch" event
     */
    public function onStartDispatch() {

        $subscribers = array(
            new \ShopwarePlugins\GenCustomSearch\Subscriber\Search($this),
            new \ShopwarePlugins\GenCustomSearch\Subscriber\Less($this)
        );

        foreach ($subscribers as $subscriber) {
            $this->get('events')->addSubscriber($subscriber);
        }
    }

    /**
     * Install the Plugin
     * @return bool
     */
    public function install() {
        $install = new Install($this);
        return $install->run();
    }

    /**
     * Uninstall the Plugin
     * @return array
     */
    public function uninstall() {
        $uninstall = new Uninstall($this);
        return $uninstall->run();
    }

}
