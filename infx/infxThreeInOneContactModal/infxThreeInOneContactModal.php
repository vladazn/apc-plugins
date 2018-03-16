<?php

namespace infxThreeInOneContactModal;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\DeactivateContext;

class infxThreeInOneContactModal extends Plugin
{
    public function activate(ActivateContext $activateContext)
    {
        $activateContext->scheduleClearCache(ActivateContext::CACHE_LIST_ALL);
    }

    public function deactivate(DeactivateContext $deactivateContext)
    {
        $deactivateContext->scheduleClearCache(DeactivateContext::CACHE_LIST_ALL);
    }

}
