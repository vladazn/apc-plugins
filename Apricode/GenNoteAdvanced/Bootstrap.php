<?php

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Shopware GenNoteAdvanced Plugin
 */
class Shopware_Plugins_Frontend_GenNoteAdvanced_Bootstrap extends Shopware_Components_Plugin_Bootstrap
{
    /**
     * Install plugin method
     *
     * @return bool
     */
    public function install()
    {
        $this->subscribeEvents();
        $this->createConfigs();
        return true;
    }
    
    /**
     * Install plugin method
     *
     * @return bool
     */
    public function uninstall()
    {
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

    public function getVersion() {
        return '1.0.0';
    }
    
    /**
     * @return array
     */
    public function getInfo()
    {
       return array(
            'version' => $this->getVersion(),
            'copyright' => 'Copyright &copy; 2018, GenusCode',
            'label' => $this->getLabel(),
            'source' => '',
            'autor' => 'GenusCode',
            'supplier' => 'GenusCode',
            'description' => 'The Plugin makes wishlist dynamicly available in offcanvas panel',
            'support' => 'contact@genuscode.com',
            'link' => 'http://www.genuscode.com'
        );
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return 'Wishlist offcanvas';
    }

    private function createConfigs() {
        $form = $this->Form();

        $parent = $this->Forms()->findOneBy(['name' => 'Frontend']);
        $form->setParent($parent);

        $form->setElement('checkbox', 'show_remove', [
            'label' => 'Zeigen Entfernen Sie die Symbole im Off-Canvas-Panel',
            'value' => 1,
        ]);
        
        $form->setElement('checkbox', 'show', [
            'label' => 'Zeigen Sie Herzsymbol Animation',
            'value' => 1,
        ]);
        
        $form->setElement(
            'select',
            'side',
            [
                'label' => 'Off-Canvas-Panel Richtung',
                'store' => [
                    ['fromRight', 'Recht'],
                    ['fromLeft', 'Links'],
                ],
                'value' => 'fromRight',
                'editable' => false,
                'scope' => \Shopware\Models\Config\Element::SCOPE_SHOP,
            ]
        );
        
        $form->setElement('color', 'color1', [
            'label' => 'Herzanimationsfarbe 1',
            'value' => '#ce4646',
        ]);
        
        $form->setElement('color', 'color2', [
            'label' => 'Herzanimationsfarbe 2',
            'value' => '#b34f4f',
        ]);
        
        $form->setElement('color', 'color3', [
            'label' => 'Herzanimationsfarbe 3',
            'value' => '#a53e3e',
        ]);
        
        $translations = [
            'en_GB' => [
                'show_remove' => ['label' => 'Show Remove icons in offcanvas panel'],
                'show' => ['label' => 'Show Note icon animation'],
                'side' => [
                    'label' => 'Off-canvas panel direction',
                    'store' => [
                        ['fromRight', 'Right'],
                        ['fromLeft', 'Left'],
                    ],
                ],
                'color1' => ['label' => 'heart animation color 1'],
                'color2' => ['label' => 'heart animation color 2'],
                'color3' => ['label' => 'heart animation color 3'],
            ],
        ];

        $this->addFormTranslations($translations);
    }
    
    /**
     * Event listener method
     *
     * @param Enlight_Controller_ActionEventArgs $args
     */
    public function onPostDispatchWidgetsCheckout(\Enlight_Controller_ActionEventArgs $args)
    { 
        $controller = $args->getSubject();
        $view = $controller->View();
        $request = $controller->Request();
        $actionName = strtolower($request->getActionName());
        $view->addTemplateDir($this->Path() . 'Views');
      
        if($actionName != 'info') {
            return;
        }
        
        $view->assign('apcNoteAdvancedConfig',$this->Config());
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
       
        $view->assign('apcNoteAdvancedConfig',$this->Config());
        
        if($controllerName != 'note') {
            return;
        }
        
        if($request->getParam('isXHR',false)) {
            $assignments = $view->getAssign();
            $view->loadTemplate('frontend/note/apc_ajax_note.tpl');
            $view->assign($assignments);
        }
        
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
    
    /**
     * @return ArrayCollection
     */
    public function onCollectJavascriptFiles(){
        $jsDir = __DIR__ . '/Views/frontend/_public/src/js/';
        return new ArrayCollection([
            $jsDir . 'apc-note-advanced.js',
        ]);
    }
    
    private function subscribeEvents(){
        $this->subscribeEvent(
            'Theme_Compiler_Collect_Plugin_Javascript',
            'onCollectJavascriptFiles'
        );
        
        $this->subscribeEvent(
            'Theme_Compiler_Collect_Plugin_Less',
            'onCollectLessFiles'
        );
        
        $this->subscribeEvent(
            'Enlight_Controller_Action_PostDispatchSecure_Frontend',
            'onPostDispatch'
        );
        
        $this->subscribeEvent(
            'Enlight_Controller_Action_PostDispatchSecure_Widgets_Checkout',
            'onPostDispatchWidgetsCheckout'
        );
    }
}
