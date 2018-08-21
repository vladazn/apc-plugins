{extends file='parent:frontend/detail/content/header.tpl'}

{block name="frontend_detail_index_name"}

<div class='apc--titles'>
    <h1 class="product--title" itemprop="name">
        {$sArticle.articleName}
    </h1>
    <h2 class='apc--subtitle'>
        {$sArticle.apc_subtitle}
    </h2>
</div>
{/block}

{block name="frontend_detail_index_header_inner" append}
<div class='apc--header-actions'>
    <nav class="product--actions">
        {include file="frontend/detail/apc-actions.tpl"}
    </nav>
</div>
{/block}

{block name="frontend_detail_comments_overview"}
    {if !{config name=VoteDisable} && $sArticle.sVoteAverage.average}
        <div class="product--rating-container">
            <a href="#product--publish-comment" class="product--rating-link" rel="nofollow" title="{"{s namespace="frontend/detail/actions" name='DetailLinkReview'}{/s}"|escape}">
                {include file='frontend/_includes/rating.tpl' points=$sArticle.sVoteAverage.average type="aggregated" count=$sArticle.sVoteAverage.count}
            </a>
        </div>
    {/if}
{/block}
