{extends file="parent:frontend/index/index.tpl"}

{block name='frontend_index_top_bar_container'}{/block}

{block name="frontend_index_navigation_categories_top"}{/block}

{block name='frontend_index_header_navigation'}
    <div class="container header--navigation">

        {* Logo container *}
        {block name='frontend_index_logo_container'}
            {include file="frontend/index/logo-container.tpl"}
            <div class='wav--navigation'>
                <nav class="navigation-main">
                    <div class="container" data-menu-scroller="true" data-listSelector=".navigation--list.container" data-viewPortSelector=".navigation--list-wrapper">
                        {block name="frontend_index_navigation_categories_top_include"}
                            {include file='frontend/index/main-navigation.tpl'}
                        {/block}
                    </div>
                </nav>
            </div>
        {/block}

        {* Shop navigation *}
        {block name='frontend_index_shop_navigation'}
            {include file="frontend/index/shop-navigation.tpl"}
        {/block}

        {block name='frontend_index_container_ajax_cart'}
        {*}
            <div class="container--ajax-cart" data-collapse-cart="true"{if $theme.offcanvasCart} data-displayMode="offcanvas"{/if}></div>
        {*}
        {/block}
    </div>
    
    {if $theme.checkoutHeader && (({controllerName|lower} == "checkout" && {controllerAction|lower} != "cart") || ({controllerName|lower} == "register" && ($sTarget != "account" && $sTarget != "address")))}
        <div class="container header--navigation-mobile">
            {include file="frontend/index/shop-navigation-mobile-minimal.tpl"}
        </div>
    {else}
        <div class="container header--navigation-mobile">
            {include file="frontend/index/shop-navigation-mobile.tpl"}
        </div>
    {/if}
    <div class="container--ajax-cart" data-collapse-cart="true"{if $theme.offcanvasCart} data-displayMode="offcanvas"{/if}></div>
{/block}
