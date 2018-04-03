<div class='cart--time-left is--hidden'
     data-apc-article-reserve-timer="true"
     data-shouldNotify="true"
     data-removeReservationCtrl="{url module=widgets controller=ApcArticleReserve action=expire}"
     data-timeLeft="{$cartTimeLeft nocache}"
     data-title='{s namespace="frontend/index/index" name="apcModalTitle"}Article removed from basket{/s}'>
     <p>{s namespace="frontend/index/index" name="apcModalText"}The Article has been removed from yout cart, because you did not purchased the article within {config name=apc_reserve_time} minutes.{/s}</p>
     <p>{s namespace="frontend/index/index" name="apcModalNote"}This page will be reloaded once yoou close this pop up.{/s}</p>
</div>
