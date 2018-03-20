{extends file='parent:frontend/index/index.tpl'}

{block name="frontend_index_body_inline" prepend}
<div class="infx--modal is--hidden">
    <div class="infx--modal-container">
    	<div class="column--content">
			<p class="column--desc">
				{s namespace="frontend/infx/modal" name="NewsletterText"}<p>Wollen Sie wirklich schon gehen?</p><p>Melden Sie sich zum Newsletter an und bekommen Sie einen Rabattcode</p>{/s}
			</p>

			<form class="newsletter--form" action="{url controller='newsletter'}" method="post">
				<input type="hidden" value="1" name="subscribeToNewsletter" />
				<input type="hidden" value="1" name="infx_newsletter"/>

				<input type="email" name="newsletter" class="newsletter--field" placeholder="{s namespace="frontend/index/menu_footer" name="IndexFooterNewsletterValue"}{/s}" />
				{if {config name="newsletterCaptcha"} !== "nocaptcha"}
					<input type="hidden" name="redirect">
				{/if}

				<button type="submit" class="newsletter--button btn">
					<i class="icon--mail"></i> <span class="button--text">{s namespace="frontend/infx/modal" name='NewsletterSubmit'}Subscribe to newsletter{/s}</span>
				</button>
			</form>
		</div>
    </div>
</div>
<span class="infx--modal-title is--hidden">{s namespace="frontend/infx/modal" name='NewsletterTitle'}Newsletter{/s}</span>
{/block}
