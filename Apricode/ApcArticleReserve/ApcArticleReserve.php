<?php

namespace ApcArticleReserve;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use Shopware\Components\Plugin\Context\ActivateContext;
use Doctrine\ORM\Tools\SchemaTool;
use Shopware\Components\Model\ModelManager;
use ApcArticleReserve\Models\ApcReserve;

class ApcArticleReserve extends Plugin
{
    /**
     * @param InstallContext $context
     */
    public function install(InstallContext $context)
    {
        $this->createDatabase();
    }

    /**
     * @param UninstallContext $context
     */
    public function uninstall(UninstallContext $context)
    {
        $this->removeDatabase();
    }

    public function activate(ActivateContext $activateContext)
    {
        $activateContext->scheduleClearCache(InstallContext::CACHE_LIST_ALL);
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
            $modelManager->getClassMetadata(ApcReserve::class)
        ];
    }

}
