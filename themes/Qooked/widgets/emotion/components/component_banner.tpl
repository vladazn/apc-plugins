{extends file="parent:widgets/emotion/components/component_banner.tpl"}

{block name="widget_emotion_component_banner_inner"}
    {if $element.cssClass}
        {$file = "widgets/emotion/new-component/`$element.cssClass`.tpl" }
        {include file=$file}
    {/if}
    {$smarty.block.parent}
{/block}
