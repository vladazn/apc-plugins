;(function ($,window,document) {

    var order = {


        pauseOrderButton: '.pauseOrder',
        pauseDuration: 'select.pauseDuration',

        init: function() {
            var me = this;
            $(me.pauseOrderButton).click(function() {
                  var duration = $(this).parent().find(me.pauseDuration).val();
                  var detailId = $(this).data('detail');
                  var url = $(this).data('ctrl-path');

                  var html = me.pauseSubscription(duration,detailId,url,$(this).parent());

            });
        },

        pauseSubscription: function(duration, detail, url, parent){
            $.loadingIndicator.open();
            $.ajax({
                type: 'POST',
                data: {
                    select: duration,
                    detailId: detail
                },
                url: url,
                success: function(html) {
                    parent.html(html);
                    $.loadingIndicator.close();
                },
                failure: function() {
                    alert('an error occured');
                }
           });


       },

    }

     $(document).ready(function(){
        var body = $('body');

        if (body.hasClass('is--act-orders')) {
            order.init();
        }

    });



})($,window,document);
