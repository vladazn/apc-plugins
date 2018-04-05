<?php
namespace ApcProductSeries;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;


class ApcProductSeries extends Plugin{

    public function install(InstallContext $context){
        $service = $this->container->get('shopware_attribute.crud_service');
        $this->generateAttributes($service);
   }

   public function uninstall(UninstallContext $context){
        $service = $this->container->get('shopware_attribute.crud_service');
        $this->removeAttributes($service);
   }

   private function generateAttributes($service){

       $service->update('s_articles_attributes', 'series_cat', 'single_selection', [
           'label' => 'Product Series',
           'displayInBackend' => true,
           'custom' => true,
           'position' => 0,
           'entity' => 'Shopware\Models\Category\Category',
       ]);
   }

   private function removeAttributes($service){
       $service->delete('s_articles_attributes', 'series_cat');
   }

}
