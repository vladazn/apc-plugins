{block name="widgets_emotion_components_GcPartnerElement_element"}
    <div class="gc-partner-element">
         <div class="gc-partner-content">
              <div class='gc-partner-img-box'>
                  <img src="{$Data.partnerImage}" />
              </div>
            
              <p class="gc-partner-info">{$Data.partnerText|truncate:80}</p>

              <a class="gc-partner-link" href="{$Data.partnerLink}">
                  Link zum Partner <i class="icon--arrow-right"></i>
              </a>
         </div>
    </div>
{/block}