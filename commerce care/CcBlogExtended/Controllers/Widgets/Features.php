<?php

use Shopware\Controllers\Backend\Article;


class Shopware_Controllers_Widgets_Features extends Article
{
    
    private function getVariants() {
            $this->createConfiguratorVariantsAction();
    }
}
