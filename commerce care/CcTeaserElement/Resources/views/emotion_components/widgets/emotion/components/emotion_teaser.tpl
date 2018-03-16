{block name="widgets_emotion_components_teaser_element"}
    {$category = $Data.category}
    {if $category}
        <div class="emotion--cc-category-teaser">
            {$categoryLink = $category.link}
            {if $category.external}
                {$categoryLink = $category.external}
            {/if}
            <a href="{$category.name|strip_tags|escape}"
               {if $category.external && $category.externalTarget}
                   target="{$category.externalTarget}"
               {/if}
               class="category-teaser--link">

                {* Category teaser title *}
                <span class="category-teaser--title">
                    {$category.name}
                </span>
            </a>
        </div>
        {if $category.sub}
            <ul class="subcategory--list">
                {foreach $category.sub as $subcategory}
                    {if $subcategory.hideTop}
                        {continue}
                    {/if}
                    {$categoryLink = $subcategory.link}
                    {if $category.external}
                        {$categoryLink = $subcategory.external}
                    {/if}
                    <li class="subcategory--list-item">
                        <a href="{$categoryLink|escapeHtml}" class="subcategory--list-item-link" title="{$subcategory.name|escape}"{if $subcategory.external && $subcategory.externalTarget} target="{$subcategory.externalTarget}"{/if}>{$category.name}</a>
                    </li>
                {/foreach}
            </ul>
        {/if}
    {/if}
{/block}
