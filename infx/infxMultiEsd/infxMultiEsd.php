<?php

namespace infxMultiEsd;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\DeactivateContext;
use Doctrine\ORM\Tools\SchemaTool;
use Shopware\Components\Model\ModelManager;
use infxMultiEsd\Models\InfxEsdFiles;
use infxMultiEsd\Components\DownloadComponent;

class infxMultiEsd extends Plugin{

    public function install(InstallContext $context){

        $this->createDatabase();

        $service = $this->container->get('shopware_attribute.crud_service');

        $this->generateAttributes($service);

   }

   public function activate(ActivateContext $activateContext)
   {
        $component = new DownloadComponent;
        $component->checkFiles();
        $activateContext->scheduleClearCache(ActivateContext::CACHE_LIST_ALL);
   }

   public function deactivate(DeactivateContext $deactivateContext)
   {
       $deactivateContext->scheduleClearCache(DeactivateContext::CACHE_LIST_ALL);
   }

   public function uninstall(UninstallContext $context)
   {
        $this->removeDatabase();
        $service = $this->container->get('shopware_attribute.crud_service');
        $this->removeAttributes($service);

   }

   private function createDatabase()
   {
       $modelManager = $this->container->get('models');
       $tool = new SchemaTool($modelManager);

       $classes = $this->getClasses($modelManager);

       $tool->updateSchema($classes, true);
   }

   private function removeDatabase()
   {
       $modelManager = $this->container->get('models');
       $tool = new SchemaTool($modelManager);

       $classes = $this->getClasses($modelManager);

       $tool->dropSchema($classes);
   }

   /**
    * @param ModelManager $modelManager
    * @return array
    */
   private function getClasses(ModelManager $modelManager)
   {
       return [
           $modelManager->getClassMetadata(InfxEsdFiles::class)
       ];
   }


   private function generateAttributes($service){
       $service->update('s_articles_esd_attributes', 'infx_additional_download_active', 'boolean', [
          'label' => 'Activate Multiple Downloads',
          'displayInBackend' => true,
          'custom' => true,
          'position' => 0,
      ]);

       $service->update('s_articles_esd_attributes', 'infx_text_1', 'string', [
          'label' => 'Download Text 1',
          'displayInBackend' => true,
          'custom' => true,
          'position' => 0,
      ]);

       $service->update('s_articles_esd_attributes', 'infx_text_2', 'string', [
          'label' => 'Download Text 2',
          'displayInBackend' => true,
          'custom' => true,
          'position' => 2,
      ]);

       $service->update('s_articles_esd_attributes', 'infx_text_3', 'string', [
          'label' => 'Download Text 3',
          'displayInBackend' => true,
          'custom' => true,
          'position' => 4,
      ]);

       $service->update('s_articles_esd_attributes', 'infx_text_4', 'string', [
          'label' => 'Download Text 4',
          'displayInBackend' => true,
          'custom' => true,
          'position' => 6,
      ]);

       $service->update('s_articles_esd_attributes', 'infx_file_1', 'string', [
          'label' => 'Download Url 1',
          'displayInBackend' => true,
          'custom' => true,
          'position' => 1,
      ]);

       $service->update('s_articles_esd_attributes', 'infx_file_2', 'string', [
          'label' => 'Download Url 2',
          'displayInBackend' => true,
          'custom' => true,
          'position' => 3,
      ]);

       $service->update('s_articles_esd_attributes', 'infx_file_3', 'single_selection', [
           'label' => 'File 1',
           'displayInBackend' => true,
           'custom' => true,
           'position' => 5,
           'entity' => 'infxMultiEsd\Models\InfxEsdFiles',
       ]);

       $service->update('s_articles_esd_attributes', 'infx_file_4', 'single_selection', [
           'label' => 'File 2',
           'displayInBackend' => true,
           'custom' => true,
           'position' => 7,
           'entity' => 'infxMultiEsd\Models\InfxEsdFiles',
       ]);

   }

   private function removeAttributes($service){

      $service->delete('s_articles_esd_attributes', 'infx_additional_download_active');
      $service->delete('s_articles_esd_attributes', 'infx_text_1');
      $service->delete('s_articles_esd_attributes', 'infx_text_2');
      $service->delete('s_articles_esd_attributes', 'infx_text_3');
      $service->delete('s_articles_esd_attributes', 'infx_text_4');
      $service->delete('s_articles_esd_attributes', 'infx_file_1');
      $service->delete('s_articles_esd_attributes', 'infx_file_2');
      $service->delete('s_articles_esd_attributes', 'infx_file_3');
      $service->delete('s_articles_esd_attributes', 'infx_file_4');

   }

}
