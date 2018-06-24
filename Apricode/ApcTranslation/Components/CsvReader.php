<?php
namespace ApcTranslation\Components;

// use ApcTranslation\Components\ApiClient;

class CsvReader {

    public function __construct($pluginBaseDirectory){
        $this->pluginDir = $pluginBaseDirectory;
    }

	public function run() {
        $db = Shopware()->Db();
        $enStoreId = 2;
		// $client = new ApiClient(
		//     //URL of shopware REST server
		//     'http://www.lightingdeluxe.de/api/',
		//     //Username
		//     'vazgen',
		//     //User's API-Key
		//     'J4XFbro75gpBdv7eVV1vncko3xTsbSJhy3qKz3HF'
		// );
		// $client = new ApiClient(
		//     //URL of shopware REST server
		//     'http://shopware.vladazn.info/api/',
		//     //Username
		//     'apitest',
		//     //User's API-Key
		//     'v0qgp6L3VJqNhBd9id5UTMGKF1HZJ4CfD6pueDpz'
		// );
        $translation = Shopware()->Container()->get('translation');
        $storeTranslations = Shopware()->Db()->fetchAll('SELECT `id`, `value` FROM `s_filter_values`', [], \PDO::FETCH_KEY_PAIR);

		$data = $this->getCsvData($this->pluginDir."/Resources/csv/eav_attribute_option_value.csv");
		$modifiedCsvData = [];

		foreach($data as $itemKey => $item) {
			if($itemKey == 0) {
				continue; // skip labels
			}
			$modifiedCsvData[$item['1']][$item[2]] = [
				// 'valueId' => $item[0],
				'value' => $item[3],
			];
		}
        $updateSql = 'UPDATE `s_filter_values` SET `value` = ? WHERE `id` = ?;';
		foreach($modifiedCsvData as $translationGroup) {
			if(!empty($translationGroup[0]['value']) || !empty($translationGroup[1]['value'])) { // if German or Admin Value is Set in CSV Set English value

				if(!empty($translationGroup[0]['value']) && in_array($translationGroup[0]['value'],$storeTranslations)) {
					$storeValueKeys = array_keys($storeTranslations,$translationGroup[0]['value']);
					foreach($storeValueKeys as $key){
                        if(!empty($translationGroup[1]['value'])){
                            $db->query($updateSql,[$translationGroup[1]['value'],$key]);
                        }
						if(!empty($translationGroup[2]['value'])){
                            $translation->write(
                                $enStoreId,
                                'propertyvalue',
                                $key,
                                ['optionValue' => $translationGroup[2]['value']],
                                0
                            );
                            // $client->post('translations', [
                            //         'key' => $key,
                            //         'type' => 'propertyvalue',
                            //         'shopId' => $enStoreId,
                            //         'data' => [
                            //             'optionValue' => $translationGroup[2]['value'], // English value
                            //         ]
                            // ]);
						}
					}
				}elseif(!empty($translationGroup[1]['value']) && in_array($translationGroup[1]['value'],$storeTranslations)){
                    // var_dump(123);exit;
					$storeValueKeys = array_keys($storeTranslations,$translationGroup[1]['value']);
					foreach($storeValueKeys as $key){
						if(!empty($translationGroup[2]['value'])){
                            $translation->write(
                                $enStoreId,
                                'propertyvalue',
                                $key,
                                ['optionValue' => $translationGroup[2]['value']],
                                0
                            );
                            // $client->post('translations', [
                            //         'key' => $key,
                            //         'type' => 'propertyvalue',
                            //         'shopId' => $enStoreId,
                            //         'data' => [
                            //             'optionValue' => $translationGroup[2]['value'], // English value
                            //         ]
                            // ]);
						}
					}
				}
			}

		}
        var_dump('done');exit;
		exit();
	}

	private function getCsvData($file) {
		$csv = fopen($file, 'r');
		$data = [];
		while (!feof($csv) ) {
			$data[] = fgetcsv($csv, 0, ';');
		}
		fclose($csv);

		return $data;
	}

}
 ?>
