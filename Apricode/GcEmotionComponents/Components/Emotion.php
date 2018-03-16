<?php

namespace ShopwarePlugins\GcEmotionComponents\Components;

/**
 * Emotion class
 *
 * @package ShopwarePlugins\GcEmotionComponents\Components
 */
class Emotion {

    /**
     * Instance of plugin
     */
    private $bootstrap = null;

    /**
     * List of emotion components
     * @var array 
     */
    private $emotionComponents = array(
        "1.0.0" => array(
            array(
                'name' => 'GcBanner Slider',
                'xtype' => 'emotion-components-GcBanner',
                'template' => 'emotion_gcbanner',
                'cls' => 'emotion-GcBanner-slider',
                'convertFunction' => '',
                'fields' => array(
                    array(
                        'xtype' => 'textfield',
                        'translatable' => false,
                        'position' => 0,
                        'valueType' => '',
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'name' => 'title',
                        'fieldLabel' => 'Title',
                        'allowBlank' => true,
                        'valueField' => ''
                    ),

                    array(
                        'xtype' => 'checkbox',
                        'name' => 'Slider_arrows',
                        'fieldLabel' => 'Display arrows:',
                        'defaultValue' => true,
                        'allowBlank' => true,
                        'translatable' => false,
                        'position' => 0,
                        'valueType' => '',
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'displayField' => 'true',
                        'valueField' => ''
                    ),
                    
                    array(
                        'xtype' => 'checkbox',
                        'fieldLabel' => '',
                        'name' => 'Slider_loop',
                        'fieldLabel' => 'Display navigation:',
                        'supportText'=> 'Please note that there are only dots instead of numbers in the desktop viewport.',
                        'defaultValue' => true,
                        'allowBlank' => true,
                        'translatable' => false,
                        'position' => 0,
                        'valueType' => '',
                        'store' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'displayField' => 'true',
                        'valueField' => ''
                    ),
                    
                    array(
                        'xtype' => 'numberfield',
                        'name' => 'scrol-speed',
                        'defaultValue' => 500,
                        'fieldLabel' => 'Scroll speed:',
                        'allowBlank' => true,
                        'translatable' => false,
                        'position' => 0,
                        'valueType' => '',
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'displayField' => 'true',
                        'valueField' => ''
                    ),
                    
                    array(
                        'xtype' => 'checkbox',
                        'name' => 'autorotate',
                        'fieldLabel' => 'Rotate automatically',
                        'defaultValue' => true,
                        'allowBlank' => true,
                        'translatable' => false,
                        'position' => 0,
                        'valueType' => '',
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'displayField' => 'true',
                        'valueField' => ''
                    ),
                    
                    array(
                        'xtype' => 'numberfield',
                        'name' => 'rotate-speed',
                        'defaultValue' => 5000,
                        'fieldLabel' => 'Rotate speed:',
                        'allowBlank' => true,
                        'translatable' => false,
                        'position' => 0,
                        'valueType' => '',
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'displayField' => 'true',
                        'valueField' => ''
                    ),
                    
                    array(
                        'xtype' => 'hidden',
                        'fieldLabel' => '',
                        'name' => 'banner_slider',
                        'valueType'=> 'json',
                        'allowBlank' => true,
                        'translatable' => false,
                        'position' => 0,
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'valueField' => ''
                    ),
                    
                    array(
                        'xtype' => 'gc-color-field',
                        'fieldLabel' => 'Background Color',
                        'name' => 'background_color',
                        'valueType'=> '',
                        'allowBlank' => true,
                        'translatable' => false,
                        'position' => 0,
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '#ffffff',
                        'displayField' => 'true',
                        'valueField' => ''
                    ),
                    
                    array(
                        'xtype' => 'gc-color-field',
                        'fieldLabel' => 'Button Background Color',
                        'name' => 'button_background_color',
                        'valueType'=> '',
                        'allowBlank' => true,
                        'translatable' => false,
                        'position' => 0,
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '#009DE0',
                        'displayField' => 'true',
                        'valueField' => ''
                    ),
                    
                     array(
                        'xtype' => 'emotion-components-fields-category-selection',
                        'fieldLabel' => 'First Category',
                        'name' => 'slider_category_1',
                        'valueType'=> '',
                        'allowBlank' => true,
                        'translatable' => false,
                        'position' => 1,
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'valueField' => ''
                    ),
                    
                     array(
                        'xtype' => 'textfield',
                        'fieldLabel' => 'First Category Title',
                        'name' => 'slider_category_1_title',
                        'valueType'=> '',
                        'allowBlank' => true,
                        'translatable' => false,
                        'position' => 1,
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'valueField' => ''
                    ),
                    
                     array(
                        'xtype' => 'mediafield',
                        'fieldLabel' => 'First Category Icon',
                        'name' => 'slider_category_1_icon',
                        'valueType'=> '',
                        'allowBlank' => true,
                        'translatable' => false,
                        'position' => 1,
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'valueField' => ''
                    ),
                    
                    array(
                        'xtype' => 'emotion-components-fields-category-selection',
                        'fieldLabel' => 'Second Category',
                        'name' => 'slider_category_2',
                        'valueType'=> '',
                        'allowBlank' => true,
                        'translatable' => false,
                        'position' => 1,
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'valueField' => ''
                    ),
                    
                     array(
                        'xtype' => 'textfield',
                        'fieldLabel' => 'Second Category Title',
                        'name' => 'slider_category_2_title',
                        'valueType'=> '',
                        'allowBlank' => true,
                        'translatable' => false,
                        'position' => 1,
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'valueField' => ''
                    ),
                    
                     array(
                        'xtype' => 'mediafield',
                        'fieldLabel' => 'Second Category Icon',
                        'name' => 'slider_category_2_icon',
                        'valueType'=> '',
                        'allowBlank' => true,
                        'translatable' => false,
                        'position' => 1,
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'valueField' => ''
                    ),
                    
                    array(
                        'xtype' => 'emotion-components-fields-category-selection',
                        'fieldLabel' => 'Third Category',
                        'name' => 'slider_category_3',
                        'valueType'=> '',
                        'allowBlank' => true,
                        'translatable' => false,
                        'position' => 1,
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'valueField' => ''
                    ),
                    
                     array(
                        'xtype' => 'textfield',
                        'fieldLabel' => 'Third Category Title',
                        'name' => 'slider_category_3_title',
                        'valueType'=> '',
                        'allowBlank' => true,
                        'translatable' => false,
                        'position' => 1,
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'valueField' => ''
                    ),
                    
                     array(
                        'xtype' => 'mediafield',
                        'fieldLabel' => 'Third Category Icon',
                        'name' => 'slider_category_3_icon',
                        'valueType'=> '',
                        'allowBlank' => true,
                        'translatable' => false,
                        'position' => 1,
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'valueField' => ''
                    )
                )
            ),
            
            
            array(
                'name' => 'GcNewsletter Widget',
                'xtype' => 'emotion-components-GcNewsletter',
                'template' => 'emotion_gcnewsletter',
                'cls' => 'emotion-GcNewsletter-widget',
                'convertFunction' => '',
                'fields' => array(
                    
                     array(
                        'xtype' => 'mediafield',
                        'fieldLabel' => 'Image',
                        'name' => 'newsletterImage',
                        'valueType'=> '',
                        'allowBlank' => true,
                        'translatable' => false,
                        'position' => 0,
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'valueField' => ''
                    ),
                    
                    array(
                        'xtype' => 'textfield',
                        'translatable' => false,
                        'position' => 0,
                        'valueType' => '',
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'name' => 'newsletterHeadline',
                        'fieldLabel' => 'Headline',
                        'allowBlank' => true,
                        'valueField' => ''
                    ),
                    
                   array(
                        'xtype' => 'textfield',
                        'translatable' => false,
                        'position' => 0,
                        'valueType' => '',
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'name' => 'newsletterSubtext',
                        'fieldLabel' => 'Subtext',
                        'allowBlank' => true,
                        'valueField' => ''
                    ),
                    
                    array(
                        'xtype' => 'textfield',
                        'translatable' => false,
                        'position' => 0,
                        'valueType' => '',
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'name' => 'newsletterBtnText',
                        'fieldLabel' => 'ButtonText',
                        'allowBlank' => true,
                        'valueField' => ''
                    )
                )
            ),
            
            array(
                'name' => 'GcVideo Module',
                'xtype' => 'emotion-components-GcVideo',
                'template' => 'emotion_gcvideo',
                'cls' => 'emotion-GcVideo-Module',
                'convertFunction' => '',
                'fields' => array(
                    
                     array(
                        'xtype' => 'mediafield',
                        'fieldLabel' => 'Preview Image',
                        'name' => 'videoImage',
                        'valueType'=> '',
                        'allowBlank' => true,
                        'translatable' => false,
                        'position' => 0,
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'valueField' => ''
                    ),
                    
                    array(
                        'xtype' => 'textfield',
                        'translatable' => false,
                        'position' => 0,
                        'valueType' => '',
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'name' => 'videoLink',
                        'fieldLabel' => 'Video Link',
                        'allowBlank' => true,
                        'valueField' => ''
                    ),
                    
                    array(
                        'xtype' => 'textfield',
                        'translatable' => false,
                        'position' => 0,
                        'valueType' => '',
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'name' => 'videoText',
                        'fieldLabel' => 'Text',
                        'allowBlank' => true,
                        'valueField' => ''
                    ),
                    
                     array(
                        'xtype' => 'textfield',
                        'translatable' => false,
                        'position' => 0,
                        'valueType' => '',
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'name' => 'videoBtnText',
                        'fieldLabel' => 'Button Text',
                        'allowBlank' => true,
                        'valueField' => ''
                    ),
                    
                     array(
                        'xtype' => 'textfield',
                        'translatable' => false,
                        'position' => 0,
                        'valueType' => '',
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'name' => 'videoBtnLink',
                        'fieldLabel' => 'Button Link',
                        'allowBlank' => true,
                        'valueField' => ''
                    )
                )
            ),
            
            array(
                'name' => 'GcContent Block',
                'xtype' => 'emotion-components-GcContent',
                'template' => 'emotion_gccontent',
                'cls' => 'emotion-GcContent-block',
                'convertFunction' => '',
                'fields' => array(
                    
                     array(
                        'xtype' => 'mediafield',
                        'fieldLabel' => 'Image',
                        'name' => 'contentImage',
                        'valueType'=> '',
                        'allowBlank' => true,
                        'translatable' => false,
                        'position' => 0,
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'valueField' => ''
                    ),
                    
                    array(
                        'xtype' => 'textfield',
                        'translatable' => false,
                        'position' => 0,
                        'valueType' => '',
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'name' => 'contentHeadline',
                        'fieldLabel' => 'Headline',
                        'allowBlank' => true,
                        'valueField' => ''
                    ),
                    
                   array(
                        'xtype' => 'textarea',
                        'translatable' => false,
                        'position' => 0,
                        'valueType' => '',
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'name' => 'contentText',
                        'fieldLabel' => 'Text',
                        'allowBlank' => true,
                        'valueField' => ''
                    ),
                    
                    array(
                        'xtype' => 'textfield',
                        'translatable' => false,
                        'position' => 0,
                        'valueType' => '',
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'name' => 'contentBtnText',
                        'fieldLabel' => 'Button Text',
                        'allowBlank' => true,
                        'valueField' => ''
                    ) ,
                    
                    array(
                        'xtype' => 'textfield',
                        'translatable' => false,
                        'position' => 0,
                        'valueType' => '',
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'name' => 'btnTarget',
                        'fieldLabel' => 'Button Link',
                        'allowBlank' => true,
                        'valueField' => ''
                    ),
                    
                    array(
                        'xtype' => 'checkbox',
                        'translatable' => false,
                        'position' => 0,
                        'valueType' => '',
                        'store' => '',
                        'supportText' => 'if checked full style will be applied.',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'name' => 'contentBlockStyle',
                        'fieldLabel' => 'Is Full Style',
                        'allowBlank' => true,
                        'valueField' => ''
                    )
                )
            ),
            
            
               
            array(
                'name' => 'GcCategory Module',
                'xtype' => 'emotion-components-gccategorymodule',
                'template' => 'emotion_gccategory',
                'cls' => 'emotion--GcCategory-element',
                'convertFunction' => '',
                'fields' => array(
                    
                    array(
                        'xtype' => 'emotion-components-fields-category-selection',
                        'fieldLabel' => 'Select Category',
                        'name' => 'gc_category',
                        'valueType'=> '',
                        'allowBlank' => true,
                        'translatable' => false,
                        'position' => 0,
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'valueField' => ''
                    ),
                    
                     array(
                        'xtype' => 'mediafield',
                        'fieldLabel' => 'Category Image',
                        'name' => 'categoryImage',
                        'valueType'=> '',
                        'allowBlank' => true,
                        'translatable' => false,
                        'position' => 0,
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'valueField' => ''
                    ),
                    
                     array(
                        'xtype' => 'textfield',
                        'fieldLabel' => 'Category Title',
                        'name' => 'categoryTitle',
                        'valueType'=> '',
                        'allowBlank' => true,
                        'translatable' => false,
                        'position' => 0,
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'valueField' => ''
                    )
                )
            ),
            
                 
            array(
                'name' => 'GcPartner Element',
                'xtype' => 'emotion-components-gcpartnerelement',
                'template' => 'emotion_gcpartner',
                'cls' => 'emotion--GcPartner-element',
                'convertFunction' => '',
                'fields' => array(
                 
                     array(
                        'xtype' => 'mediafield',
                        'fieldLabel' => 'Partner Image',
                        'name' => 'partnerImage',
                        'valueType'=> '',
                        'allowBlank' => true,
                        'translatable' => false,
                        'position' => 0,
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'valueField' => ''
                    ),
                    
                     array(
                        'xtype' => 'textarea',
                        'fieldLabel' => 'Text',
                        'name' => 'partnerText',
                        'valueType'=> '',
                        'allowBlank' => true,
                        'translatable' => false,
                        'position' => 0,
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'valueField' => ''
                    ),
                    
                    array(
                        'xtype' => 'textfield',
                        'fieldLabel' => 'Link',
                        'name' => 'partnerLink',
                        'valueType'=> '',
                        'allowBlank' => true,
                        'translatable' => false,
                        'position' => 0,
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'valueField' => ''
                    )
                )
            ),
            
            array(
                'name' => 'Gc TextElement',
                'xtype' => 'emotion-components-gctextelement',
                'template' => 'emotion_gctextelement',
                'cls' => 'emotion--GcTextElement-element',
                'convertFunction' => '',
                'fields' => array(
                        
                    array(
                        'name' => 'gc_text_element_text',
                        'fieldLabel' => 'Text',
                        'supportText'=> '',
                        'allowBlank' => true,
                        'xtype' => 'htmleditor',
                        'valueType'=> '',
                        'translatable' => false,
                        'position' => 0,
                        'store' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'valueField' => ''
                    ),

                    array(
                        'name' => 'gc_text_element_title',
                        'fieldLabel' => 'Title',
                        'supportText'=> '',
                        'allowBlank' => true,
                        'xtype' => 'textfield',
                        'valueType'=> '',
                        'translatable' => false,
                        'position' => 0,
                        'store' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'valueField' => ''
                    ),
                    
                    array(
                        'name' => 'gc_text_element_button_text',
                        'fieldLabel' => 'Button Text',
                        'supportText'=> '',
                        'allowBlank' => true,
                        'xtype' => 'textfield',
                        'valueType'=> '',
                        'translatable' => false,
                        'position' => 0,
                        'store' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'valueField' => ''
                    ),
                    
                    array(
                        'name' => 'gc_text_element_button_target',
                        'fieldLabel' => 'Button Target',
                        'supportText'=> '',
                        'allowBlank' => true,
                        'xtype' => 'textfield',
                        'valueType'=> '',
                        'translatable' => false,
                        'position' => 0,
                        'store' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'valueField' => ''
                    ),
                    
                    array(
                        'xtype' => 'hidden',
                        'fieldLabel' => '',
                        'name' => 'text',
                        'valueType'=> 'json',
                        'allowBlank' => true,
                        'translatable' => false,
                        'position' => 0,
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'valueField' => ''
                    ),
                    
                    array(
                        'xtype' => 'gc-color-field',
                        'name' => 'gc_text_element_background_color',
                        'fieldLabel' => 'Background Color',
                        'allowBlank' => true,
                        'defaultValue'=>'',
                        'valueType' =>'text',
                        'translatable' => false,
                        'position' => 0,
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'displayField' => 'true',
                        'valueField' => ''
                    ),
                    
                    array(
                        'xtype' => 'gc-color-field',
                        'name' => 'gc_text_element_gradient_background_color',
                        'fieldLabel' => 'Gradient Bg Color',
                        'allowBlank' => true,
                        'defaultValue'=>'',
                        'valueType' =>'text',
                        'translatable' => false,
                        'position' => 0,
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'displayField' => 'true',
                        'valueField' => ''
                    )
                )
            ),
            
            array(
                'name' => 'Gc Text and Image Element',
                'xtype' => 'emotion-components-gctextandimageelement',
                'template' => 'emotion_gctextandimage',
                'cls' => 'emotion--GcTextAndImage-element',
                'convertFunction' => '',
                'fields' => array(
                 
                     array(
                        'xtype' => 'mediafield',
                        'fieldLabel' => 'Select Image',
                        'name' => 'gcTextAndImageImage',
                        'valueType'=> '',
                        'allowBlank' => true,
                        'translatable' => false,
                        'position' => 0,
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'valueField' => ''
                    ),
                    
                     array(
                        'xtype' => 'textarea',
                        'fieldLabel' => 'Text',
                        'name' => 'gcTextAndImageText',
                        'valueType'=> '',
                        'allowBlank' => true,
                        'translatable' => false,
                        'position' => 0,
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'valueField' => ''
                    ),
                    
                    array(
                        'xtype' => 'textfield',
                        'fieldLabel' => 'Title',
                        'name' => 'gcTextAndImageTitle',
                        'valueType'=> '',
                        'allowBlank' => true,
                        'translatable' => false,
                        'position' => 0,
                        'store' => '',
                        'supportText' => '',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'valueField' => ''
                    ),
                    
                    array(
                        'xtype' => 'textfield',
                        'fieldLabel' => 'link',
                        'name' => 'gcTextAndImageLink',
                        'valueType'=> '',
                        'allowBlank' => true,
                        'translatable' => false,
                        'position' => 0,
                        'store' => '',
                        'supportText' => 'Link of the banner',
                        'helpTitle' => '',
                        'helpText' => '',
                        'defaultValue' => '',
                        'displayField' => 'true',
                        'valueField' => ''
                    )
                )
            )
        )
    );

