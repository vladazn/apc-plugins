{extends file="parent:frontend/index/index.tpl"}

{block name='frontend_index_header_javascript_data' prepend}
    {action module=widgets controller=ApcArticleReserve action=scedule}
{/block}
