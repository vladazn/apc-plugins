{extends file="parent:frontend/account/orders.tpl"}


{block name="frontend_account_order_item_detail_table" append}
    {foreach $offerPosition.subs as $subscription}
            {include file="frontend/account/subscription_item.tpl"}
    {/foreach}
{/block}

{block name="frontend_account_order_item_detail_table_row" append}
        {if $article.article.attributes.core->get('is_subscription') eq 1}
            <div class='subscriptionAction'>
            {if $subscriptionData[$article.id].paused eq 1}
                <span> Paused Untill {$subscriptionData[$article.id].paused_untill} </span>
            {else}
                {if !$offerPosition.status|in_array:[-1,2,4]}
                <select class='pauseDuration'>
                    <option value="1">1 Week</option>
                    <option value="2">2 Weeks</option>
                    <option value="3">4 Weeks</option>
                    <option value="4">6 Weeks</option>
                </select>

                <button type='button' class='btn is--secondary pauseOrder' data-detail='{$article.id}' data-ctrl-path='{url controller=Subscription action=pause}'>{s name="frontend/account/orders/pause_subscription"}Pause Subscription{/s}</button>
                {/if}
            {/if}
            </div>
        {/if}
{/block}
