{if $timeleft}
    <div class="apc--reserve-timer" 
         data-apc-article-reserve-timer="true" 
         data-isReservedBySessionUser="{$isReservedBySessionUser nocache}" 
         data-timeLeft='{$timeleft nocache}'>
        <div class='panel has--border'>
            <div class='panel--body is--flat'>
                <span class='apc--timer-text'>{s namespace='frontend/detail/data' name='apcTimerText'}Article is reserved:{/s}</span>
                <span class='apc--timer-time'></span>
            </div>
        </div>    
    </div>
{/if}