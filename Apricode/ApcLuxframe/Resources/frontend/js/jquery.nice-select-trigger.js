;(function ($, window) {
    'use strict';

    $.plugin('apcNiceSelect', {

        defaults: {

        },

        init: function() {
            var me = this;


            me.$el.niceSelect();
        },

    });

    $.subscribe('plugin/swAjaxVariant/onRequestData',function(){
        window.StateManager.addPlugin('*[data-nice-select="true"]', 'apcNiceSelect');
    })
    window.StateManager.addPlugin('*[data-nice-select="true"]', 'apcNiceSelect');

})(jQuery, window);
