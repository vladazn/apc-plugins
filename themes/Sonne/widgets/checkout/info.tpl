{extends file="parent:widgets/checkout/info.tpl"}

{block name="frontend_index_checkout_actions_notepad"}
    <li class="navigation--entry entry--notepad" role="menuitem">
        <a href="{url controller='note'}" title="{"{s namespace='frontend/index/checkout_actions' name='IndexLinkNotepad'}{/s}"|escape}" class="btn">
            <img src="{media path='media/image/wishlist_icon.png'}">
            {if $sNotesQuantity > 0}
                <span class="badge notes--quantity">
                    {$sNotesQuantity}
                </span>
            {/if}
        </a>
    </li>
{/block}

{block name="frontend_index_checkout_actions_account"}
    <a href="{url controller='account'}"
       title="{"{if $userInfo}{s name="AccountGreetingBefore" namespace="frontend/account/sidebar"}{/s}{$userInfo['firstname']}{s name="AccountGreetingAfter" namespace="frontend/account/sidebar"}{/s} - {/if}{s namespace='frontend/index/checkout_actions' name='IndexLinkAccount'}{/s}"|escape}"
       class="btn is--icon-left entry--link account--link{if $userInfo} account--user-loggedin{/if}">
            <img src="{media path='media/image/log_in.png'}">
    </a>
{/block}


{block name="frontend_index_checkout_actions_cart"}
    <li class="navigation--entry entry--cart" role="menuitem">
        <a class="btn is--icon-left cart--link" href="{url controller='checkout' action='cart'}" title="{"{s namespace='frontend/index/checkout_actions' name='IndexLinkCart'}{/s}"|escape}">
            <span class="badge is--primary is--minimal cart--quantity{if $sBasketQuantity < 1} is--hidden{/if}">{$sBasketQuantity}</span>
            <img src="{media path='media/image/basket.png'}">
        </a>
        <div class="ajax-loader">&nbsp;</div>
    </li>
{/block}
