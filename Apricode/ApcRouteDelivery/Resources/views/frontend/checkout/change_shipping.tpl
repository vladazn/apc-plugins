{extends file="parent:frontend/checkout/change_shipping.tpl"}

{block name='frontend_checkout_shipping_fieldset_description'}
    {if $dispatch.description}
        <div class="method--description">
            {$dispatch.description}
        </div>
    {/if}
    {if $dispatch.id eq 9}
        <div class="method--description">
            <strong>{s name="apcDeliveryDate"}Estimated Delivery Date:{/s}</strong> {$apcDeliveryDate}<br />
        </div>
    {/if}
{/block}
