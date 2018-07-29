{extends file='parent:frontend/detail/content.tpl'}

{block name='frontend_detail_index_tabs'}
    <div class='wav--tab-image-container'>
        <div class='wav--tab'>
            {$smarty.block.parent}
        </div>
        <div class='wav--image'>
            <img src='{$sArticle.image.thumbnails.2.source}'></img>
        </div>
    </div>
{/block}

{block name="frontend_detail_index_tabs_cross_selling"}

    {$showAlsoViewed = {config name=similarViewedShow}}
    {$showAlsoBought = {config name=alsoBoughtShow}}
    <div class="tab-menu--cross-selling"{if $sArticle.relatedProductStreams} data-scrollable="true"{/if}>

        {* Tab navigation *}
        {include file="frontend/detail/content/tab_navigation.tpl"}

        {* Tab content container *}
        {include file="frontend/detail/content/tab_container.tpl"}
    </div>
{/block}
