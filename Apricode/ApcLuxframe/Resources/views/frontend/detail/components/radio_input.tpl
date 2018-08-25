<div class='radio--content'>
    {foreach $config.values as $option}
           {block name='frontend_detail_configurator_variant_group_option'}
               <div class="variant--option{if $option.media} is--image{/if}">

                   {block name='frontend_detail_configurator_variant_group_option_input'}
                       <input type="radio"
                              class="option--input"
                              id="group[{$option.groupID}][{$option.optionID}]"
                              name="group[{$option.groupID}]"
                              value="{$option.optionID}"
                              title="{$option.optionname}"
                              {if $theme.ajaxVariantSwitch}data-ajax-select-variants="true"{else}data-auto-submit="true"{/if}
                              {*}{if !$sArticle.notification && !$option.selectable}disabled="disabled"{/if}{*}
                              {if $preselected}
                                {if $option.selected && ($sArticle.notification || $option.selectable)}checked="checked"{/if}
                              {else}
                                {if $option.optionID eq $config.customer_selected && ($sArticle.notification || $option.selectable)}checked="checked"{/if}
                              {/if}/>

                   {/block}

                   {block name='frontend_detail_configurator_variant_group_option_label'}
                       <label for="group[{$option.groupID}][{$option.optionID}]" class="option--label{if !$sArticle.notification && !$option.selectable} is--disabled{/if}">

                           {if $option.media}
                               {$media = $option.media}

                               {block name='frontend_detail_configurator_variant_group_option_label_image'}
                                   <span class="image--element">
                                       <span class="image--media">
                                           {if isset($media.thumbnails)}
                                               <img srcset="{$media.thumbnails[0].sourceSet}" alt="{$option.optionname}" />
                                           {else}
                                               <img src="{link file='frontend/_public/src/img/no-picture.jpg'}" alt="{$option.optionname}">
                                           {/if}
                                       </span>
                                   </span>
                               {/block}
                           {else}
                               {block name='frontend_detail_configurator_variant_group_option_label_text'}
                                   {$option.optionname}
                               {/block}
                           {/if}
                       </label>
                   {/block}
               </div>
           {/block}
       {/foreach}
</div>
