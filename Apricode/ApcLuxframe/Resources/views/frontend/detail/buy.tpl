{extends file='parent:frontend/detail/buy.tpl'}

{block name="frontend_detail_buy_variant" append}
<input id='frame_width_buy' type='hidden' name='lightbox_size_width' value="{$sArticle.lightbox_size_width}">
<input id='frame_height_buy' type='hidden' name='lightbox_size_height' value="{$sArticle.lightbox_size_height}">
<input class='media_buy' type='hidden' name='lightbox_media' value="{if $sArticle.custom_media_id}{$sArticle.custom_media_id}{else}-10{/if}">
{if $preselected}
<div id='data_preselected'></div>
{/if}
{/block}


{block name="frontend_detail_buy_button"}
    {if $sArticle.sConfigurator && !$activeConfiguratorSelection}
        <button class="buybox--button block btn is--disabled is--icon-right is--large" disabled="disabled" aria-disabled="true" name="{s name="DetailBuyActionAddName"}{/s}"{if $buy_box_display} style="{$buy_box_display}"{/if}>
            {s name="DetailBuyActionAdd"}{/s} <i class="icon--arrow-right"></i>
        </button>
    {else}
        <button class="buybox--button block btn is--primary is--icon-right is--center is--large is--disabled" disabledname="{s name="DetailBuyActionAddName"}{/s}"{if $buy_box_display} style="{$buy_box_display}"{/if}>
            {s name="DetailBuyActionAdd"}{/s} <i class="icon--arrow-right"></i>
        </button>
    {/if}
{/block}
