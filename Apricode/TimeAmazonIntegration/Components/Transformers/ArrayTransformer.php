<?php

namespace TimeAmazonIntegration\Components\Transformers;

use TimeAmazonIntegration\Components\Transformers\IDataTransformer;

class ArrayTransformer implements IDataTransformer {
    public function execute($xmlData) {
        $xmlData = (array) $xmlData ;
        $data = [];
        foreach($xmlData as $key=>$value){
            if(gettype($value) == "object"){
                $data[$key] = $this->execute($value);
            }else{
                $data[$key] = $value;
            }
            
        }
        return $data;
    }
}

?>
