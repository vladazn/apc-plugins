{block name="widgets_emotion_components_GcCategory_module"}    
     {if $Data}
     <div class="emotion--category-teaser gc-category-module">
            <a href="{url controller=listing action=index sCategory=$Data.gc_category}"
               title="{$Data.categoryTitle|strip_tags|escape}"
               class="category-teaser--link"
               id="teaser--{$Data.objectId}">

               <div class="gc-category-module-img-box">
                   <img src="{$Data.categoryImage}" />
               </div>
                
                <div class=gc-category-module-title-box>
                    <p class=gc-category-module-title>
                       {if $Data.categoryTitle}
                        {$Data.categoryTitle} {$emotion.attribute.gcShoppingWorldHeadline}
                       {else}
                        {action module=widgets controller=GcCategoryController categoryId=$Data.gc_category}
                       {/if}
                    </p>
                </div>
            </a>
        </div>
    {/if}
{/block}