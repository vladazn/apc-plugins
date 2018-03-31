;(function ($,window,document) {
    
    var voucher = {
        
        removeCodeBtn: '.infx_voucher_code_delete',
        removeVoucherBtn: '.infx_voucher_remove',
        codeBalanceEditBtn: '.infx_code_balance_edit',
        successPopUp: '#SuccessModal',
        failurePopUp: '#FailureModal',
        codeBalanceEditModal: '#codeBalanceEditModal',
        codeBalanceEditInput: '#codeBalanceEditInput',
        codeBalanceSubmitBtn: '#submitCodeBalanceEdit',
        
        init: function() {
            var me = this;
            
            $('#tablePagination')
            .on( 'order.dt',  function () {   me.subscribeEvents();   } )
            .on( 'search.dt', function () {   me.subscribeEvents();   } )
            .on( 'page.dt',   function () {   me.subscribeEvents();   } )
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
            me.onRemoveCode();     
            me.onRemoveVoucher();     
            me.onCodeBalanceEdit();     
            me.onSubmitCodeEditModal();        
            me.handleSnippets();
            $('[data-toggle="tooltip"]').tooltip();
        },
        
        unBindAll: function() {
            var me = this;
            $(me.removeCodeBtn).unbind('click');
            $(me.removeVoucherBtn).unbind('click');
            $(me.codeBalanceSubmitBtn).unbind('click');
            $(me.codeBalanceEditBtn).unbind('click');
            $(me.pluginActions).unbind('hover');
        },
         
        onCodeBalanceEdit: function () {
            var me = this;
            
            $(me.codeBalanceEditBtn).click(function(){
                
                me.$codeEl = $(this);
                var currentBalance = $(this).data('code-balance');
                var codeID = $(this).data('code-id');
                $(me.codeBalanceEditModal).find(me.codeBalanceEditInput).val(currentBalance);
                $(me.codeBalanceEditModal).attr('data-code-id',codeID);
                $(me.codeBalanceEditModal).modal('show');
                
            });
            
        },
        
        onSubmitCodeEditModal: function() {
            var me = this;
            
            $(me.codeBalanceSubmitBtn).click(function(){
                var codeID = $(me.codeBalanceEditModal).data('code-id');
                var balance = $(me.codeBalanceEditInput).val();

                me.callCodeBalanceEditAjax(codeID,balance);
                
            });
            
        },
        
        callCodeBalanceEditAjax: function(codeID,balance) {
            var me = this;
            
            var url = $(me.codeBalanceEditModal).data('url');
            
              $.ajax({
                'type': 'post',
                'data': {codeID:codeID, newBalance: balance},
                'url': url,
                'success': function(response) {
                    $(me.codeBalanceEditModal).modal('hide');
                    if(response.success == 'true') {
                        me.$codeEl.data('code-balance',response.balance);
                        me.$codeEl.find('.code-balance').text(response.balance);
                        $(me.successPopUp).find('.modal-title').text(response.message);
                        $(me.successPopUp).modal('show');
                    } else {
                        $(me.failurePopUp).find('.modal-title').text(response.message);
                        $(me.failurePopUp).modal('show');
                    }
                }
            });
            
        },
        
        onRemoveCode: function() {
            var me = this;
           
            $(me.removeCodeBtn).click(function() {
                if(confirm($(this).data('confirm-text'))) {
                    var url = $(this).data('url');
                    var codeID = $(this).data('code');
                    me.$el = $(this);
                    me.callAjax(url,codeID);
                } 
                
            });
           
        },
        
        onRemoveVoucher: function() {
            var me = this;
            $(me.removeVoucherBtn).click(function() {
                if(confirm($(this).data('confirm-text'))) {
                    var url = $(this).data('url');
                    var voucherID = $(this).data('voucher');
                    me.$el = $(this);
                    me.callAjax(url,voucherID);
                } 
            });
        },
        
        callAjax: function(url,codeID) {
            var me = this;
            
            $.ajax({
                'type': 'post',
                'data': {codeID:codeID},
                'url': url,
                'success': function(response) {
                    if(response.success == 'true') {
                        me.$el.slideUp(400,function(){
                            me.$el.parents('tr').remove();
                        });      
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
        voucher.init();
    });
    
})($,window,document);

