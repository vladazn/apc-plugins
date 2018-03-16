{block name="widgets_emotion_components_GcTextElement_element"}
    <div class="gc-emotion-element-style gc-text-element {if !$Data.gc_text_element_text && !$Data.gc_text_element_button_text}gc-headline-element{/if}" 
         {if $Data.gc_text_element_background_color}
               style="background-color: {$Data.gc_text_element_background_color}
                {if $Data.gradient_background_color}
                    background-image: -webkit-linear-gradient({$Data.gc_text_element_background_color} 0%, {$Data.gc_text_element_gradient_background_color} 100%);
                    background-image: -moz-linear-gradient({$Data.gc_text_element_background_color} 0%, {$Data.gc_text_element_gradient_background_color} 100%);
                    background-image: -ms-linear-gradient({$Data.gc_text_element_background_color} 0%, {$Data.gc_text_element_gradient_background_color} 100%);
                    background-image: -o-linear-gradient({$Data.gc_text_element_background_color} 0%, {$Data.gc_text_element_gradient_background_color} 100%);
                    background-image: linear-gradient({$Data.gc_text_element_background_color} 0%, {$Data.gc_text_element_gradient_background_color} 100%);
                {/if} 
         "{/if}>
         <div class="gc-text-element-content">
             <div class="gc-text-element-content-inner">
                 {if $Data.gc_text_element_title}
                  <h2 class='gc-headline'>{$Data.gc_text_element_title|upper}</h2>
                 {/if}
                 {if $Data.gc_text_element_text}
                  <p class="gc-subheadline">{$Data.gc_text_element_text}</p>
                 {/if}
                 {if $Data.gc_text_element_button_text}
                  <a class="gc-link" href="{$Data.gc_text_element_button_target}" title="{$Data.gc_text_element_button_text|escape}">
                     {$Data.gc_text_element_button_text|escape:'html'}
                  </a>
                 {/if}
             </div>
         </div>
      </div>
{/block}