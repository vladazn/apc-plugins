{extends file="parent:backend/_base/layout.tpl"}

{block name="content/main"}
    <div class="container-fluid">
        <form action="" method="post">
            <div class="table-responsive">
                <table id="tablePagination" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>{s name="TicketNoLabel" namespace="backend/infx_ticket_manager/module"}{/s}</th>
                            <th>{s name="OrderDetialIdLabel" namespace="backend/infx_ticket_manager/module"}{/s}</th>
                            <th>{s name="OrderNumberLabel" namespace="backend/infx_ticket_manager/module"}{/s}</th>
                            <th>{s name="OrderTimeLabel" namespace="backend/infx_ticket_manager/module"}{/s}</th>
                            <th>{s name="ArticleOrderNumberLabel" namespace="backend/infx_ticket_manager/module"}{/s}</th>
                            <th>{s name="CustomerNumberLabel" namespace="backend/infx_ticket_manager/module"}{/s}</th>
                            <th>{s name="AmountCounterLabel" namespace="backend/infx_ticket_manager/module"}{/s}</th>
                            <th>{s name="PaymentStatusLabel" namespace="backend/infx_ticket_manager/module"}{/s}</th>
                            <th>{s name="StampTimeLabel" namespace="backend/infx_ticket_manager/module"}{/s}</th>
                            <th>{s name="ActionsLabel" namespace="backend/infx_ticket_manager/module"}{/s}</th>
                        </tr>
                    </thead>
                    <tbody>
                    {foreach $tickets as $ticket}
                        <tr>
                            <td>{$ticket.ticketCode}</td> 
                            <td>{$ticket.orderDetailId}</td>
                            <td>{$ticket.ordernumber}</td>
                            <td>{$ticket.orderTime}</td>
                            <td>{$ticket.articleordernumber}</td>
                            <td>{$ticket.customer_number}</td>    
                            <td>{$ticket.amountCounter}</td>   
                            <td>{$ticket.statusEng} / {$ticket.statusGerm}</td>                 
                           
                            <td class="date-col">{$ticket.stampTime}</td>
                           
                            <td>
                            
                            <a class="btn" target="_blank" href="{url controller='InfxTicketManager' action='showPdf' ticketID=$ticket.id}" data-toggle="tooltip" data-placement="top" title="{s name="ShowPdfLabel" namespace="backend/infx_ticket_manager/module"}Show PDF{/s}"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
                            
                            <a class="resend_ticket_email_manually btn" data-url="{url controller='InfxTicketManager' action='resendEmail' ticketID=$ticket.id customerNumber=$ticket.customer_number}" data-toggle="tooltip" data-placement="top" title="{s name="ResendPdfLabel" namespace="backend/infx_ticket_manager/module"}Resend PDF{/s}"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></a>
                            
                            </td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
            </div>
        </form>
    </div>
  
    
    <div id="SuccessModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <div class="modal-content">
          <div class="modal-header alert alert-success">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">{s name="CloseModalLabel" namespace="backend/infx_ticket_manager/module"}{/s}</button>
          </div>
        </div>

      </div>
    </div>
    
    <div id="FailureModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <div class="modal-content">
          <div class="modal-header alert alert-danger">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">{s name="CloseModalLabel" namespace="backend/infx_ticket_manager/module"}{/s}</button>
          </div>
        </div>

      </div>
    </div>
    
    <div class="snippets" style="display:none">
        <p id="showingLabelId" data-text='{s name="showingLabel" namespace="backend/infx_ticket_manager/module"}Showing{/s}'></p>
        <p id="entriesLabelId" data-text='{s name="entriesLabel" namespace="backend/infx_ticket_manager/module"}entries{/s}'></p>
        <p id="searchLabelId" data-text='{s name="searchLabel" namespace="backend/infx_ticket_manager/module"}Search{/s}'></p>
        <p id="previousLabel" data-text='{s name="previousLabel" namespace="backend/infx_ticket_manager/module"}Previous{/s}'></p>
        <p id="nextLabel" data-text='{s name="nextLabel" namespace="backend/infx_ticket_manager/module"}next{/s}'></p>
        <p id="firstLabel" data-text='{s name="firstLabel" namespace="backend/infx_ticket_manager/module"}first{/s}'></p>
        <p id="lastLabel" data-text='{s name="lastLabel" namespace="backend/infx_ticket_manager/module"}last{/s}'></p>
        <p id="sSortAscendingLabelId" data-text='{s name="sSortAscendingLabel" namespace="backend/infx_ticket_manager/module"}activate to sort column ascending{/s}'></p>
        <p id="sSortDescendingLabelId" data-text='{s name="sSortDescendingLabel" namespace="backend/infx_ticket_manager/module"}activate to sort column descending{/s}'></p>
        <p id="sEmptyTableLabelId" data-text='{s name="sEmptyTableLabel" namespace="backend/infx_ticket_manager/module"}No data available in table{/s}'></p>
        <p id="toLabelId" data-text='{s name="toLabel" namespace="backend/infx_ticket_manager/module"}to{/s}'></p>
        <p id="ofLabelId" data-text='{s name="ofLabel" namespace="backend/infx_ticket_manager/module"}of{/s}'></p>
        <p id="sInfoFilteredLabelid" data-text='{s name="sInfoFilteredLabel" namespace="backend/infx_ticket_manager/module"}filtered{/s}'></p>
        <p id="sLoadingRecordsLabelId" data-text='{s name="sLoadingRecordsLabel" namespace="backend/infx_ticket_manager/module"}Loading{/s}'></p>
        <p id="sProcessingLabelId" data-text='{s name="sProcessingLabel" namespace="backend/infx_ticket_manager/module"}Processing{/s}'></p>
        <p id="sZeroRecordsLabelId" data-text='{s name="sZeroRecordsLabel" namespace="backend/infx_ticket_manager/module"}No matching records found{/s}'></p>
    </div> 
    
{/block}