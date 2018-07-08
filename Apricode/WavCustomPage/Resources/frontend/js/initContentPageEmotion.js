;(function($, window, document) {
    
    var initContentPageEmotion = {
		
        init: function() {
            var me = this;
			
            $('*[data-emotion="true"]').swEmotion(); 
            $(".emotion--container").css('display','block');
        },
		
    };
    
    $(document).ready(function(){
        if($('body').hasClass('is--ctl-custom')) {
            initContentPageEmotion.init();
        }
    });
    
})(jQuery, window, document);