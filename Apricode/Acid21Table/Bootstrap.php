<?php

use Doctrine\Common\Collections\ArrayCollection;

class Shopware_Plugins_Backend_Acid21Table_Bootstrap extends Shopware_Components_Plugin_Bootstrap {

    public function getLabel() {
        return 'ACID21 emotion grid element';
    }

    public function getVersion() {
        return "1.0.0";
    }

    public function install() {
        /**
         * Create the main component for the emotion element.
         */
        $ACID21Table = $this->createEmotionComponent([
            'name' => 'ACID21 grid',
            'xtype' => 'emotion-components-acid21table',
            'template' => 'emotion_acid21table',
            'cls' => 'emotion--acid21table-element'
        ]);

        $ACID21Table->createHiddenField([
            'name' => 'tm_text_hidden_field',
            'valueType' => 'json'
        ]);

        $this->subscribeEvent(
                'Theme_Compiler_Collect_Plugin_Less', 'onCollectLessFiles'
        );

        $this->subscribeEvent(
                'Theme_Compiler_Collect_Plugin_Javascript', 'onCollectJavascriptFiles'
        );
        

        $this->subscribeEvent(
                'Enlight_Controller_Action_PostDispatchSecure_Backend_Emotion', 'onPostDispatchBackendEmotion'
        );
        $this->subscribeEvent(
                'Shopware_Controllers_Widgets_Emotion_AddElement', 'onEmotionAddElement'
        );
        $this->registerController('Backend', 'ACID21table');
        $this->subscribeEvent(
                'Shopware_Controllers_Widgets_Emotion_AddElement', 'onEmotionAddElement'
        );

        return true;
    }

    public function onPostDispatchBackendEmotion(Enlight_Controller_ActionEventArgs $args) {
        $controller = $args->getSubject();
        $view = $controller->View();
        $request = $controller->Request();
        $view->addTemplateDir($this->Path() . 'Views/');
        if ($request->getActionName() == 'index') {
            $view->extendsTemplate('backend/acid21_table/TmExtendApp.js');
        }

        $view->extendsTemplate('backend/emotion/acid21_table/view/detail/elements/acid21_table.js');
    }

    public function uninstall() {
        return true;
    }

    public function onEmotionAddElement(Enlight_Event_EventArgs $args) {
        $element = $args->get('element');

        if ($element['component']['xType'] !== 'emotion-components-acid21table') {
            return;
        }

        $data = $args->getReturn();
        $data = json_decode($data['tm_text_hidden_field']);
        $table = array();
        $last = null;
        foreach ($data as $index => $item) {
            $item = (array) $item;
            foreach ($item as $key => $one) {
                if($last == null && $one == '') {
                    $last = $key;
                }
                if($key == $last) {
                    break;
                }
                $table[$index][] = $one;
            }
        }
        $args->setReturn($table);
    }
    
    
    public function onCollectLessFiles() {
        $lessDir = $this->Path() . '/Views/frontend/_public/src/less/';

        $less = new \Shopware\Components\Theme\LessDefinition(
                [], array(
            $lessDir . 'all.less'
                ), $this->Path()
        );

        return new ArrayCollection(array($less));
    }

    public function onCollectJavascriptFiles() {
        $jsFiles = array(
            
            $this->Path() . '/Views/frontend/_public/src/js/acid21Table.js'
        );

        return new ArrayCollection($jsFiles);
    }

}
