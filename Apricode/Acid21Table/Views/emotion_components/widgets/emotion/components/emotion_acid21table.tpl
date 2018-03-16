{block name="widgets_emotion_components_Acid21Table_element"}
    <div class="table-container-content acid21ScrollableTable-emotion">            
       <ul class="table-element table" data-fixed-first-column="true">
           {foreach $Data as $row name="acidTable"}
              {if !is_array($row)} {continue} {/if}
               <li>
                   {foreach $row as $one name="acidTableRow"}
                       <div class="table-column 
                           {if $smarty.foreach.acidTable.index==0}headline {if $smarty.foreach.acidTableRow.index==0}fixed-part{/if} {if $smarty.foreach.acidTableRow.index==1}first-child{/if}{else}content-cell{/if} {if $smarty.foreach.acidTableRow.index==0}fixed-cell{/if}">
                           {if $smarty.foreach.acidTableRow.index==0}
                               <p>{$one}</p>
                           {else}
                               {$one}
                           {/if}
                       </div>
                   {/foreach}
               </li>
           {/foreach}
       </ul>
    </div>
{/block}

