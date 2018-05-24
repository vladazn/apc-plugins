{extends file="parent:frontend/detail/content/header.tpl"}

{block name='frontend_detail_index_name'}
    <div class='apc--weekday'>
        <span class="apc--det-weekdays">{$sArticle.sProperties[5]['value']}</span>
    </div>
    <div class='apc--titles'>
        <h1 class="product--title" itemprop="name">
            {$sArticle.articleName}
        </h1>
        <h2 class='apc--subtitle'>
            {$sArticle.apc_subtitle}
        </h2>
    </div>
{/block}
