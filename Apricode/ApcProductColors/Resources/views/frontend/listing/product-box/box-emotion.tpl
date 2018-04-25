{extends file="parent:frontend/listing/product-box/box-emotion.tpl"}

{block name='frontend_listing_box_article_name' append}
    {if $sArticle.add_colors}
        {foreach $sArticle.add_colors as $color}
            <i class='icon--danielbruce2' style='color:{$color}'></i>
        {/foreach}
    {/if}
{/block}
