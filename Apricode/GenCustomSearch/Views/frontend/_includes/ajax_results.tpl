{if !$genHideCategorySearch}
    {if !empty($genCategory)}
        {block name="gen_custom_search_category_list"}
            <ul class="results--list">
                <li class="list--entry entry--no-results result--item">
                    {s name="category" namespace="frontend/gen/search"}Categories{/s}
                </li>
                {foreach $genCategory as $category}
                   {block name="gen_custom_search_category_list_item"}
                        <li class="list--entry block-group result--item">
                            <a class="search-result--link" href="{url controller=cat action=index sCategory=$category.id}">
                                {if !empty($category.categoryImage)}
                                    <span class="entry--media block">
                                        <img src="{$category.categoryImage}">
                                    </span>
                                {/if}
                                <span class="entry--name block">{$category.description}</span>
                            </a>
                        </li>
                    {/block}
                {/foreach}
            </ul>
        {/block}
    {/if}
{/if}
{if !$genHideShopPageSearch}
    {if !empty($genShopPageCustom) || !empty($genShopPageForm)}
        {block name="gen_custom_search_pages_list"}
            <ul class="results--list">
                <li class="list--entry entry--no-results result--item">
                    {s name="shop_pages" namespace="frontend/gen/search"}Shop Pages{/s}
                </li>
                {if !empty($genShopPageCustom)}
                    {foreach $genShopPageCustom as $shopPage}
                        {block name="gen_custom_search_pages_list_item_static"}
                            <li class="list--entry block-group result--item">
                                <a class="search-result--link" href="{url controller = 'custom' action = 'index' sCustom = $shopPage.id}">
                                    <span class="entry--name block">
                                        {$shopPage.description}
                                    </span>
                                </a>
                            </li>
                        {/block}
                    {/foreach}
                {/if}
                {if !empty($genShopPageForm)}
                    {foreach $genShopPageForm as $shopPage}
                        {block name="gen_custom_search_pages_list_item_support"}
                            <li class="list--entry block-group result--item">
                                <a class="search-result--link" href="{url controller = 'forms' action = 'index' sFid = $shopPage.id}">
                                    <span class="entry--name block">
                                        {$shopPage.name}
                                    </span>
                                </a>
                            </li>
                        {/block}
                    {/foreach}
                {/if}
            </ul>
        {/block}
    {/if}
{/if}
