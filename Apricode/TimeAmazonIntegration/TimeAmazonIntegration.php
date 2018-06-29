<?php

namespace TimeAmazonIntegration;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\DeactivateContext;
use Shopware\Components\Plugin\Context\UpdateContext;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Doctrine\ORM\Tools\SchemaTool;
use Shopware\Components\Model\ModelManager;
use TimeAmazonIntegration\Models\ApcAmazonLog;
use TimeAmazonIntegration\Models\ApcAmazonUsers;

class TimeAmazonIntegration extends Plugin
{

    public function install(InstallContext $context){
        $service = $this->container->get('shopware_attribute.crud_service');
        $this->generateAttributes($service);
        $this->createDatabase();
    }
    public function uninstall(UninstallContext $context)
    {
        if (!$context->keepUserData()) {
            $service = $this->container->get('shopware_attribute.crud_service');
            $this->removeAttributes($service);
            $this->removeDatabase();
        }
    }

    private function createDatabase(){
        $modelManager = $this->container->get('models');
        $tool = new SchemaTool($modelManager);
        $classes = $this->getClasses($modelManager);
        $tool->updateSchema($classes, true);
    }
    private function removeDatabase(){
        $modelManager = $this->container->get('models');
        $tool = new SchemaTool($modelManager);
        $classes = $this->getClasses($modelManager);
        $tool->dropSchema($classes);
    }
    private function getClasses(ModelManager $modelManager){
        return [
            $modelManager->getClassMetadata(ApcAmazonUsers::class),
            $modelManager->getClassMetadata(ApcAmazonLog::class)
        ];
    }


    private function generateAttributes($service){

        $service->update('s_articles_attributes', 'seller_sku', 'string', [
           'label' => 'Seller SKU',
           'displayInBackend' => true,
           'custom' => true
        ]);
        $service->update('s_articles_attributes', 'sync_stock', 'boolean', [
           'label' => 'Sync Stock',
           'displayInBackend' => true,
           'custom' => true
        ]);
        $service->update('s_order_attributes', 'amazon_id', 'string', [
           'label' => 'Amazon Order Number',
           'displayInBackend' => true,
           'custom' => true
        ]);
        $service->update('s_order_attributes', 'amazon_status_updated', 'boolean', [
           'label' => 'Amazon Status Updated',
           'displayInBackend' => false,
           'custom' => true
        ]);
    }

    private function removeAttributes($service){
        $service->delete('s_articles_attributes', 'seller_sku');
        $service->delete('s_order_attributes', 'amazon_id');
        $service->delete('s_order_attributes', 'amazon_status_updated');
        $service->delete('s_articles_attributes', 'sync_stock');
    }

}
?>
