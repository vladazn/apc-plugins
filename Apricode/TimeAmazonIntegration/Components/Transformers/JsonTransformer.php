<?php

namespace TimeAmazonIntegration\Components\Transformers;

use TimeAmazonIntegration\Components\Transformers\IDataTransformer;

class JsonTransformer implements IDataTransformer {
    public function execute($xmlData) {
        return json_encode($xmlData);
    }
}

?>
