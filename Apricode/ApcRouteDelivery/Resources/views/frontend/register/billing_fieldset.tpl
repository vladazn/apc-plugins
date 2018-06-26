{extends file="parent:frontend/register/billing_fieldset.tpl"}

{block name='frontend_register_billing_fieldset_input_zip_and_city'}
                    <div class="register--zip-city">
                        {if {config name=showZipBeforeCity}}
                            <input autocomplete="section-billing billing postal-code"
                                   name="register[billing][zipcode]"
                                   type="text"
                                   required="required"
                                   aria-required="true"
                                   placeholder="{s name='RegisterBillingPlaceholderZipcode'}{/s}{s name="RequiredField" namespace="frontend/register/index"}{/s}"
                                   id="zipcode"
                                   value="{$form_data.zipcode|escape}"
                                   class="register--field register--spacer register--field-zipcode is--required{if isset($error_flags.zipcode)} has--error{/if}" />
                                   <p class='zip--error'></p>

                            <input autocomplete="section-billing billing address-level2"
                                   name="register[billing][city]"
                                   type="text"
                                   required="required"
                                   aria-required="true"
                                   placeholder="{s name='RegisterBillingPlaceholderCity'}{/s}{s name="RequiredField" namespace="frontend/register/index"}{/s}"
                                   id="city"
                                   value="{$form_data.city|escape}"
                                   size="25"
                                   class="register--field register--field-city is--required{if isset($error_flags.city)} has--error{/if}" />
                        {else}
                            <input autocomplete="section-billing billing address-level2"
                                   name="register[billing][city]"
                                   type="text"
                                   required="required"
                                   aria-required="true"
                                   placeholder="{s name='RegisterBillingPlaceholderCity'}{/s}{s name="RequiredField" namespace="frontend/register/index"}{/s}"
                                   id="city"
                                   value="{$form_data.city|escape}"
                                   size="25"
                                   class="register--field register--spacer register--field-city is--required{if isset($error_flags.city)} has--error{/if}" />

                            <input autocomplete="section-billing billing postal-code"
                                   name="register[billing][zipcode]"
                                   type="text"
                                   required="required"
                                   aria-required="true"
                                   placeholder="{s name='RegisterBillingPlaceholderZipcode'}{/s}{s name="RequiredField" namespace="frontend/register/index"}{/s}"
                                   id="zipcode"
                                   value="{$form_data.zipcode|escape}"
                                   class="register--field register--field-zipcode is--required{if isset($error_flags.zipcode)} has--error{/if}" />
                                   <p class='zip--error'></p>
                        {/if}
                    </div>
                {/block}
