{block name="widgets_emotion_components_GcContent_block"}
        {* 97 - german, 93 - english *}
        {if $emotion.id eq 97 || $emotion.id eq 93}
           {if $emotion.id eq 97}
               {$url = 'https://www.justus-brown.de/uhren/'}
           {else}
               {$url = 'https://www.justus-brown.de/en/watches/'}
           {/if}
        {/if}
            <div class="gc-content-block-element" {if $url}data-gc-redirect='true' data-link='{$url}'{/if}>
                 <div class="gc-content-block-content {if $Data.contentBlockStyle}is-full-style{/if}"
                    data-coverImage="true"
                    style="background-image:url({$Data.contentImage}); background-position: center; background-size: cover ; background-repeat: no-repeat">
                     <div class="gc-content-block-content-inner {if $Data.contentBlockStyle}is-full-style{/if}" >
                         {if $Data.contentHeadline}
                          <h2 class='gc-headline'>{$Data.contentHeadline}</h2>
                         {/if}
                         {if $Data.contentText}
                          <p class="gc-subheadline">{$Data.contentText}</p>
                         {/if}
                         {if $Data.btnTarget}
                          <a class="gc-link" href="{$Data.btnTarget}" title="{$Data.contentBtnText|escape}">
                             {$Data.contentBtnText|escape:'html'}
                          </a>
                         {/if}
                     </div>
                 </div>
            </div>
{/block}
 
