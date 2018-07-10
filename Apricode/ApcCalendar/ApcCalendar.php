<?php
namespace ApcCalendar;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use Doctrine\ORM\Tools\SchemaTool;
use Shopware\Components\Model\ModelManager;
use ApcCalendar\Models\ApcCalendarSeminars;

class ApcCalendar extends Plugin{

    public function install(InstallContext $context){
        $this->createDatabase();
    }

    public function activate(ActivateContext $activateContext)
    {
        $activateContext->scheduleClearCache(InstallContext::CACHE_LIST_ALL);
    }

    public function uninstall(UninstallContext $context){
        $this->removeDatabase();
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
            $modelManager->getClassMetadata(ApcCalendarSeminars::class),
        ];
    }

}
