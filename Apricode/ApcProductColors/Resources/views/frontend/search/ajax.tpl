{extends file="parent:frontend/search/ajax.tpl"}

{block name='search_ajax_list_entry_name' append}
    {if $search_result.add_colors}
        {foreach $search_result.add_colors as $color}
            <i class='icon--danielbruce2' style='color:{$color}'></i>
        {/foreach}
    {/if}
{/block}
