{extends file='parent:frontend/listing/product-box/box-list.tpl'}

{block name='frontend_listing_box_article_description'}
    <div class="product--description">
        {$sArticle.sProperties[6]['value']}
    </div>
{/block}
