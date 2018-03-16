<div class="buttons--off-canvas">
    <a href="close--offcanvas" class="close--off-canvas entry--close-off-canvas">
        {if $apcNoteAdvancedConfig->side == 'fromRight'}
            <i class="icon--arrow-left"></i>
        {/if}
            {s namespace="frontend/checkout/ajax_cart" name="AjaxCartContinueShopping"}{/s}
        {if $apcNoteAdvancedConfig->side == 'fromLeft'}
            <i class="icon--arrow-right"></i>
        {/if}
    </a>
</div>
            
{if $sNotes}
    <div class="panel--table is--rounded">
        {foreach $sNotes as $sBasketItem}
            {include file="frontend/note/apc_item.tpl"}
        {/foreach}
    </div>
{else}
    <div class="panel--body is--wide">
        <p>{s namespace='frontend/note/index' name="NoteText"}{/s}</p>
        <p>{s namespace='frontend/note/index' name="NoteText2"}{/s}</p>
    </div>
{/if}

<a href="{url controller=note}" class="btn is--primary button--note is--icon-right" title="{s namespace='frontend/account/sidebar' name='AccountLinkNotepad'}{/s}">
    <i class="icon--arrow-right"></i>
    {s namespace='frontend/account/sidebar' name='AccountLinkNotepad'}{/s}
</a>