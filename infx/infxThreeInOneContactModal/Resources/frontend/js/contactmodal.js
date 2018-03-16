;(function($, window, document) {

    var infoContainerEvent = {

        minInfoTab: ".min-help-info",
        largeInfoTab: ".help-info-container",
        closeBtn: ".icon--cross3",
        chatStatusText: ".infx--chat-status",

        init: function(){
            var me = this;

            me.changeInfoTabEvent();
            me.chat();
        },

        changeInfoTabEvent: function(){
            var me = this;
            $(me.minInfoTab).click(function(){
                $(this).addClass("is--hidden");
                $(me.largeInfoTab).removeClass("is--hidden");
            });
            $(me.closeBtn).click(function() {
                $(me.largeInfoTab).addClass("is--hidden");
                $(me.minInfoTab).removeClass("is--hidden");
            });
        },
        chat: function(){

        }
    };



    $(document).ready(function() {
        infoContainerEvent.init();
    });


})(jQuery, window, document);
