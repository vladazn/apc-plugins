{extends file="parent:frontend/checkout/finish.tpl"}

{block name='frontend_checkout_finish_invoice_number' append}
    <strong>{s name="apcDeliveryDate"}Estimated Delivery Date:{/s}</strong> {$apcDeliveryDate}<br />
{/block}
