{extends file="parent:frontend/listing/product-box/box-emotion.tpl"}

{block name='frontend_listing_box_article_name'}
    <a href="{$sArticle.linkDetails}"
       class="product--title"
       title="{$productName|escapeHtml}">
        {$productName|truncate:22:'...':true|escapeHtml}
    </a>
    <div class="product--description">
        {$sArticle.description_long|strip_tags|truncate:80}
    </div>
{/block}

{block name='frontend_listing_box_article_unit'}{/block}
