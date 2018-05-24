{extends file="parent:frontend/checkout/items/product.tpl"}

{block name="frontend_checkout_cart_item_image_container"}
    {if $sBasketItem.additional_details.image.thumbnails[0]}
        {$smarty.block.parent}
    {/if}
{/block}
