<?php

namespace CcBlogExtended;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;

class CcBlogExtended extends Plugin {
    
     const BLOG_PDF_TEMPLATE_NAME = "cc_blog_detail.tpl";
     
     public function getVersion() {
        return '1.0.0';
    }

     public function install(InstallContext $installContext)
     {
         $this->createDocumentTemplate();
     }
 
     public function uninstall(UninstallContext $uninstallContext)
     {
         
         // If the user wants to keep his data we will not delete it while uninstalling the plugin
         if ($uninstallContext->keepUserData()) {
             return;
         }
         
         $this->removeDocumentModel();
     }
     
    public function getPdfTemplateName() {
        return self::BLOG_PDF_TEMPLATE_NAME;
    }
     
    public static function getViewDir() {
        return __DIR__ . '/Resources/views';
    }
    
    public function createDocumentTemplate() {
         $manager = Shopware()->Models();
         $repository = Shopware()->Models()->getRepository('Shopware\Models\Document\Document');
         $model = $repository->getClassName();
         $model = new $model();
         $template = self::BLOG_PDF_TEMPLATE_NAME;
         $data = array(
                  "name" =>  "Blog Detail PDF",
                  "template" => $template,
                  "numbers" => "doc_1",
                  "left" => 25,
                  "right" => 10,
                  "top" => 20 ,
                  "bottom" => 20,
                  "pageBreak" => 10
                );

        $model->fromArray($data);
        $manager->persist($model);
        $manager->flush();
   } 
     
    private function removeDocumentModel() {
        $manager = Shopware()->Models();
        $repository = Shopware()->Models()->getRepository('Shopware\Models\Document\Document');
        $template = self::BLOG_PDF_TEMPLATE_NAME;
        $id = Shopware()->Db()->fetchOne("SELECT `id` FROM `s_core_documents` WHERE `template` = ? ;",[$template]);
        $model = $repository->find($id);
        $manager->remove($model);
        $manager->flush();
    }
     
 }