;(function ($,window,document) {

    var apcRegister = {

        init: function() {
            var me = this;
            me.registerEvents();
        },

        registerEvents: function(){
            var me = this;

            $('.register--field-zipcode').blur(function(){
                me.callAjax('/widgets/Apc/checkZip',{zip:$(this).val()},'zipCheckCallback');
            });
        },

        zipCheckCallback: function(response){
            var me = this;
            response = jQuery.parseJSON(response);
            if(response.success == 'true'){
                $('.register--submit').removeAttr('disabled');
                $('.zip--error').empty();
            }else{
                $('.register--submit').attr('disabled','disabled');
                $('.zip--error').text('Wir beliefern Ihre Postleitzahl leider nicht! Wir fahren nur persönlich unsere sensible Ware im Kreis Stuttgart und Esslingen aus.');
            }
        },

        callAjax: function(url,data,callback) {
            var me = this;

            $.ajax({
                method: 'POST',
                url: url,
                data: data,
                success: function(response) {
                    me[callback](response);
                },
            });
        }
    }

    $(document).ready(function(){
         apcRegister.init();
    });

})($,window,document);
