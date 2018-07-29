;(function ($,window,document) {

    var stickyHeader = {

        headerSelector: '.header-main',

        init: function() {
            var me = this;
            me.registerEvents();
        },

        registerEvents: function(){
            me = this;
            $(me.headerSelector).sticky({topSpacing:0, zIndex:5001});
        },


    };

    $(document).ready(function(){
        stickyHeader.init();
    });

})($,window,document);
