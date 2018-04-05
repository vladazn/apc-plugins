{extends file="parent:frontend/listing/product-box/box-basic.tpl"}

{block name='frontend_listing_box_article_name'}
    {if $sArticle.series_cat}
        <a href="{url controller=cat action=index sCategory=$sArticle.series_cat}"
            class="product--title"
            title="{$sArticle.articleName|escapeHtml}">
            {$sArticle.articleName|truncate:50|escapeHtml}
        </a>

    {else}
        <a href="{$sArticle.linkDetails}"
            class="product--title"
            title="{$sArticle.articleName|escapeHtml}">
            {$sArticle.articleName|truncate:50|escapeHtml}
        </a>
    {/if}

{/block}
