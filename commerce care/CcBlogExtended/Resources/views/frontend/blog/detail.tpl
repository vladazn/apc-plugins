{extends file="parent:frontend/blog/detail.tpl"}
 
{block name='frontend_blog_detail_images'}{/block}
{block name='frontend_blog_detail_metadata'}{/block}
{block name='frontend_blog_detail_box_header'}{/block}
{block name='frontend_blog_detail_comments_list'}{/block}

{block name='frontend_blog_detail_box_content'}
    
     {* include of the slider *}
     {include file="frontend/blog/images.tpl"}
     
     <div class="blog--box-metadata">
       
        {* Author *}
        {if $sArticle.author.name}
            <span class="blog--metadata-author blog--metadata is--first">{s name="BlogInfoFrom"}{/s}: {$sArticle.author.name}</span>
        {/if}
            
        {* Date *}
        <span class="blog--metadata-date blog--metadata{if !$sArticle.author.name} is--first{/if}" itemprop="dateCreated">{$sArticle.displayDate|date_format:$CcBlogExtendedPluginConfig.date_format}</span>

        {* Comments *}
        {if $sArticle.comments|count}
            <span class="blog--metadata-comments blog--metadata">
                <a data-scroll="true" data-scrollTarget="#blog--comments-start" href="#blog--comments-start" title="{"{s name="BlogLinkComments"}{/s}"|escape}">{$sArticle.comments|count|default:0} {s name="BlogInfoComments"}{/s}</a>
            </span>
        {/if}
        
        {* Rating *}
        {if $sArticle.sVoteAverage|round}
            <span class="blog--metadata-rating blog--metadata">
                <a data-scroll="true" data-scrollTarget="#blog--comments-start" href="#blog--comments-start" class="blog--rating-link" rel="nofollow" title="{"{s namespace='frontend/blog/detail' name='BlogHeaderRating'}{/s}"|escape}">
                    {include file="frontend/_includes/rating.tpl" points=$sArticle.sVoteAverage|round type="aggregated" count=$sArticle.comments|count}
                </a>
            </span>
        {/if}
     </div>
       
     <div class="blog--detail-main-content">
        <div class="blog--detail-box-content block">

            {* Title *}
            <h1 class="blog--detail-headline" itemprop="name">{$sArticle.title}</h1>

            {* Description *}
            <div class="blog--detail-description block" itemprop="articleBody">
                {$sArticle.description}
            </div>

            {* Tags *}
            <div class="blog--detail-tags block">
                {if $sArticle.tags}

                    {$tags=''}
                    {foreach $sArticle.tags as $tag}
                        {$tags="{$tags}{$tag.name}{if !$tag@last},{/if}"}
                    {/foreach}
                    <meta itemprop="keywords" content="{$tags}">

                    <span class="is--bold">{s name="BlogInfoTags"}{/s}:</span>
                    {foreach $sArticle.tags as $tag}
                        <a href="{url controller=blog sCategory=$sArticle.categoryId sFilterTags=$tag.name}" title="{$tag.name|escape}">{$tag.name}</a>{if !$tag@last}, {/if}
                    {/foreach}
                {/if}
            </div>

            <div class="blog--detail-actions">
                 <div class="pdf-downloaden"> 
                     <a href="{url controller=generateBlogPdf action=index blogArticle=$sArticle.id}" target="_blank">
                         <i class="{$CcBlogExtendedPluginConfig.pdf_icon_class}"></i>
                         {s name="pdfDownloadLink" namespace="frontend/blog/detail"}Hier als pdf-Versionen Downloaden!{/s}
                     </a>
                 </div>
                 <div class="leave-comment"> 
                      <div class="comments--actions">
                        <a class="btn--create-entry"
                           title="{s namespace="frontend/blog/comments" name="BlogHeaderWriteComment"}{/s}"
                           rel="nofollow"
                           data-collapse-panel="true"
                           data-collapseTarget=".comment--collapse-target">
                            <i class="{$CcBlogExtendedPluginConfig.comment_icon_class}"></i>
                            {s namespace="frontend/blog/comments" name="BlogHeaderWriteComment"}{/s}
                        </a>
                    </div>
                 </div>
             </div>
             
            {* include of the comment form *}
            {include file="frontend/blog/comments.tpl"}       
        </div>
        <div class="next--blog-articles">
           <span class="next-articles-note">{s name="nextBlogArticles" namespace="frontend/blog/detail"}nachster Artikel{/s}</span>
            {foreach from=$sBlogArticles item=each key=key name="counter"}
                {include file="frontend/blog/box.tpl" sArticle=$each key=$key isDetail=true}
            {/foreach}
        </div>
     </div>
     
{/block}
