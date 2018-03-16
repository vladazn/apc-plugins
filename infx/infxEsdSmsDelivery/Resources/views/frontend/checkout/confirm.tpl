{extends file="parent:frontend/checkout/confirm.tpl"}

{block name='frontend_checkout_confirm_newsletter' append}
    {if $smsConfirm}
        <li class="block-group row--tos">
            <span class="block column--checkbox">
                    <input type="checkbox" name='smsConfirm' id='smsConfirm' />
            </span>

            <span class="block column--label">
                <label for='smsConfirm' data-height="500" data-width="750">{s name="smsConfirmLabel"}Bitte senden Sie mir die Bestellung auch per SMS zu.{/s}</label>
            </span>
        </li>

        <li class="block-group row--tos" id='smsPhone'>
                <input type="text" name="smsPhone" value="{$userPhone}" placeholder="{s name='smsConfirmPlaceHolder'}Handynummer{/s}" />
        </li>
    {/if}
{/block}
