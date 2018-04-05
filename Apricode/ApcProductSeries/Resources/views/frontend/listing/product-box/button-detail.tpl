{extends file="parent:frontend/listing/product-box/button-detail.tpl"}

{block name="frontend_listing_product_box_button_detail_url"}
    {if $sArticle.series_cat}
        {$url = {url controller=cat action=index sCategory=$sArticle.series_cat} }
    {else}
        {$url = {$sArticle.linkDetails} }
    {/if}
{/block}
