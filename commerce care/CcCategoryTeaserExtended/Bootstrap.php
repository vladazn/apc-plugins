<?php

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Shopware CcCategoryTeaserExtended Plugin
 */
class Shopware_Plugins_Frontend_CcCategoryTeaserExtended_Bootstrap extends Shopware_Components_Plugin_Bootstrap
{
    /**
     * Install plugin method
     *
     * @return bool
     */
    public function install()
    {
        $this->subscribeEvents();
        $this->registerControllers();
        return true;
    }
    
    /**
     * @return array
     */
    public function enable()
    {
        return [
            'success' => true,
            'invalidateCache' => ['template', 'theme'],
        ];
    }

    /**
     * @return array
     */
    public function getInfo()
    {
        return [
            'label' => $this->getLabel(),
        ];
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return 'Category Teaser Extended';
    }

    /**
     * Event listener method
     *
     * @param Enlight_Controller_ActionEventArgs $args
     */
    public function onPostDispatch(\Enlight_Controller_ActionEventArgs $args)
    { 
        $controller = $args->getSubject();
        $request = $controller->Request();
        $view = $controller->View();
        $controllerName = strtolower($request->getControllerName());
        $acitonName = strtolower($request->getActionName());
        
        $view->addTemplateDir($this->Path() . 'Views');
    }
    
    /**
     * registers widget Controller
     */
    private function registerControllers() {
        $this->registerController('Widgets','Features');
    }
    
    /**
     * @return ArrayCollection
     */
    public function onCollectLessFiles()
    {
        $lessDir = __DIR__ . '/Views/frontend/_public/src/less/';

        $less = new \Shopware\Components\Theme\LessDefinition(
            [],
            [
                $lessDir . 'all.less',
            ]
        );

        return new ArrayCollection([$less]);
    }
    
    private function subscribeEvents()
    {
        $this->subscribeEvent(
            'Theme_Compiler_Collect_Plugin_Less',
            'onCollectLessFiles'
        );
        
        $this->subscribeEvent(
            'Enlight_Controller_Action_PostDispatchSecure_Widgets',
            'onPostDispatch'
        );
    }
    
}
