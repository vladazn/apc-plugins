{extends file='parent:widgets/checkout/info.tpl'}

{block name="frontend_index_checkout_actions_account"}
    <a href="{url controller='account'}"
       title="{"{if $userInfo}{s name="AccountGreetingBefore" namespace="frontend/account/sidebar"}{/s}{$userInfo['firstname']}{s name="AccountGreetingAfter" namespace="frontend/account/sidebar"}{/s} - {/if}{s namespace='frontend/index/checkout_actions' name='IndexLinkAccount'}{/s}"|escape}"
       class="btn is--icon-left entry--link account--link{if $userInfo} account--user-loggedin{/if}">
       <i class="icon--account"></i>
        <span class="account--display">
            {s namespace='frontend/index/checkout_actions' name='IndexLinkAccount'}{/s}
        </span>
    </a>
{/block}


{block name="frontend_index_checkout_actions_cart"}
    <li class="navigation--entry entry--cart" role="menuitem">
        <a class="btn is--icon-left cart--link" href="{url controller='checkout' action='cart'}" title="{"{s namespace='frontend/index/checkout_actions' name='IndexLinkCart'}{/s}"|escape}">
            <span class="cart--display">
                {if $sUserLoggedIn}
                    {s name='IndexLinkCheckout' namespace='frontend/index/checkout_actions'}{/s}
                {else}
                    {s namespace='frontend/index/checkout_actions' name='IndexLinkCart'}{/s}
                {/if}
            </span>

            <span class="badge is--primary is--minimal cart--quantity{if $sBasketQuantity < 1} is--hidden{/if}">{$sBasketQuantity}</span>

            <i class="icon--basket"></i>

            <span class="cart--amount">
                {$sBasketAmount|currency} {s name="Star" namespace="frontend/listing/box_article"}{/s}
            </span>
        </a>
        <div class="ajax-loader">&nbsp;</div>
    </li>
{/block}
