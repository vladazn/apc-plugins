;(function ($,window,document) {

    var order = {


        smsCheckBox: '#smsConfirm',
        smsPhoneText: '#smsPhone',

        init: function() {
            var me = this;
            $(me.smsCheckBox).change(function() {
                if($(this).is(':checked')){
                    $(me.smsPhoneText).show();
                    $(me.smsPhoneText).find('input').attr('required','required');
                }else{
                    $(me.smsPhoneText).hide();
                    $(me.smsPhoneText).find('input').removeAttr('required');
                }
            });
        },
    }

     $(document).ready(function(){
        var body = $('body');

        if (body.hasClass('is--act-confirm')) {
            order.init();
        }

    });



})($,window,document);
