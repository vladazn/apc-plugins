{function name="CcSubcategories" level=0}
    <ul class="cat--teaser menu--list menu--level-{$level}">
        {foreach $categories as $category}
            {if $category.hideTop}
                {continue}
            {/if}
            {$categoryLink = $category.link}
            {if $category.external}
                {$categoryLink = $category.external}
            {/if}
            <li class="menu--list-item item--level-{$level}">
                <a href="{$categoryLink|escapeHtml}" class="menu--list-item-link" title="{$category.name|escape}"{if $category.external && $category.externalTarget} target="{$category.externalTarget}"{/if}>{$category.name}</a>
                {if $category.sub}
                    {call name=CcSubcategories categories=$category.sub level=$level+1}
                {/if}
            </li>
        {/foreach}
    </ul>
{/function}

{if $subcategories}
   {call name="CcSubcategories" categories=$subcategories}
{/if}