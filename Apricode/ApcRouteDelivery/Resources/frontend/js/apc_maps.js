;(function ($,window,document) {

    var apcMaps = {

        init: function() {
            var me = this;
            me.registerEvents();
        },

        registerEvents: function(){
            var me = this;

            $('.apc--showmap').click(function(){
                me.toggleMap($(this).closest('tr').next('tr'))
            });
        },

        toggleMap: function(mapTr){
            var me = this;

            if(mapTr.hasClass('is--hidden')){
                mapTr.removeClass('is--hidden');
            }else{
                mapTr.addClass('is--hidden');
            }
        }
    }

    $(document).ready(function(){
         apcMaps.init();
    });

})($,window,document);
