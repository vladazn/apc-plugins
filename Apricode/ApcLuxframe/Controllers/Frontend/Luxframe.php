<?php

use \Shopware\Models\Media\Media;
use \Shopware\Models\Media\Album;
use ApcLuxframe\Components\ApiClient;

class Shopware_Controllers_Frontend_Luxframe extends Enlight_Controller_Action {

    public function indexAction(){
        var_dump(123);exit;
    }

    public function uploadAction() {
        $manager = Shopware()->Models();
        $image = $this->Request()->getParam('image');
        $client = new ApiClient(
            'http://shopware.p472011.webspaceconfig.de/api/',
            'p472011',
            'TZfvk7bdt6aWR9OQmRyBPgMoWhdlT542k9bTPs4a'
        );
        $result = $client->post('media',[
            'album' => -10,
            'file' => $image,
            'description' => 'description',
        ]);
        $sql = 'SELECT `path` FROM `s_media` WHERE `id` = ?;';
        $mediaPath = Shopware()->Db()->fetchOne($sql, $result['data']['id']);

        $this->View()->assign(['path' => $mediaPath]);

        $responseData = [
            'data' => $this->View()->fetch('frontend/luxframe/upload.tpl'),
            'id' => $result['data']['id']
        ];
        Shopware()->Plugins()->Controller()->ViewRenderer()->setNoRender();
        $this->response->setHeader('Content-Type','application/json',true);
        $this->response->setBody(json_encode($responseData));

        return;
    }

    private function getFileBag() {
        if($this->filebag == null) {
            $this->filebag = new FileBag($_FILES);
        }
        return $this->filebag;
    }

	private static $fileUploadBlacklist = [
        'php','php3','php4','php5','phtml',
        'cgi','pl','sh','com','bat','','py',
        'rb','exe','txt','gif'
    ];
}
