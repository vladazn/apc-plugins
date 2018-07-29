{extends file='parent:frontend/listing/product-box/box-minimal.tpl'}


{block name='frontend_listing_box_article_description'}
    <div class="product--description">
        {$sArticle.description_long|strip_tags|truncate:240}
    </div>
{/block}
