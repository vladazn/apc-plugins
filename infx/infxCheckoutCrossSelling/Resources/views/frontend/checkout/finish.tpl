{extends file="parent:frontend/checkout/finish.tpl"}

{block name='frontend_checkout_finish_teaser'}
 <div class="finish--table product--table">
     {if $accessoryArticles|@count}
        <div class="panel has--border is--rounded infx-promo">

            {* Cross selling panel body *}
            <div class="panel--body is--rounded">
                <div class="panel--title is--underline ">
                    <p class='infx-title'>{s name="infxCheckoutCrossSellingTitle"}Pommes ohne Ketchup und Mayo?{/s}</p>
                    <p class='infx-subtitle'>{s name="infxCheckoutCrossSellingSubtitle"}{/s}</p>
                </div>
                {* Cross selling product slider *}
                {include file="frontend/_includes/product_slider.tpl" articles=$accessoryArticles}
            </div>
        </div>
    {/if}
        <div class="panel has--border">
            <div class="panel--body is--rounded">

                {* Table header *}
                {block name='frontend_checkout_finish_table_header'}
                    {include file="frontend/checkout/finish_header.tpl"}
                {/block}

                {* Article items *}
                {foreach $sBasket.content as $key => $sBasketItem}
                    {block name='frontend_checkout_finish_item'}
                        {include file='frontend/checkout/finish_item.tpl' isLast=$sBasketItem@last}
                    {/block}
                {/foreach}

                {* Table footer *}
                {block name='frontend_checkout_finish_table_footer'}
                    {include file="frontend/checkout/finish_footer.tpl"}
                {/block}
            </div>
        </div>
    </div>

<div class="finish--teaser panel has--border is--rounded">
    <h2 class="panel--title teaser--title is--align-center">{s name="FinishHeaderThankYou"}{/s} {$sShopname|escapeHtml}!</h2>
    <div class="panel--body is--wide is--align-center">
        {if $confirmMailDeliveryFailed}
            {include file="frontend/_includes/messages.tpl" type="error" content="{s name="FinishInfoConfirmationMailFailed"}{/s}"}
        {/if}

        <p class="teaser--text">
            {if !$confirmMailDeliveryFailed}
                {s name="FinishInfoConfirmationMail"}{/s}
                <br />
            {/if}

            {s name="FinishInfoPrintOrder"}{/s}
        </p>
        <p class="teaser--actions">
            {strip}
            {* Back to the shop button *}
            <a href="{url controller='index'}" class="btn is--secondary teaser--btn-back is--icon-left" title="{"{s name='FinishButtonBackToShop'}{/s}"|escape}">
                <i class="icon--arrow-left"></i>&nbsp;{"{s name="FinishButtonBackToShop"}{/s}"|replace:' ':'&nbsp;'}
            </a>

            {* Print button *}
            <a href="#" class="btn is--primary teaser--btn-print" onclick="self.print()" title="{"{s name='FinishLinkPrint'}{/s}"|escape}">
                {s name="FinishLinkPrint"}{/s}
            </a>
            {/strip}
        </p>
        <p class="print--notice">
            {s name="FinishPrintNotice"}{/s}
        </p>
    </div>
</div>
{/block}
