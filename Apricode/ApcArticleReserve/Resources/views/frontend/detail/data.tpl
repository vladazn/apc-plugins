{extends file="parent:frontend/detail/data.tpl"}

{block name='frontend_detail_data_price_configurator' prepend}
    {if !$sArticle.isAvailable}
        {action module=widgets controller=ApcArticleReserve action=timer ordernumber=$sArticle.ordernumber}
    {/if}
{/block}
