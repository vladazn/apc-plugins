<?php
namespace ApcRouteDelivery;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use Doctrine\ORM\Tools\SchemaTool;
use Shopware\Components\Model\ModelManager;
use ApcRouteDelivery\Models\ApcZip;
use ApcRouteDelivery\Models\ApcRoutes;
use ApcRouteDelivery\Models\ApcRoutesZip;
use ApcRouteDelivery\Models\ApcRoutesDates;
use ApcRouteDelivery\Components\InitComponent;

use Shopware\Components\Plugin\ConfigReader;

class ApcRouteDelivery extends Plugin{

    public function install(InstallContext $context){
        $this->createDatabase();
        $service = $this->container->get('shopware_attribute.crud_service');
        $this->generateAttributes($service);

    }

    public function activate(ActivateContext $activateContext)
    {
        $component = new InitComponent(__DIR__);
        $component->addZipCodes();
        $activateContext->scheduleClearCache(InstallContext::CACHE_LIST_ALL);
    }

    public function uninstall(UninstallContext $context){
        $this->removeDatabase();
        $service = $this->container->get('shopware_attribute.crud_service');
        $this->removeAttributes($service);
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
            $modelManager->getClassMetadata(ApcZip::class),
            $modelManager->getClassMetadata(ApcRoutes::class),
            $modelManager->getClassMetadata(ApcRoutesZip::class),
            $modelManager->getClassMetadata(ApcRoutesDates::class)
        ];
    }

    private function generateAttributes($service){
        $service->update('s_order_attributes', 'apc_delivery_date', 'string', [
            'label' => 'Delivery Date',
            'displayInBackend' => true,
            'custom' => true,
            'position' => 0,
        ]);
        $service->update('s_order_attributes', 'apc_delivery_route', 'string', [
            'label' => 'Delivery Route',
            'displayInBackend' => true,
            'custom' => true,
            'position' => 0,
        ]);
    }

    private function removeAttributes($service){
        $service->delete('s_order_attributes', 'apc_delivery_date');
        $service->delete('s_order_attributes', 'apc_delivery_route');
    }

}
