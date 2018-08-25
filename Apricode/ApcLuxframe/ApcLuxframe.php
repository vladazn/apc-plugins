<?php
namespace ApcLuxframe;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\UninstallContext;

class ApcLuxframe extends Plugin{
   //
   //  public function install(InstallContext $context){
   //     $service = $this->container->get('shopware_attribute.crud_service');
   //     $this->generateAttributes($service);
   // }
   //
   // public function uninstall(UninstallContext $context){
   //     $service = $this->container->get('shopware_attribute.crud_service');
   //     $this->removeAttributes($service);
   // }

    private function generateAttributes($service){
        $service->update('s_articles_attributes', 'apc_is_luxframe', 'boolean', [
            'label' => 'Is Luxframe',
            'displayInBackend' => true,
            'custom' => true,
            'position' => 0,
        ]);
        $service->update('s_articles_attributes', 'base_price', 'string', [
            'label' => 'cm2 Price',
            'displayInBackend' => true,
            'custom' => true,
            'position' => 0,
        ]);
        $service->update('s_articles_attributes', 'apc_price_seilsystem', 'string', [
            'label' => '1cm2 - 10mm - Seilsystem',
            'displayInBackend' => true,
            'custom' => true,
            'position' => 0,
        ]);
        $service->update('s_articles_attributes', 'apc_price_stand', 'string', [
            'label' => '1cm2  - 10mm - Standfüße',
            'displayInBackend' => true,
            'custom' => true,
            'position' => 0,
        ]);

        $service->update('s_order_details_attributes', 'apc_height', 'string', [
            'label' => 'Height',
            'displayInBackend' => true,
            'custom' => true,
            'position' => 0,
        ]);
        $service->update('s_order_details_attributes', 'apc_width', 'string', [
            'label' => 'Width',
            'displayInBackend' => true,
            'custom' => true,
            'position' => 0,
        ]);
        $service->update('s_order_details_attributes', 'apc_media', 'multi_selection', [
            'label' => 'Media',
            'entity' => 'Shopware\Models\Media\Media',
            'displayInBackend' => true,
            'custom' => true,
            'position' => 0,
        ]);

        $service->update('s_order_basket_attributes', 'apc_height', 'string', [
            'label' => 'Height',
            'displayInBackend' => true,
            'custom' => true,
            'position' => 1,
        ]);
        $service->update('s_order_basket_attributes', 'apc_width', 'string', [
            'label' => 'Width',
            'displayInBackend' => true,
            'custom' => true,
            'position' => 2,
        ]);
        $service->update('s_order_basket_attributes', 'apc_media', 'multi_selection', [
            'label' => 'Media',
            'entity' => 'Shopware\Models\Media\Media',
            'displayInBackend' => true,
            'custom' => true,
            'position' => 3,
        ]);
        $service->update('s_article_configurator_options_attributes', 'apc_option_color', 'string', [
            'label' => 'Color',
            'displayInBackend' => true,
            'custom' => true,
            'position' => 2,
        ]);
    }
    private function removeAttributes($service){
        $service->delete('s_articles_attributes', 'apc_is_luxframe');
        $service->delete('s_articles_attributes', 'base_price');
        $service->delete('s_articles_attributes', 'apc_price_seilsystem');
        $service->delete('s_articles_attributes', 'apc_price_stand');
        $service->delete('s_order_details_attributes', 'apc_height');
        $service->delete('s_order_details_attributes', 'apc_width');
        $service->delete('s_order_details_attributes', 'apc_media');
        $service->delete('s_order_basket_attributes', 'apc_height');
        $service->delete('s_order_basket_attributes', 'apc_width');
        $service->delete('s_order_basket_attributes', 'apc_media');
        $service->delete('s_article_configurator_options_attributes', 'apc_option_color');
    }
}
