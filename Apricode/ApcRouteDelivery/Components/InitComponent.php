<?php
namespace ApcRouteDelivery\Components;

class InitComponent{

    private $pluginDir = null;
    private $db = null;

    public function __construct($pluginBaseDirectory){
        $this->pluginDir = $pluginBaseDirectory;
        $this->db = Shopware()->Db();
    }

    public function addZipCodes(){
        $row = 1;

        if (($handle = fopen($this->pluginDir."/Resources/csv/de_zip.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle)) !== FALSE) {
                $num = count($data)-1;
                $row++;
                if(strlen($data[0]) < 5){
                    $data[0] = '0'.$data[0];
                }
                for ($c=0; $c < $num; $c++) {
                    $final[$row][] = $data[$c];
                }
            }
            fclose($handle);
        }
        $cat = array_shift($final);

        $sql = 'INSERT INTO `apc_zip` SET `zip` = ?, `place` = ?, `state` = ?, `state_abbr` = ?, `city` = ?;';
        foreach($final as $zipInfo){
            $this->db->query($sql,$zipInfo);
        }
    }
}
