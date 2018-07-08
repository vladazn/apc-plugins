<?php
namespace WavCustomPage;
use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\UninstallContext;

class WavCustomPage extends Plugin{

    public function install(InstallContext $context){
        $service = $this->container->get('shopware_attribute.crud_service');
        $this->generateAttributes($service);
    }

    public function activate(ActivateContext $activateContext)
    {
        $activateContext->scheduleClearCache(InstallContext::CACHE_LIST_ALL);
    }

    public function uninstall(UninstallContext $context){
        $service = $this->container->get('shopware_attribute.crud_service');
        $this->removeAttributes($service);
    }

    private function generateAttributes($service){
       $service->update('s_cms_static_attributes', 'wav_emotion_id', 'single_selection', [
           'label' => 'Emotion',
           "entity" => "Shopware\Models\Emotion\Emotion",
           "displayInBackend" => true,
           "custom" => true,
       ]);
       $service->update('s_cms_static_attributes', 'wav_form_id', 'single_selection', [
           'label' => 'Form',
           "entity" => "Shopware\Models\Form\Form",
           "displayInBackend" => true,
           "custom" => true,
       ]);
   }

   private function removeAttributes($service){
       $service->delete('s_cms_static_attributes', 'wav_emotion_id');
       // $service->delete('s_cms_static_attributes', 'wav_form_id');
   }
}
