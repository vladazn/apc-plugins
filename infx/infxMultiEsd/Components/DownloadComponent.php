<?php

namespace infxMultiEsd\Components;

use Shopware\Models\Shop\Shop;

class DownloadComponent
{

    public function getMultipleDownloads($orderdetailsId,$esdLink){

        $baseUrl = Shopware()->Front()->Router()->assemble(['module'=>'frontend']);

        //esdAttribute Data
        $sql = 'SELECT * FROM `s_articles_esd_attributes` LEFT JOIN `s_order_esd` ON `s_order_esd`.`esdID` = `s_articles_esd_attributes`.`esdID` WHERE `s_order_esd`.`orderdetailsID` = ?';
        $esdData = Shopware()->Db()->fetchRow($sql,array($orderdetailsId));
        if($esdData['infx_additional_download_active'] == 1){
            $k = 1;
            for($i=1; $i<=4; $i++){
                if(empty($esdData['infx_file_'.$i])){
                    continue;
                }
                if(empty($esdData['infx_text_'.$i])){
                    $esdData['infx_text_'.$i] = 'Download Link '.$k;
                    $k++;
                }

                if($i>2){
                    $link = $baseUrl.'files/'.Shopware()->Config()->get('sESDKEY').'/'
                                .Shopware()->Db()->fetchOne('SELECT `name` FROM `infx_esd_files` WHERE `id` = ? ;', array($esdData['infx_file_'.$i]));
                }else{
                    $link = $esdData['infx_file_'.$i];
                }

                $downloadData[] = [
                    'text' => $esdData['infx_text_'.$i],
                    'link' => $link
                ];
            }

        }else{
            $downloadData[] = [
                'text' => 'Download',
                'link' => $esdLink
            ];
        }

        return $downloadData;
    }

    public function checkFiles(){
         $filePath = Shopware()->DocPath('files_' . Shopware()->Config()->get('sESDKEY'));
         if (!file_exists($filePath)) {
             return;
         }
         $sql = 'TRUNCATE TABLE `infx_esd_files` ; ';
         Shopware()->Db()->query($sql);
         $sql = 'INSERT INTO `infx_esd_files` SET `name` = ? ;';
         $result = [];
         foreach (new \DirectoryIterator($filePath) as $file) {
             if ($file->isDot() || strpos($file->getFilename(), '.') === 0) {
                 continue;
             }
             $count = Shopware()->Db()->fetchOne('SELECT COUNT(*) FROM `infx_esd_files` WHERE `name` = ?;',array($file->getFilename()));
             if($count == 0){
                 Shopware()->Db()->query($sql,array($file->getFilename()));
             }
         }
         return;
    }

}
