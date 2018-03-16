{extends file="parent:frontend/listing/actions/action-filter-button.tpl"}

{block name="frontend_listing_actions_filter_button" append}
    {if {controllerName|lower} neq 'search'}
        <div class="apc--jspane-viewmode apc-panel-viewmode">
            <a href="" class="btn apc-produc-listing-list is--active" data-type='minimal' data-ctrl-path='{url module=widgets controller=listing action=ajaxListing}'>
                <i class="icon--layout2"></i>
            </a>
            <a href="" class="btn apc-produc-listing-list" data-type='list' data-ctrl-path='{url module=widgets controller=listing action=ajaxListing}'>
                <i class="icon--list2"></i>
            </a>
        </div>
    {/if}
{/block}
