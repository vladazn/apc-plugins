{extends file="parent:frontend/checkout/ajax_add_article.tpl"}


{block name='checkout_ajax_add_cross_selling'}
    {if $sCrossSimilarShown|@count || $sCrossBoughtToo|@count || $accessoryArticles|@count}
        {if $accessoryArticles|@count}
            {$isAccessory = true}
        {/if}
        <div class="modal--cross-selling">
            <div class="panel has--border is--rounded">

                {* Cross sellung title *}
                {block name='checkout_ajax_add_cross_selling_title'}
                    <div class="panel--title is--underline">
                        {if $isAccessory}
                        <p class='infx-title'>{s name="infxCheckoutCrossSellingTitle"}Pommes ohne Ketchup und Mayo?{/s}</p>
                        <p class='infx-subtitle'>{s name="infxCheckoutCrossSellingSubtitle"}{/s}</p>
                        {else}
                            {s name="AjaxAddHeaderCrossSelling"}{/s}
                        {/if}
                    </div>
                {/block}

                {* Cross selling panel body *}
                {block name='checkout_ajax_add_cross_selling_panel'}
                    <div class="panel--body">

                        {* Cross selling product slider *}
                        {block name='checkout_ajax_add_cross_slider'}
                            {if $accessoryArticles|count >= 1}
                                {$sCrossSellingArticles = $accessoryArticles}
                            {elseif $sCrossBoughtToo|count < 1 && $sCrossSimilarShown}
                                {$sCrossSellingArticles = $sCrossSimilarShown}
                            {else}
                                {$sCrossSellingArticles = $sCrossBoughtToo}
                            {/if}

                            {include file="frontend/_includes/product_slider.tpl" articles=$sCrossSellingArticles}
                        {/block}
                    </div>
                {/block}
            </div>
        </div>
    {/if}
{/block}
