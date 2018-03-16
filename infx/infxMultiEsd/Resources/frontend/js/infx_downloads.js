;(function ($,window,document) {

    var multiDownloads = {

        downloadsButton: '.download--actions .btn',
        downloadsButtonOrder: '.order--download .btn',

        init: function() {
            var me = this;

            me.registerEvents();
        },

        registerEvents: function() {
            var me  = this;

            $(me.downloadsButton + ',' + me.downloadsButtonOrder).click(function(e) {
                e.preventDefault();
                var esdLink = $(this).data('esdLink');

                me.sendAjax(window.infxModalAction,{
                    esdLink: $(this).attr('href')
                },'downloadsCallback');

            });

        },

        downloadsCallback: function(response) {
            var me = this;

            $.modal.open(response.data, {
                title: response.title,
                animationSpeed: 350,
                sizing: 'content',
                width: 520,
            });

        },

        sendAjax: function(url,data,callback){
            var me = this;
            $.ajax({
                type: 'POST',
                data: data,
                url: url,
                success: function(response) {
                    me[callback](response);
                }
           });
       },

    };

    $(document).ready(function(){
        var body = $('body');
        if(body.hasClass('is--act-downloads') || body.hasClass('is--act-orders')) {
            multiDownloads.init();
        }
    });

})($,window,document);
