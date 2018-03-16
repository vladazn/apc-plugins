;(function($, window) {
    
    var gcVideo = {
        init: function(){
            var me = this;
              me.subscribeEvent();
        },
        
        subscribeEvent: function() {
            var me = this;
            if($('body').hasClass('is--ctl-custom')){
                me.videoModalInit();
                me.onVideoClose();
                me.onBodyClick();
            }
            $.subscribe('plugin/swEmotionLoader/onLoadEmotionFinished' , function() {
                me.videoModalInit();
                me.onVideoClose();
                me.onBodyClick();
            });
        },
        
        onBodyClick: function() {
            var me = this;
            $('.video-gallery--modal.visible').click(function(e){
                e.preventDefault();
                e.stopPropagation();
            });
            $('body').click(function(){
                $(this).find('.video-gallery--modal').hide(400,function(){$(this).find('iframe').remove()});
                $('body').removeClass('no-scroll');
            });
        },
        
        onVideoClose: function() {
            var me = this;
            $('.emotion--video-closer').click(function(e){
                e.preventDefault();
                e.stopPropagation();
                $(this).parent('.content').parent('.video-gallery--modal').hide(400,function(){$(this).find('iframe').remove()});
                $('body').removeClass('no-scroll');
            });
        },
        
        videoModalInit: function() {
            var me = this;
            $('.emotion--video-element').unbind('click').click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                var link = $(this).attr('data--video-link');
                $(this).siblings('.video-gallery--modal').show();
                $(this).siblings('.video-gallery--modal').find('.content').append("<iframe class=video src='"+link+"' allowfullscreen=1 frameborder=0></iframe>");
                $('body').addClass('no-scroll');
                
            });
        }
    };
    
$(document).ready(function(){
    gcVideo.init();
});    
    
})(jQuery, window);