{extends file="parent:frontend/checkout/shipping_payment_core.tpl"}

{block name='frontend_checkout_shipping_payment_core_shipping_fields' append}
    <strong>{s name="apcDeliveryDate"}Estimated Delivery Date:{/s}</strong> {$apcDeliveryDate}<br />
{/block}
