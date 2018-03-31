
    <div class="order--item panel--tr">
            <div class="order--date panel--td column--date">
                    <div class="column--label">
                        {s name="OrderColumnDate" namespace="frontend/account/orders"}{/s}:
                    </div>
               
                    <div class="column--value">
                        {$subscription.datum|date}
                    </div>
                
            </div>
       

        {* Order id *}
            <div class="order--number panel--td column--id is--bold">
                
                    <div class="column--label">
                        
                    </div>
                
                    <div class="column--value">
                        {$subscription.ordernumber}
                    </div>
            </div>
        

        {* Dispatch type *}
        
            <div class="order--dispatch panel--td column--dispatch">

                
                    <div class="column--label">
                        {s name="OrderColumnDispatch" namespace="frontend/account/orders"}{/s}:
                    </div>
                
                    <div class="column--value">
                        {if $subscription.dispatch.name}
                            {$subscription.dispatch.name}
                        {else}
                            {s name="OrderInfoNoDispatch"}{/s}
                        {/if}
                    </div>
            </div>
        

        {* Order status *}
            <div class="order--status panel--td column--status">
                    <div class="column--label">
                        {s name="OrderColumnStatus" namespace="frontend/account/orders"}{/s}:
                    </div>
                    <div class="column--value">
                        <span class="order--status-icon status--{$subscription.status}">&nbsp;</span>
                        {if $subscription.status==0}
                            {s name="OrderItemInfoNotProcessed"}{/s}
                        {elseif $subscription.status==1}
                            {s name="OrderItemInfoInProgress"}{/s}
                        {elseif $subscription.status==2}
                            {s name="OrderItemInfoCompleted"}{/s}
                        {elseif $subscription.status==3}
                            {s name="OrderItemInfoPartiallyCompleted"}{/s}
                        {elseif $subscription.status==4}
                            {s name="OrderItemInfoCanceled"}{/s}
                        {elseif $subscription.status==5}
                            {s name="OrderItemInfoReadyForShipping"}{/s}
                        {elseif $subscription.status==6}
                            {s name="OrderItemInfoPartiallyShipped"}{/s}
                        {elseif $subscription.status==7}
                            {s name="OrderItemInfoShipped"}{/s}
                        {elseif $subscription.status==8}
                            {s name="OrderItemInfoClarificationNeeded"}{/s}
                        {/if}
                    </div>
            </div>
       
       
    </div>