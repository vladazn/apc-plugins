<?php

namespace TimeAmazonIntegration\Components\Transformers;

use TimeAmazonIntegration\Components\Transformers\IDataTransformer;

class XmlTransformer implements IDataTransformer {
    public function execute($xmlData) {
        return $xmlData;
    }
}

?>