{extends file="parent:frontend/account/sidebar.tpl"}


{block name="frontend_account_menu_link_partner_statistics" append}
    {if $sUserLoggedIn}
        <li class="navigation--entry">
           <a href="{url module='frontend' controller='PrivateWebinar'}" class="navigation--link{if {controllerName} == 'note'} is--active{/if}" rel="nofollow">
               {s name="PrivateWebinar"}Private Webinars{/s}
           </a>
       </li>
    {/if}
{/block}
