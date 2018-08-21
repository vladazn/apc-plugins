{extends file='parent:frontend/listing/product-box/box-basic.tpl'}

{block name='frontend_listing_box_article_info_container'}
    <div class="product--info {if !isset($sArticle.image.thumbnails)}no--image{/if}">

        {* Product image *}
        {block name='frontend_listing_box_article_picture'}
            {if isset($sArticle.image.thumbnails)}
                {include file="frontend/listing/product-box/product-image.tpl"}
            {/if}
        {/block}
        <div class='product--details'>
        {* Customer rating for the product *}
        {block name='frontend_listing_box_article_rating'}
            {if !{config name=VoteDisable}}
                <div class="product--rating-container">
                    {if $sArticle.sVoteAverage.average}
                        {include file='frontend/_includes/rating.tpl' points=$sArticle.sVoteAverage.average type="aggregated" label=false microData=false}
                    {/if}
                </div>
            {/if}
        {/block}

        {* Product name *}
        {block name='frontend_listing_box_article_name'}
            <span class="weekdays">{$sArticle.sProperties[5]['value']}</span>
            <a href="{$sArticle.linkDetails}"
               class="product--title"
               title="{$sArticle.articleName|escapeHtml}">
                {$sArticle.articleName}
                <sup>{$sArticle.sProperties[7]['value']}</sup>
            </a>
            <div class="apc--subtitle">{$sArticle.apc_subtitle}</div>
        {/block}
        {* Variant description *}
        {block name='frontend_listing_box_variant_description'}
            {if $sArticle.attributes.swagVariantConfiguration}
                <div class="variant--description">
                    <span title="
                        {foreach $sArticle.attributes.swagVariantConfiguration->get('value') as $group}
                                {$group.groupName}: {$group.optionName}
                        {/foreach}
                        ">
                        {foreach $sArticle.attributes.swagVariantConfiguration->get('value') as $group}
                            <span class="variant--description--line">
                                <span class="variant--groupName">{$group.groupName}:</span> {$group.optionName} {if !$group@last}|{/if}
                            </span>
                        {/foreach}
                    </span>
                </div>
            {/if}
        {/block}

        {* Product description *}
        {block name='frontend_listing_box_article_description'}
            <div class="product--description">
                {$sArticle.description_long|strip_tags|truncate:240}
            </div>
        {/block}



            <div class="product--btn-container">
                <div class="product--price-info">

                    {* Product price - Unit price *}
                    {block name='frontend_listing_box_article_unit'}
                    {include file="frontend/listing/product-box/product-price-unit.tpl"}
                    {/block}

                    {* Product price - Default and discount price *}
                    {block name='frontend_listing_box_article_price'}
                    {include file="frontend/listing/product-box/product-price.tpl"}
                    {/block}
                </div>
                {if {config name="displayListingBuyButton"}}
                    {if $sArticle.allowBuyInListing}
                        {include file="frontend/listing/product-box/button-buy.tpl"}
                    {else}
                        {include file="frontend/listing/product-box/button-detail.tpl"}
                    {/if}
                {/if}
            </div>

        {* Product actions - Compare product, more information *}
        {block name='frontend_listing_box_article_actions'}

        {/block}
    </div>
    </div>
{/block}
