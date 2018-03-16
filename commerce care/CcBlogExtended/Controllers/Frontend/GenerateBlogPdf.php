<?php

class Shopware_Controllers_Frontend_GenerateBlogPdf extends \Shopware_Controllers_Frontend_Blog {

    private function generateDocument($blogArticle) {
        $pluginDir = \CcBlogExtended\CcBlogExtended::getViewDir();
        
        $renderer = "pdf"; 
        $displayDate = new \DateTime($displayDate);
        $displayDate = $displayDate->format('d.m.Y');
        $blogPdftemplate = $this->Plugin()->getPdfTemplateName();
        $documentType = Shopware()->Db()->fetchOne("SELECT `id` FROM `s_core_documents` WHERE `template` = ? ;",[$blogPdftemplate]);
        $document = \Enlight_Class::Instance('Shopware_Components_Document'); //new Shopware_Components_Document();
        $document->setDocumentId($documentType);
     
        $document->_subshop = Shopware()->Db()->fetchRow("
            SELECT
                s.id,
                s.document_template_id as doc_template_id,
                s.template_id,
                (SELECT CONCAT('templates/', template) FROM s_core_templates WHERE id = s.document_template_id) as doc_template,
                (SELECT CONCAT('templates/', template) FROM s_core_templates WHERE id = s.template_id) as template,
                s.id as isocode,
                s.locale_id as locale
            FROM s_core_shops s
            WHERE s.default = 1
            ");

        $document->setTemplate($document->_defaultPath);
        $document->_subshop["doc_template"] = $document->_defaultPath;
        $document->_template = clone Shopware()->Template();
        $path = basename($document->_subshop["doc_template"]);
        $document->_view = $document->_template->createData();
         
        $document->_template->setTemplateDir(array(
                'custom' => $path,
                'local' => '_emotion_local',
                'emotion' => '_emotion',
            ));
        
        $document->_template->setCompileId(str_replace('/', '_', $path).'_'.$document->_subshop['id']);
        $this->loadContainers($document);
        $document->_view->assign('sArticle',$blogArticle);
        $template = Shopware()->Container()->get('models')->find('Shopware\Models\Shop\Template', $document->_subshop['doc_template_id']);
        $inheritance = $this->container->get('theme_inheritance')->getTemplateDirectories($template);
        $document->_template->setTemplateDir($inheritance);
        $data = $document->_template->fetch("documents/".$blogPdftemplate, $document->_view);
        $mpdf = new mPDF("utf-8", "A4", "", "");
        $mpdf->WriteHTML($data);
        $mpdf->Output();
        exit;

    }
    
    private function loadContainers($document) {
        // Load Containers
        $containersData = Shopware()->Db()->fetchAll(
            "SELECT * FROM `s_core_documents_box` WHERE `documentID` = ?",
            array(1),
            \PDO::FETCH_ASSOC
        );
        $containers = array();
        foreach($containersData as $container) {
            $containers[$container['name']] = $container;
        }
        
        $document->_view->assign('Containers',$containers);
          
    }
 
    public function indexAction() {
        parent::detailAction();
        $sArticle = $this->View()->getAssign('sArticle');
        $this->generateDocument($sArticle);
    }
    
   
    private $pluginInstance = null;
    
    private function Plugin() {
        if($this->pluginInstance == null) {
            $this->pluginInstance = Shopware()->Container()->get('kernel')->getPlugins()['CcBlogExtended'];
        }
        
        return $this->pluginInstance;
    }


}
    