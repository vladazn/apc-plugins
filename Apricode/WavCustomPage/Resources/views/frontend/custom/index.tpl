{extends file="parent:frontend/custom/index.tpl"}

{block name="frontend_index_content"}
    {if $wavBottomEmotions|@count}
         <div class="content--emotions">
             <div class="emotion---wrapper">
                {foreach $wavBottomEmotions as $wavPageEmotionId}
                    {action module=widgets controller=emotion action=index emotionId=$wavPageEmotionId controllerName=$Controller}
                {/foreach}
             </div>
         </div>
         {if $formId}
            {action controller=forms action=index id=$formId isCustom=true}
         {/if}
    {else}
        {$smarty.block.parent}
    {/if}
{/block}

{block name="frontend_index_content"}
   {if !$wavTopEmotions|@count}
    <div class="custom-page--content content block">

        {* Custom page tab content *}
        {block name="frontend_custom_article"}
            <div class="content--custom">
                {block name="frontend_custom_article_inner"}
                    {* Custom page tab headline *}
                    {block name="frontend_custom_article_headline"}
                        <h1 class="custom-page--tab-headline">{$sCustomPage.description}</h1>
                    {/block}

                    {* Custom page tab inner content *}
                    {block name="frontend_custom_article_content"}
                        {$sContent}
                    {/block}
                {/block}
            </div>
        {/block}

    </div>
    {/if}
{/block}

{block name="frontend_index_breadcrumb"}
    {if $wavTopEmotions|@count}
       <div class="emotion--overlay"></div>
        <div class="top-emotion-container">
             <div class="content--emotions top-emotion">
                 <div class="emotion---wrapper">
                    {foreach $wavTopEmotions as $wavPageEmotionId}
                        {action module=widgets controller=emotion action=index emotionId=$wavPageEmotionId controllerName=$Controller}
                    {/foreach}
                 </div>
             </div>

            {$smarty.block.parent}
        </div>
    {else}
        {$smarty.block.parent}
    {/if}
{/block}

{block name="frontend_index_content_left"}
{/block}
