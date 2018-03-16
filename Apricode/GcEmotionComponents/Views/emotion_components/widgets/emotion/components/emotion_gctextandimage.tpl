{block name="widgets_emotion_components_GcTextAndImageElement_element"}

    <div class="gc-text-and-image-element">
         <div class="gc--content">
              <div class='gc-img-box'>
                 <div class="gc-img-block">
                          <div class="gc-text-box" data-href="{$link}">
                           <div class="gc-text-box-container-outer">
                               <div class="gc-text-box-container">
                               <a href="{$Data.gcTextAndImageLink}" class="text_link"></a>
                              {if $Data.gcTextAndImageTitle}
                                  <h3 class="gc-text-headline">
                                      {$Data.gcTextAndImageTitle}
                                  </h3>
                              {/if}
                              {if $Data.gcTextAndImageText}
                              <p class="gc-text">
                                  {$Data.gcTextAndImageText}
                              </p>
                              {/if}
                            </div>
                           </div>
                          </div>
                     <img src="{$Data.gcTextAndImageImage}" alt="" />
                 </div>
              </div>
         </div>
    </div>
    
{/block}