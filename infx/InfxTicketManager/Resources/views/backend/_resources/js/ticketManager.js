;(function ($,window,document) {
    
    var ticket = {
        
     
        resendBtnSelector: '.resend_ticket_email_manually',
        customerNumberSelector: '.open_backend_customer_panel',
        dateInputsSelector: ".date_input",
        successPopUp: '#SuccessModal',
        failurePopUp: '#FailureModal',
        
        init: function() {
            var me = this;
            
            $('#tablePagination')
            .on( 'order.dt',  function () { me.subscribeEvents(); } )
            .on( 'search.dt', function () { me.subscribeEvents(); } )
            .on( 'page.dt',   function () { me.subscribeEvents(); } )
            .DataTable();
            
            me.subscribeEvents();
 
        },
        
        handleSnippets: function() {
            var me = this;
            setTimeout(function(){
                 $('.snippets p').each(function(){
                    var id = $(this).attr('id');
                    var snippet = $(this).data('text');
                    if($('.'+id).length == 1) {
                        $('.'+id).text(snippet);
                    } else {
                        if($('.'+id).length > 1) {
                            $('.'+id).each(function(){
                                $(this).text(snippet);
                            });
                        } 
                    }
                });
            },300);
            
        },
        
        subscribeEvents: function() {
            var me = this;
            me.unBindAll();
            me.onResendEmail();     
            me.onDateInputChange();
            me.handleSnippets();
            $('[data-toggle="tooltip"]').tooltip();
        },
        
        unBindAll: function() {
            var me = this;
            $(me.resendBtnSelector).unbind('click');
            $(me.dateInputsSelector).unbind('change');
            $(me.pluginActions).unbind('hover');
        },
        

        onResendEmail: function () {
            var me = this;
            
            $(me.resendBtnSelector).click(function() {
                var url = $(this).data('url');
                me.callAjax(url);
            });
        },
        
        onDateInputChange: function() {
            var me = this;
           
            $(me.dateInputsSelector).change(function() {
                console.log(13);
                var url = $(this).data('url');
                var date =  $(this).val() + ' ' + $(this).siblings('input').val();
                url += '?newDate=' + date;
                me.callAjax(url);
            });
           
        },
        
        callAjax: function(url) {
            var me = this;
            $.ajax({
                'type': 'post',
                'url': url,
                'success': function(response) {
                    
                    if(response.success == 'true') {
                        
                      $(me.successPopUp).find('.modal-title').text(response.message);
                      $(me.successPopUp).modal('show');
                    } else {
                      $(me.failurePopUp).find('.modal-title').text(response.message);
                      $(me.failurePopUp).modal('show');
                    }
                }
            });
        }
         
    };
    
    
    $(document).ready(function(){
        ticket.init();
    });
    
})($,window,document);

