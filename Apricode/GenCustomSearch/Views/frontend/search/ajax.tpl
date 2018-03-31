{extends file="parent:frontend/search/ajax.tpl"}

{* no search results *}
{block name="search_ajax_inner_no_results"}
    <ul class="results--list">
        <li class="list--entry entry--no-results result--item">
            {s name="no_items_found" namespace="frontend/gen/search"}No items found{/s}
        </li>
    </ul>
    {block name="gen_additional_ajax_search_results_no_result"}
        {include file="frontend/_includes/ajax_results.tpl"}
    {/block}
{/block}

{block name="search_ajax_inner" append}
    {* block for additional ajax search results *}
    {block name="gen_additional_ajax_search_results_inner"}
        {include file="frontend/_includes/ajax_results.tpl"}
    {/block}
{/block}