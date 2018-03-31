<?php

namespace ShopwarePlugins\GenCustomSearch\Bootstrap;

class Install {
    
    private $bootstrap = null;
    
    /**
     * Constructor method of class
     */
    public function __construct($bootstrap) {
        $this->bootstrap = $bootstrap;
    }
    
    public function run() {
        $this->createConfig();
        $this->subscribeEvents();
        return array('success' => true, 'invalidateCache' => array('backend', 'frontend'));
    }
    
    private function subscribeEvents() {
        $this->bootstrap->subscribeEvent('Enlight_Controller_Front_StartDispatch','onStartDispatch');
    }
    
    private function createConfig(){    
        
        $form = $this->bootstrap->Form();
        
        $form->setElement('boolean', 'genShowCategorySearch', array(
                'label' => 'Make a Category search',
                'value' => true,
                'required' => false
            )
        );
        
        $form->setElement('boolean', 'genShowShopPageSearch', array(
                'label' => 'Make a Shop Pages search',
                'value' => true,
                'required' => false
            )
        );
        
        //contains all translations
        $translations = array(
            'en_GB' => array(
                'genShowCategorySearch' => 'Make a Category search',
                'genShowShopPageSearch' => 'Make a Shop Pages search'
            ),
            'de_DE' => array(
                'genShowCategorySearch' => 'Suche in Kategorien',
                'genShowShopPageSearch' => 'Suche in den Shop-Seiten'
            )
            
        );

        $this->bootstrap->addFormTranslations($translations);
        
    }
}

