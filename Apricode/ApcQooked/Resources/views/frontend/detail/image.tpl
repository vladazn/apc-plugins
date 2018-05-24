{extends file="parent:frontend/detail/image.tpl"}

{block name='frontend_detail_image_default_image_slider_item'}
    {if $sArticle.image}
        {$smarty.block.parent}
    {/if}
{/block}
