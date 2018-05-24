{extends file="parent:frontend/checkout/confirm.tpl"}


{block name="frontend_checkout_confirm_information_addresses_shipping_panel_actions_change"}
    {if $sUserData.change_address == 1}
        {$smarty.block.parent}
    {/if}
{/block}

{block name="frontend_checkout_confirm_information_addresses_shipping_panel_actions_select_address"}
    {if $sUserData.change_address == 1}
        {$smarty.block.parent}
    {/if}
{/block}
