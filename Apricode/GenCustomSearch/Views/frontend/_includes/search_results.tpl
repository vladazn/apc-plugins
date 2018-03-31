{if !$genHideCategorySearch}
    {if !empty($genCategory)}
        {block name="gen_custom_search_category_list"}
            <div class="results--list gen--list">
                <div class="results--headline">
                    {s name="category" namespace="frontend/gen/search"}Categories{/s}
                </div>
                {foreach $genCategory as $category}
                    {block name="gen_custom_search_category_list_item"}
                        <div class="search--result-item">
                            <div class="hero-unit category--teaser panel has--border is--rounded">
                                {if !empty($category.categoryImage)}
                                    <a class="entry--media block gen--span" href="{url controller=cat action=index  sCategory=$category.id}">
                                        <img src="{$category.categoryImage}" alt="{$category.description}">
                                    </a>
                                {/if}
                                <div class="hero--text panel--body is--wide">
                                    <a class="category-link" href="{url controller=cat action=index sCategory=$category.id}">
                                            {$category.description}
                                    </a>
                                    <div class="teaser--text-long">
                                        <p>{$category.cmstext|truncate:100}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {/block}
                {/foreach}
            </div>
        {/block}
    {/if}
{/if}
{if !$genHideShopPageSearch}
    {if !empty($genShopPageCustom) || !empty($genShopPageForm)}
        {block name="gen_custom_search_pages_list"}
            <div class="results--list gen--list">
                <div class="results--headline">
                    {s name="shop_pages" namespace="frontend/gen/search"}Shop Pages{/s}
                </div>
                {if !empty($genShopPageCustom)}
                    {foreach $genShopPageCustom as $shopPage}
                        {block name="gen_custom_search_category_list_item_static"}
                                <div class="search--result-item">
                                    <a class="search-result--link" href="{url controller = 'custom' action = 'index' sCustom = $shopPage.id}">
                                        <span class="entry--name block entry--gen">
                                            {$shopPage.description}

                                    </span>
                                    </a>
                                </div>
                        {/block}
                    {/foreach}
                {/if}
                {if !empty($genShopPageForm)}
                    {foreach $genShopPageForm as $shopPage}
                        {block name="gen_custom_search_category_list_item_support"}
                               <div class="search--result-item">
                                <a class="search-result--link" href="{url controller = 'forms' action = 'index' sFid = $shopPage.id}">
                                   <span class="entry--name block entry--gen">

                                        {$shopPage.name}

                                </span>
                                </a>
                                </div>
                        {/block}
                    {/foreach}
                {/if}
            </div>
        {/block}
    {/if}
{/if}
