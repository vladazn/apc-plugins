<?php

namespace ShopwarePlugins\GenCustomSearch\Bootstrap;

class Uninstall {
    
    private $bootstrap = null;
    
    public function __construct($bootstrap) {
        $this->bootstrap = $bootstrap;
    }
    
    public function run() {
        return true;
    }
    
}

