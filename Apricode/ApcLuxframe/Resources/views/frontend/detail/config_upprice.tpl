<form method="post" action="{url sArticle=$sArticle.articleID sCategory=$sArticle.categoryID}" class="configurator--form upprice--form">
    {if $sArticle.apc_is_luxframe}
        <div class='lighbox--container' data-luxframe="true">
            <div class='lightbox--tab is--active' data-selection='2'>
                <div class='lightbox--title'><span>{s name='lightbox_Gross'}größe & Befestingung{/s}</span><i class='icon--check'></i></div>
                <div class='lightbox--content'>
                    {include file='frontend/detail/components/radio_input.tpl' config=$sArticle.sConfigurator[0]}
                    <div class='text--content'>
                        <label for='frame_width'>
                            {s name='lightbox_width_label'}Breite (min. 500mm, max. 4000mm){/s}
                        </label>
                        <input id='frame_width' type='number' name='lightbox_size_width' min="500" max="4000" value="{$sArticle.lightbox_size_width}">
                        <label for='frame_height'>
                            {s name='lightbox_height_label'}Hohe (min. 500mm, max. 4000mm){/s}
                        </label>
                        <input type='number' id='frame_height' name='lightbox_size_height'  min="500" max="4000" value="{$sArticle.lightbox_size_height}">
                        <p>{s name='lightbox_depth_label'}Tiefe{/s}</p>
                        {include file='frontend/detail/components/select_input.tpl' config=$sArticle.sConfigurator[1]}
                    </div>
                        {include file='frontend/detail/components/radio_input.tpl' config=$sArticle.sConfigurator[2]}
                </div>
            </div>

            {if $sArticle.sConfigurator[3].customer_selected eq 9 or !$sArticle.sConfigurator[3].customer_selected}{$apcDisabledSelected = true}{/if}

            <div class='lightbox--tab is--disabled' data-selection='1' {if !$apcDisabledSelected}data-needcolor="true"{/if}>
                <div class='lightbox--title'><span>{s name='lightbox_Profilfarbe'}Profilfarbe{/s}</span><i class='icon--check'></i></div>
                <div class='lightbox--content'>
                    {include file='frontend/detail/components/radio_input.tpl' config=$sArticle.sConfigurator[3]}
                    <div name='lightbox_color' {if $apcDisabledSelected}class='is--hidden'{/if}>
                        {include file='frontend/detail/components/select_input.tpl' config=$sArticle.sConfigurator[4] isNiceselect=true selectDisabled=$apcDisabledSelected}
                        {$isNiceselect = false}
                    </div>
                </div>
            </div>
            <div class='lightbox--tab is--disabled' data-selection='2'>
                <div class='lightbox--title'><span>{s name='lightbox_beleuchtung'}Beleuchtung{/s}</span><i class='icon--check'></i></div>
                <div class='lightbox--content'>
                    {include file='frontend/detail/components/radio_input.tpl' config=$sArticle.sConfigurator[5]}
                    {include file='frontend/detail/components/radio_input.tpl' config=$sArticle.sConfigurator[6]}
                </div>
            </div>
            {if $sArticle.sConfigurator[7].customer_selected eq 20}{$apcDisplayImage = true}{/if}

            <div class='lightbox--tab is--disabled' data-selection='1' {if $apcDisplayImage}data-needimage='true'{/if}>
                <div class='lightbox--title'><span>{s name='lightbox_druck'}Spanntuch/Druck{/s}</span><i class='icon--check'></i></div>
                <div class='lightbox--content'>
                    {include file='frontend/detail/components/radio_input.tpl' config=$sArticle.sConfigurator[7]}
                    <div {if !$apcDisplayImage}class='is--hidden' {$sArticle.custom_media_id=false}{$sArticle.custom_media=false} {/if}>
                        <p><strong>{s name='lightbox_image_title'}Dateiupload{/s}</strong></p>
                        <input type="file" name="upload_image" id="upload_image" accept="image/*" />
                        <div class='image--upload'>
                            <div id="uploaded_image">
                                {if $sArticle.custom_media}<img src="{media path=$sArticle.custom_media}">{/if}
                            </div>
                            <div id="uploadimageModal" class="modal is--hidden" role="dialog">
                                <div class="modal-dialog">
                                     <div class="modal-content">
                                     <div class="modal-body">
                                          <div class="row">
                                              <div class="col-md-8 text-center">
                                                  <div id="image_demo" style="width:350px; margin-top:30px"></div>
                                              </div>
                                              <div class="col-md-4" style="padding-top:30px;">
                                                  <span class="btn btn-success crop_image">Crop & Upload Image</span>
                                              </div>
                                          </div>
                                        </div>
                                     </div>
                                </div>
                            </div>
                        </div>
                        <input class='media_buy' type='hidden' name='lightbox_media' value="{if $sArticle.custom_media_id}{$sArticle.custom_media_id}{else}-10{/if}">
                        <p>{s name='lightbox_image_text'}Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer blandit pulvinar dapibus. Donec in mauris egestas, rhoncus urna id, placerat ligula. Aliquam viverra aliquam magna non faucibus. Ut egestas rutrum felis, sed ornare urna maximus a. Vestibulum vehicula maximus erat, quis mollis risus tristique{/s}</p>
                    </div>
                </div>
            </div>
            <div class='lightbox--tab is--disabled' data-selection='1' data-last='true'>
                <div class='lightbox--title'><span>{s name='lighbox_verpackung'}Verpackung & Montage{/s}</span><i class='icon--check'></i></div>
                <div class='lightbox--content'>
                    {include file='frontend/detail/components/radio_input.tpl' config=$sArticle.sConfigurator[8]}
                </div>
            </div>
        </div>
    {else}
    {foreach $sArticle.sConfigurator as $sConfigurator}

        {* Group name *}
        {block name='frontend_detail_group_name'}
            <p class="configurator--label">{$sConfigurator.groupname}:</p>
        {/block}

        {* Group description *}
        {if $sConfigurator.groupdescription}
            {block name='frontend_detail_group_description'}
                <p class="configurator--description">{$sConfigurator.groupdescription}</p>
            {/block}
        {/if}

        {* Configurator drop down *}
        {block name='frontend_detail_group_selection'}
            <div class="select-field">
                <select name="group[{$sConfigurator.groupID}]"{if $theme.ajaxVariantSwitch} data-ajax-select-variants="true"{else} data-auto-submit="true"{/if}>
                    {foreach $sConfigurator.values as $configValue}
                        {if !{config name=hideNoInstock} || ({config name=hideNoInstock} && $configValue.selectable)}
                            <option{if $configValue.selected} selected="selected"{/if} value="{$configValue.optionID}">
                                {$configValue.optionname}{if $configValue.upprice} {if $configValue.upprice > 0}{/if}{/if}
                            </option>
                        {/if}
                    {/foreach}
                </select>
            </div>

        {/block}
    {/foreach}

    {/if}
    {block name='frontend_detail_configurator_noscript_action'}
        <noscript>
            <input name="recalc" type="submit" value="{s name='DetailConfigActionSubmit'}{/s}" />
        </noscript>
    {/block}
</form>
