{extends file="parent:frontend/account/order_item_details.tpl"}

{block name='frontend_account_order_item_label_ordernumber' append}
    <p class="is--strong">Estimated Delivery:</p>
{/block}

{block name='frontend_account_order_item_ordernumber' append}
    <p>{$offerPosition.apcDeliveryDate}</p>
{/block}
