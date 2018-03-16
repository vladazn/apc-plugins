{extends file="parent:frontend/checkout/finish.tpl"}

{block name='frontend_checkout_finish_teaser_actions'}
    <p class="teaser--actions">
        {strip}
        {* Back to the shop button *}
        <a href="{url controller='index'}" class="btn is--secondary teaser--btn-back is--icon-left" title="{"{s name='FinishButtonBackToShop'}{/s}"|escape}">
            <i class="icon--arrow-left"></i>&nbsp;{"{s name="FinishButtonBackToShop" namespace="frontend/checkout/finish"}{/s}"|replace:' ':'&nbsp;'}
        </a>

        {* Print button *}
        <a href="#" class="btn is--primary teaser--btn-print" onclick="self.print()" title="{"{s name='FinishLinkPrint'}{/s}"|escape}">
            {s name="FinishLinkPrint" namespace="frontend/checkout/finish"}{/s}
        </a>
        
        {* Download Ticket link *}
        {if $allowDownloadTickets} 
            <a href="{url controller=downloadTickets action=index}" style="margin-left:1rem;" class="btn is--primary teaser--btn-ticket" target="_blank"> {s name='TicketDownloadLinkLabel' namespace='frontend\checkout\finish'} Download Ticket(s) {/s}</a>
        {/if}
        
        {/strip}
    </p>

    {* Print notice *}
    {block name='frontend_checkout_finish_teaser_print_notice'}
        <p class="print--notice">
            {s name="FinishPrintNotice" namespace="frontend/checkout/finish"}{/s}
        </p>
    {/block}
{/block}
