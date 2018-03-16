;(function($, window) {
   
    var noteAdvanced = {
        
        navEntryNote: '.shop--navigation .entry--notepad .btn',
        noteOffcanvasPanelSelector: '.container--ajax-note',
        loadingIconWrapperClass: 'ajax--note',
        loadingIconClass: 'icon--loading-indicator',
        removeFormSelector: '.container--ajax-note form',
        
        init: function() {
            var me = this;
            
            me._$loadingIcon = $('<i>', {
                'class': me.loadingIconClass
            });
            
            me.initNoteSidebar();
            me.subscribeEvents();
        },
        
        subscribeEvents: function() {
            var me = this;
            $.subscribe('plugin/swOffcanvasMenu/onOpenMenu', function(e,plugin){
                if(plugin.opts.offCanvasSelector != me.noteOffcanvasPanelSelector) {
                    return;
                }
                me.loadNote();
            });
        },
        
        loadNote: function() {
            var me = this;
            me.showLoadingIndicator();
            me.callAjax();
        },
        
        bindEvents: function() {
            var me = this;
            
            $(me.removeFormSelector).submit(function(e){
                e.preventDefault();
                var url = $(this).attr('action');
                $.ajax({
                    url: url,
                    success: function (result) {
                        me.loadNote();
                    }
                });
            });
            
        },
        
        callAjax: function(){
            var me = this;
            $.ajax({
                url: window.controller['ajax_note'],
                success: function (result) {
                    $(me.noteOffcanvasPanelSelector).html(result);
                    me.bindEvents();
                }
            });
        },
        
        initNoteSidebar: function() {
            var me = this;
            window.StateManager.addPlugin(me.navEntryNote, 'swOffcanvasMenu', {
                offCanvasSelector: me.noteOffcanvasPanelSelector,
                direction: direction,
            });
        },
        
        /**
         * Overrides the elements content with the configured loading indicator.
         *
         * @public
         * @method showLoadingIndicator
         */
        showLoadingIndicator: function () {
            var me = this;
            $(me.noteOffcanvasPanelSelector).html($('<div>', {
                'class': me.loadingIconWrapperClass,
                'html': me._$loadingIcon.clone()
            }));
        },
        
        
    };
    
    $(document).ready(function(){
        if($(noteAdvanced.navEntryNote).length) {
            noteAdvanced.init();    
        }
    });
    
})(jQuery, window);
