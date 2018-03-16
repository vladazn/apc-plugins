<?php


class Shopware_Controllers_Frontend_InfxDownload extends Enlight_Controller_Action
{
    public function modalAction()
    {
        Shopware()->Front()->Plugins()->ViewRenderer()->setNoRender(true);

        $this->View()->addTemplateDir(__DIR__ . '/../../Resources/views/');

        $esdLink = $this->Request()->getParam('esdLink');
        $detailId = end(explode('/',$esdLink));
        if(empty($detailId)){
            return;
        }
        $articleName = Shopware()->Db()->fetchOne('SELECT `name` FROM `s_order_details` WHERE `id` = ?',[$detailId]);

        $downloadData = Shopware()->Container()->get('infx_multi_esd.download_component')->getMultipleDownloads($detailId,$esdLink);

        $this->View()->assign('downloads', $downloadData);

        $data = $this->View()->fetch('frontend/infx_download/modal.tpl');

        $this->Response()->setBody(json_encode(['title' => $articleName, 'data' => $data]));
        $this->Response()->setHeader('Content-Type','application/json', true);
    }

}
