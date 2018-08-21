{* Listing actions *}
{block name='frontend_listing_actions_top'}
    {$listingMode = {config name=listingMode}}

    {block name="frontend_listing_actions_top_hide_detection"}
        {$class = 'listing--actions is--rounded'}

        {if ($sCategoryContent.hide_sortings || $sortings|count == 0)}
            {$class = "{$class} without-sortings"}
        {/if}

        {if ($theme.sidebarFilter || $facets|count == 0)}
            {$class = "{$class} without-facets"}
        {/if}

        {if $theme.infiniteScrolling}
            {$class = "{$class} without-pagination"}
        {/if}
    {/block}
    {foreach $facets as $facet}
        {if $facet->getFacetName() eq 'property'}
            <div data-listing-actions="true" data-buffertime="0" class="listing--actions is--rounded without-pagination">
               <div class="apc--filter">
                  <a href="#" class="filter--close-btn" data-show-products-text="%s Produkt(e) anzeigen">
                  </a>
                  <div class="filter--container">
                      <form id="filter"
                                 method="get"
                                 data-filter-form="true"
                                 data-is-in-sidebar="{if $theme.sidebarFilter}true{else}false{/if}"
                                 data-listing-url="{$countCtrlUrl}"
                                 data-is-filtered="{if $criteria}{$criteria->getUserConditions()|count}{else}0{/if}"
                                 data-load-facets="{if $listingMode == 'filter_ajax_reload'}true{else}false{/if}"
                                 data-instant-filter-result="{if $listingMode != 'full_page_reload'}true{else}false{/if}"
                                 class="{if $listingMode != 'full_page_reload'} is--instant-filter{/if}">

                        <input type="hidden" name="{$shortParameters['sPage']}" value="1"/>
                        {if $term}
                            <input type="hidden" name="{$shortParameters['sSearch']}" value="{$term|escape}"/>
                        {/if}
                        {if $sSort}
                            <input type="hidden" name="{$shortParameters['sSort']}" value="{$sSort|escape}"/>
                        {/if}
                        {if $criteria && $criteria->getLimit()}
                            <input type="hidden" name="{$shortParameters['sPerPage']}" value="{$criteria->getLimit()|escape}"/>
                        {/if}
                        {if !$sCategoryContent && $sCategoryCurrent != $sCategoryStart && {controllerName} != 'search'}
                            <input type="hidden" name="{$shortParameters['sCategory']}" value="{$sCategoryCurrent|escape}" />
                        {/if}

                        <div class="filter--facet-container" style="display: block;">
                           <div class="filter-panel filter--multi-selection filter-facet--value-list facet--property" data-filter-type="value-list" data-facet-name="property" data-field-name="f">
                              <div class="filter-panel--content input-type--value-list">
                                  {$tempFacet = $facet->getFacetResults()}
                                  {$tempFacet = $tempFacet[0]}
                                 <div class="filter-panel--option-list apc-filter-options">
                                     {foreach $tempFacet->getValues() as $key => $value}
                                        <div class="filter-panel--option">
                                           <div class="option--container">
                                               <label class="filter-panel--label {if $key == 0}is--first{/if}" for="__f__{$value->getId()}" {if $value->getId() == 1}id="is--tasty" data-is-tasty="true"{/if}>
                                                   <input type="checkbox" id="__f__{$value->getId()}" name="__f__{$value->getId()}" value="{$value->getId()}" class="">
                                                   <span>{$value->getLabel()}</span>
                                               </label>
                                           </div>
                                       </div>
                                    {/foreach}
                                </div>
                              </div>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            {break}
        {/if}
    {/foreach}

{/block}
