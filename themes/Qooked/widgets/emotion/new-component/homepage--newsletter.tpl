<div class='homepage--newsletter-content'>
    <div class='homepage--newsletter-container'>
        <h2>{s name='newsletterTitle'}Stay updated{/s}</h2>
        <p>{s name='newsletterText'}Get $15 off, and receive the latest recipes by subscribing now!{/s}</p>
        <div class='footer-main'>
            <form class="newsletter--form" action="{url controller='newsletter'}" method="post">
                <div class='newsletter--form-input'>
                    <input type="hidden" value="1" name="subscribeToNewsletter" />

                    <input type="email" name="newsletter" class="newsletter--field" placeholder="{s name="IndexFooterNewsletterValue"}{/s}" />
                    {if {config name="newsletterCaptcha"} !== "nocaptcha"}
                        <input type="hidden" name="redirect">
                    {/if}

                    <button type="submit" class="newsletter--button btn">
                        <i class="icon--mail"></i> <span class="button--text">{s name='IndexFooterNewsletterSubmit'}{/s}</span>
                    </button>
                </div>
                {* Data protection information *}
                {if {config name=ACTDPRTEXT} || {config name=ACTDPRCHECK}}
                <div class='newsletter--form-text'>
                    {$hideCheckbox=false}

                    {* If a captcha is active, the user has to accept the privacy statement on the newsletter page *}
                    {if {config name=newsletterCaptcha} !== "nocaptcha"}
                        {$hideCheckbox=true}
                    {/if}

                    {include file="frontend/_includes/privacy.tpl" hideCheckbox=$hideCheckbox}
                </div>
                {/if}
            </form>
        </div>
    </div>
</div>
