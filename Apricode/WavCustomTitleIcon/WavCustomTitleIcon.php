<?php
namespace WavCustomTitleIcon;
use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\UninstallContext;

class WavCustomTitleIcon extends Plugin{

    public function install(InstallContext $context){
        $service = $this->container->get('shopware_attribute.crud_service');
        // $this->generateAttributes($service);
    }

    public function activate(ActivateContext $activateContext)
    {
        $activateContext->scheduleClearCache($footerMenu::CACHE_LIST_DEFAULT);
    }

    public function uninstall(UninstallContext $context){
        $service = $this->container->get('shopware_attribute.crud_service');
        // $this->removeAttributes($service);
    }

    private function generateAttributes($service){
       $service->update('s_cms_static_attributes', 'wav_title_icon', 'single_selection', [
           'label' => 'Title Icon',
           "entity" => "Shopware\Models\Media\Media",
           "displayInBackend" => true,
           "custom" => true,
       ]);
   }

   private function removeAttributes($service){
       $service->delete('s_cms_static_attributes', 'wav_title_icon');
   }
}
