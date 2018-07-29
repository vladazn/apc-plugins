{extends file='parent:frontend/detail/tabs.tpl'}

{block name="frontend_detail_tabs_description" append}
    <a href="#" class="tab--link" title="{s name='DetailTabsDelivery'}Delivery{/s}" data-tabName="delivery">{s name='DetailTabsDelivery'}Delivery{/s}</a>
    <a href="#" class="tab--link" title="{s name='DetailTabsMoreInfo'}More Info{/s}" data-tabName="moreinfo">{s name='DetailTabsMoreInfo'}More Info{/s}</a>
{/block}

{block name="frontend_detail_tabs_content_description" append}
    <div class="tab--container">

        {* Description title *}
        <div class="tab--header">
            <a href="#" class="tab--title" title="{s name='DetailTabsDelivery'}Delivery{/s}">{s name='DetailTabsDelivery'}Delivery{/s}</a>
        </div>

        {* Description preview *}
        <div class="tab--preview">
            {$sArticle.wav_delivery|strip_tags|truncate:100:'...'}<a href="#" class="tab--link" title="{s name="PreviewTextMore"}{/s}">{s name="PreviewTextMore"}{/s}</a>
        </div>

        {* Description content *}
        <div class="tab--content">
            {include file="frontend/detail/tabs/delivery.tpl"}
        </div>

    </div>

    <div class="tab--container">

        {* Description title *}
        <div class="tab--header">
            <a href="#" class="tab--title" title="{s name='DetailTabsMoreInfo'}More Info{/s}">{s name='DetailTabsMoreInfo'}More Info{/s}</a>
        </div>

        {* Description preview *}
        <div class="tab--preview">
            {$sArticle.wav_more_info|strip_tags|truncate:100:'...'}<a href="#" class="tab--link" title="{s name="PreviewTextMore"}{/s}">{s name="PreviewTextMore"}{/s}</a>
        </div>

        {* Description content *}
        <div class="tab--content">
            {include file="frontend/detail/tabs/moreinfo.tpl"}
        </div>

    </div>
{/block}
