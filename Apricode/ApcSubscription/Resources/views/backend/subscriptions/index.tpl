{extends file="parent:backend/_base/layout.tpl"}

{block name="content/main"}


    <div class="container-fluid">
        {if $sSuccessMessage}
                <div class="alert alert-success">
                      <strong>{$sSuccessMessage}</strong>
                </div>
        {/if}
        {if $sErrorMessage}
                <div class="alert alert-danger">
                      <strong>{$sErrorMessage}</strong>
                </div>
        {/if}

        <form action="" method="post">
            <div class="table-responsive">
                <table id="tablePagination" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>{s name="orderNumber" namespace="backend/subscription_list/module"}Order Number{/s}</th>
                            <th>{s name="articleName" namespace="backend/subscription_list/module"}Article{/s}</th>
                            <th>{s name="userInfo" namespace="backend/subscription_list/module"}Customer{/s}</th>
                            <th>{s name="customernumber" namespace="backend/subscription_list/module"}Customer Number{/s}</th>
                            <th>{s name="orderCount" namespace="backend/subscription_list/module"} Orders {/s}</th>
                            <th>{s name="next_order_date" namespace="backend/subscription_list/module"}Next Order Date{/s}</th>
                            <th>{s name="status" namespace="backend/subscription_list/module"} Status {/s}</th>
                            <th>{s name="DesiredDeliveryDate" namespace="backend/subscription_list/module"} Desired Delivery Date {/s}</th>
                        </tr>
                    </thead>
                    <tbody>
                    {foreach $subscriptions as $subscription}
                        <tr>
                            <td>{$subscription.orderNumber}</td>
                            <td>{$subscription.articleName}</td>
                            <td>{$subscription.userInfo.firstname} {$subscription.userInfo.lastname}</td>
                            <td>{$subscription.userInfo.customernumber}</td>
                            <td>{$subscription.orderCount}</td>
                            <td>{$subscription.next_order_date}</td>
                            <td>{$subscription.status}</td>
                            <td>{$subscription.desiredDate}</td>

                        </tr>
                    {/foreach}
                    </tbody>
                </table>
            </div>
        </form>
    </div>

  <div id="SuccessModal" style="display:none" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <div class="modal-content">
          <div class="modal-header alert alert-success">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">{s name="CloseModalLabel" namespace="backend/subscription_list/module"}{/s}</button>
          </div>
        </div>

      </div>
    </div>

    <div id="FailureModal" style="display:none" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <div class="modal-content">
          <div class="modal-header alert alert-danger">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">{s name="CloseModalLabel" namespace="backend/subscription_list/module"}{/s}</button>
          </div>
        </div>

      </div>
    </div>

    <div class="snippets" style="display:none">
        <p id="showingLabelId" data-text='{s name="showingLabel" namespace="backend/subscription_list/module"}Showing{/s}'></p>
        <p id="entriesLabelId" data-text='{s name="entriesLabel" namespace="backend/subscription_list/module"}entries{/s}'></p>
        <p id="searchLabelId" data-text='{s name="searchLabel" namespace="backend/subscription_list/module"}Search{/s}'></p>
        <p id="previousLabel" data-text='{s name="previousLabel" namespace="backend/subscription_list/module"}Previous{/s}'></p>
        <p id="nextLabel" data-text='{s name="nextLabel" namespace="backend/subscription_list/module"}next{/s}'></p>
        <p id="firstLabel" data-text='{s name="firstLabel" namespace="backend/subscription_list/module"}first{/s}'></p>
        <p id="lastLabel" data-text='{s name="lastLabel" namespace="backend/subscription_list/module"}last{/s}'></p>
        <p id="sSortAscendingLabelId" data-text='{s name="sSortAscendingLabel" namespace="backend/subscription_list/module"}activate to sort column ascending{/s}'></p>
        <p id="sSortDescendingLabelId" data-text='{s name="sSortDescendingLabel" namespace="backend/subscription_list/module"}activate to sort column descending{/s}'></p>
        <p id="sEmptyTableLabelId" data-text='{s name="sEmptyTableLabel" namespace="backend/subscription_list/module"}No data available in table{/s}'></p>
        <p id="toLabelId" data-text='{s name="toLabel" namespace="backend/subscription_list/module"}to{/s}'></p>
        <p id="ofLabelId" data-text='{s name="ofLabel" namespace="backend/subscription_list/module"}of{/s}'></p>
        <p id="sInfoFilteredLabelid" data-text='{s name="sInfoFilteredLabel" namespace="backend/subscription_list/module"}filtered{/s}'></p>
        <p id="sLoadingRecordsLabelId" data-text='{s name="sLoadingRecordsLabel" namespace="backend/subscription_list/module"}Loading{/s}'></p>
        <p id="sProcessingLabelId" data-text='{s name="sProcessingLabel" namespace="backend/subscription_list/module"}Processing{/s}'></p>
        <p id="sZeroRecordsLabelId" data-text='{s name="sZeroRecordsLabel" namespace="backend/subscription_list/module"}No matching records found{/s}'></p>
    </div>

{/block}
