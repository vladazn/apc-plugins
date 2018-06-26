{extends file="parent:frontend/checkout/confirm.tpl"}

{block name='frontend_checkout_confirm_left_shipping_method'}
    <p class="shipping--method-info">
        <strong class="shipping--title">{s name="ConfirmHeadDispatch"}{/s}</strong>
        <span class="shipping--description" title="{$sDispatch.name}">{$sDispatch.name|truncate:25:"...":true}</span>
    </p>
    {if $sDispatch.id eq 9}
    <p class="shipping--method-info">
        <strong class="shipping--title">{s name="apcDeliveryDate"}Estimated Delivery Date:{/s}</strong>
        <span class="shipping--description" title="{$sDispatch.name}">{$apcDeliveryDate}</span>
    </p>
    {/if}
{/block}
