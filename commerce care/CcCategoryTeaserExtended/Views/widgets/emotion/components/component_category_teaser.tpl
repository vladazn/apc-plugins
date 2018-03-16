{extends file="parent:widgets/emotion/components/component_category_teaser.tpl"}

{block name="widget_emotion_component_category_teaser_panel" append}
   {if $element.cssClass eq 'show-subcat'}
       {action module=widgets controller=Ccfeatures action=getSubcategories sCategory=$Data.category->getId()}
   {/if}
{/block}