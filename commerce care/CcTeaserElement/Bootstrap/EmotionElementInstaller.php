<?php

namespace CcTeaserElement\Bootstrap;

use Shopware\Components\Emotion\ComponentInstaller;

class EmotionElementInstaller
{
    /**
     * @var ComponentInstaller
     */
    private $emotionComponentInstaller;

    /**
     * @var string
     */
    private $pluginName;

    /**
     * @param string $pluginName
     * @param ComponentInstaller $emotionComponentInstaller
     */
    public function __construct($pluginName, ComponentInstaller $emotionComponentInstaller)
    {
        $this->emotionComponentInstaller = $emotionComponentInstaller;
        $this->pluginName = $pluginName;
    }

    public function install()
    {
        $teaserElement = $this->emotionComponentInstaller->createOrUpdate(
            $this->pluginName,
            'CcTeaserElement',
            [
                'name' => 'Category Teaser Extended',
                'xtype' => 'emotion-components-teaser',
                'template' => 'emotion_teaser',
                'cls' => 'emotion--teaser-element',
                'description' => 'Subcategories will be shown in element'
            ]
        );

        $teaserElement->createTextField([
            'name' => 'category_id',
            'xtype' => 'emotion-components-fields-category-selection' ,
            'fieldLabel' => 'Select Category',
            'supportText' => '',
            'allowBlank' => false
        ]);
        
    }
}