{extends file="parent:widgets/emotion/components/component_html_code.tpl"}

{block name="widget_emotion_component_html_code"}
    {if "widgets/emotion/new-component/`$element.cssClass`.tpl"|template_exists}
        {$file = "widgets/emotion/new-component/`$element.cssClass`.tpl" }
        {include file=$file}
    {else}
        {$smarty.block.parent}
    {/if}
{/block}


