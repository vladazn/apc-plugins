 <div class="panel--tr">
         <div class="download--name download--button-content panel--td column--info">
             {foreach $downloads as $download}
             <a href="{$download.link}" title="{"{$download.text}"|escape} {$articleName|escape}" class="btn is--primary is--small">
                 {$download.text}
             </a>
             {/foreach}
         </div>
 </div>
