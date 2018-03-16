{block name="widgets_emotion_components_GcNewsletter_widget"}   
    <div class="gc-newsletter-element"
          data-coverImage="true"
          style="background-image:url({$Data.newsletterImage}); background-position: center; background-size: cover ; background-repeat: no-repeat">
         <div class="gc-newsletter-content">
             <div class="gc-newsletter-content-inner">
                 {if $Data.newsletterHeadline}
                  <h2 class='gc-headline'>{$Data.newsletterHeadline}</h2>
                 {/if}
                 <div class="emotion-form-box">
                     <form class="emotion--newsletter-form newsletter--form" action="{url controller='newsletter'}" method="post">
                        <input type="hidden" value="1" name="subscribeToNewsletter" />
                        <input type="email" name="newsletter" class="gc-newsletter--field" placeholder="{s name="EmotionNewsletterValue"}E-Mail Adresse{/s}" />
                        <i class="icon--mail"></i> 
                        <button type="submit" class="gc-newsletter--button">
                            {$Data.newsletterBtnText}
                        </button>
                        
                         {if $Data.newsletterSubtext}
                          <p class="gc-subheadline">{$Data.newsletterSubtext}</p>
                         {/if}
                     </form>
                  </div>
             </div>
         </div>
     </div>
{/block}