{block name="widgets_emotion_components_GcVideoModule_element"}
   
   <div class="gc-video-module {if !$Data.videoText && !$Data.videoBtnText}gc-full-video-container{/if}">
       <div class="emotion--video-element gc-video-element image--element {if !$Data.videoText && !$Data.videoBtnText}gc-full-video{/if}"  data--video-link="{$Data.videoLink}">
          {if !$Data.videoText && !$Data.videoBtnText}
           {if $Data.videoImage}
            <span class="image-media" {if $Data.videoImage}data-video-img="true"{/if}
                  style="background-image:url({$Data.videoImage}); background-position: center; background-size: cover ; background-repeat: no-repeat">
            </span>
           {else}
            <span class="image-media" {if $Data.videoImage}data-video-img="true"{/if}>
               <img src="{link file="frontend/_public/src/img/icons/video.png"}" itemprop=video/>
            </span>
           {/if}
          {else}
              <span class="image-media" {if $Data.videoImage}data-video-img="true"{/if}>
                  {if $Data.videoImage}
                   <img src="{$Data.videoImage}" itemprop=video>
                  {else}
                   <img src="{link file="frontend/_public/src/img/icons/video.png"}" itemprop=video/>
                  {/if}
           </span>
          {/if}
       </div> 
        
       {if $Data.videoText}
           <p class="video--text">{$Data.videoText}</p>
       {/if}
       
       {if $Data.videoBtnText}
           <a class="gc-link" href="{$Data.videoBtnLink}" title="{$Data.videoBtnText|escape}" >
                 {$Data.videoBtnText}
           </a>
       {/if}
       <div class="js--modal sizing--auto no--header video-gallery--modal no--border-radius">
           <div class="content">
                <div class="btn icon--cross is--small btn--grey emotion--video-closer modal--close"></div>
           </div>
       </div>
   </div>
   
{/block}


