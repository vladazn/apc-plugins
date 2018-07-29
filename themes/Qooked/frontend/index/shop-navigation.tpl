{extends file='parent:frontend/index/shop-navigation.tpl'}

{block name="frontend_index_search"}
    {if $isMobile}
        <li class='navigation--entry '>
            {include file="frontend/index/logo-container.tpl"}
        </li>
    {/if}
{/block}
