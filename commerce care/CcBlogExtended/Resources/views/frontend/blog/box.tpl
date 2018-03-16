{extends file="parent:frontend/blog/box.tpl"}


{block name='frontend_blog_col_description_short'}
   {if $isDetail}
        <div class="blog--box-description-short">
            {if $sArticle.shortDescription}
            {$sArticle.shortDescription|nl2br|truncate:150}
            {else}
            {$sArticle.shortDescription|truncate:150}
            {/if}
        </div>
    {else}
        {$smarty.block.parent}
    {/if}
{/block}

{* Date *}
{block name='frontend_blog_col_meta_data_date'}
    {if $sArticle.displayDate}
        <span class="blog--metadata-date blog--metadata is--nowrap is--first">{$sArticle.displayDate|date_format:$CcBlogExtendedPluginConfig.date_format}</span>
    {/if}
{/block}

{block name='frontend_blog_col_meta_data_rating'}
    {if $isDetail}
    
    {else}
        {$smarty.block.parent}
    {/if}
{/block}

{block name='frontend_blog_col_meta_data_comments'}
    {if $isDetail}
    
    {else}
        {$smarty.block.parent}
    {/if}
{/block}

{block name='frontend_blog_col_meta_data_name'}
    {if $isDetail}
    
    {else}
        {$smarty.block.parent}
    {/if}
{/block}

{block name='frontend_blog_col_tags'}
    {if $isDetail}
    
    {else}
        {$smarty.block.parent}
    {/if}
{/block}