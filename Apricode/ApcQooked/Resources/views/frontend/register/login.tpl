{extends file="parent:frontend/register/login.tpl"}

{block name='frontend_register_login_newcustomer'}
    {if {config name=showCompanySelectField}}
        {$smarty.block.parent}
    {/if}
{/block}
