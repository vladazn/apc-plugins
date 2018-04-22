<?php
namespace ApcProductColors;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;


class ApcProductColors extends Plugin{

    public function install(InstallContext $context){
        $service = $this->container->get('shopware_attribute.crud_service');
        $this->generateAttributes($service);
   }

   public function uninstall(UninstallContext $context){
        $service = $this->container->get('shopware_attribute.crud_service');
        $this->removeAttributes($service);
   }

   private function generateAttributes($service){

       $service->update('s_article_configurator_options_attributes', 'add_colors', 'string', [
           'label' => 'Product Colors',
           'supportText' => 'Example: #4286f4',
           'displayInBackend' => true,
           'custom' => true,
           'position' => 0,
       ]);
   }

   private function removeAttributes($service){
       $service->delete('s_article_configurator_options_attributes', 'add_colors');
   }

}
