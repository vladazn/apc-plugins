{extends file="parent:widgets/emotion/index.tpl"}
 

{block name="widgets/emotion/index/attributes" append}
    {if !($emotion.attribute.gcEmotionHasPadding)}
         style="background-color: {$emotion.attribute.gcEmotionColorFrom};
               {if $emotion.attribute.gcEmotionColorTo}
                 -webkit-background-image: linear-gradient({$emotion.attribute.gcEmotionColorFrom},{$emotion.attribute.gcEmotionColorTo});
                 -moz-background-image: linear-gradient({$emotion.attribute.tgcmotionColorFrom},{$emotion.attribute.gcEmotionColorTo});
                 -ms-background-image: linear-gradient({$emotion.attribute.gcEmotionColorFrom},{$emotion.attribute.gcEmotionColorTo});
                 background-image: linear-gradient({$emotion.attribute.gcEmotionColorFrom},{$emotion.attribute.gcEmotionColorTo});
               {/if}
               {if $emotion.attribute.gcEmotionHasPaddingTop}
                  padding-top: 6.25rem;
                  padding-bottom: 6.25rem;
               {/if}
               "
    {/if}
{/block} 
 
{block name="widgets/emotion/index/emotion"}
   {if $emotion.attribute.gcEmotionHasPadding}
       
        <div class="gc-emotion-container-content" style="background-color: {$emotion.attribute.gcEmotionColorFrom};
               {if $emotion.attribute.gcEmotionColorTo}
                 -webkit-background-image: linear-gradient({$emotion.attribute.gcEmotionColorFrom},{$emotion.attribute.gcEmotionColorTo});
                 -moz-background-image: linear-gradient({$emotion.attribute.gcEmotionColorFrom},{$emotion.attribute.gcEmotionColorTo});
                 -ms-background-image: linear-gradient({$emotion.attribute.gcEmotionColorFrom},{$emotion.attribute.gcEmotionColorTo});
                 background-image: linear-gradient({$emotion.attribute.gcEmotionColorFrom},{$emotion.attribute.gcEmotionColorTo});
               {/if}
               {if $emotion.attribute.gcEmotionHasPaddingTop}
                  padding-top: 6.25rem;
                  padding-bottom: 6.25rem;
               {/if}
               ">
            {$smarty.block.parent}
        </div>
        
   {else}
       {$smarty.block.parent}
   {/if}
{/block}


{block name="widgets/emotion/index/inner-element"} 
   {if $template == 'component_article_slider' && ($element.cssClass == 'gc-product-slider-3' || $element.cssClass == 'gc-product-slider-4')}
       {include file="widgets/emotion/components/component_article_slider.tpl" additionalClass=$element.cssClass} 
   {else}
       {$smarty.block.parent}
   {/if}
{/block}