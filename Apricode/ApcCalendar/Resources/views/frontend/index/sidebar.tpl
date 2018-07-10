{extends file="parent:frontend/index/sidebar.tpl"}

{block name="frontend_index_left_inner" append}
    {action module=widgets controller=ApcCalendar action=index}
{/block}
