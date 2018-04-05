{extends file="parent:frontend/search/ajax.tpl"}


{block name="search_ajax_list_entry"}
    <li class="list--entry block-group result--item">
        {if $search_result.series_cat}
            <a class="search-result--link" href="{{url controller=cat action=index sCategory=$search_result.series_cat}}" title="{$search_result.name|escape}">
        {else}
            <a class="search-result--link" href="{$search_result.link}" title="{$search_result.name|escape}">
        {/if}
        {* Product image *}
        {block name="search_ajax_list_entry_media"}
            <span class="entry--media block">
                {if $search_result.image.thumbnails[0]}
                    <img srcset="{$search_result.image.thumbnails[0].sourceSet}" alt="{$search_result.name|escape}" class="media--image">
                {else}
                    <img src="{link file='frontend/_public/src/img/no-picture.jpg'}" alt="{"{s name='ListingBoxNoPicture'}{/s}"|escape}" class="media--image">
                {/if}
            </span>
        {/block}

        {* Product name *}
        {block name="search_ajax_list_entry_name"}
            <span class="entry--name block">
                {$search_result.name|escapeHtml}
            </span>
        {/block}

        {* Product price *}
        {block name="search_ajax_list_entry_price"}
            <span class="entry--price block">
                {$sArticle = $search_result}
                {*reset pseudo price value to prevent discount boxes*}
                {$sArticle.has_pseudoprice = 0}
                {include file="frontend/listing/product-box/product-price.tpl" sArticle=$sArticle}
            </span>
        {/block}
        </a>
    </li>
{/block}
