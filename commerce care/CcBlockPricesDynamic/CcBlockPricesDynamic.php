<?php

namespace CcBlockPricesDynamic;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;

class CcBlockPricesDynamic extends Plugin {
         
     public function getVersion() {
        return '1.0.0';
     }

     public function install(InstallContext $installContext)
     {
         parent::install($installContext);
     }
 
     public function uninstall(UninstallContext $uninstallContext)
     {
         parent::uninstall($uninstallContext);
     }
 }