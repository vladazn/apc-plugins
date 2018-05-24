;(function ($,window,document) {

    var filter = {

        bodyCls: 'is--ctl-listing',
        tastySelector: '#is--tasty',

        init: function() {
            var me = this;
            me.registerEvents();
            $(me.tastySelector).trigger( "click" );
        },

        registerEvents: function() {
            var me = this;

            $.subscribe('plugin/swFilterComponent/onChange', function(e, plugin, event){
                me.uncheck(event);
            });

        },

        uncheck: function(e){
            var me = this;
            var target = $(e.currentTarget);
            $('.apc-filter-options input').prop('checked', false).siblings('span').removeAttr('style');
            target.trigger('click');
            target.siblings('span').css('color','#009548');
        },

    };


    $(document).ready(function(){
        if($('body').hasClass(filter.bodyCls)) {
            filter.init();
        }
    });

})($,window,document);