    /**
     * Constructor
     */
    public function __construct($bootstrap) {
        $this->bootstrap = $bootstrap;
    }
    
    /**
     * Returns emotion components by plugin version
     * @param string $version
     * @return array
     */
    public function getEmotionComponents($version = null) {
        $emotionComponents = array();
        if(!isset($version)) {
            $versions = array_keys($this->emotionComponents);
            foreach($versions as $version) {
                $emotionComponents = array_merge($emotionComponents, $this->emotionComponents[$version]);
            }
        } else {
            if(!isset($this->emotionComponents[$version])) {
                return $emotionComponents;
            }
            $versions = array_keys($this->emotionComponents);
            $versionIndex = array_search($version, $versions);
            foreach($versions as $index => $version) {
                if($index <= $versionIndex) {
                    continue;
                }
                $emotionComponents = array_merge($emotionComponents, $this->emotionComponents[$version]);
            }
        }
        return $emotionComponents;
    }

    /**
     * Creates Shopping World components
     * @return bool
     */
    public function createEmotionComponents($version = "1.0.0") {
        $componentsArray = $this->getEmotionComponents();
        foreach ($componentsArray as $componentDetails) {
            $this->bootstrap->createEmotionComponent($componentDetails);
        }
        return true;
    }

    /**
     * Removes created emotion components
     * @return boolean
     */
    public function removeEmotionComponents() {
        $componentsArray = $this->getEmotionComponents();
        foreach ($componentsArray as $componentDetails) {
            $sql = "SELECT `id` FROM `s_library_component` WHERE `name`=?;";
            $removeById = Shopware()->Db()->fetchOne($sql, array($componentDetails['name']));

            if ($removeById && $removeById > 0) {
                $sql = "DELETE FROM `s_emotion_element_value` WHERE `componentID`=:id;"
                        . "DELETE FROM `s_emotion_element` WHERE `componentID`=:id;"
                        . "DELETE FROM `s_library_component_field` WHERE `componentID`=:id;"
                        . "DELETE FROM `s_library_component` WHERE `id`=:id;";
                Shopware()->Db()->query($sql, array("id" => $removeById));
            }
        }
        return true;
    }
}
