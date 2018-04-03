;(function ($,window,document) {

    $.plugin('apcArticleReserveTimer', {
        
        defaults: {
            
            timeLeft: 0,
            
            shouldNotify: false,
            
            isReservedBySessionUser: false,
            
            timerFieldSelector: '.apc--timer-time',
            
            modalContentSelector: '.cart--time-left',
            
            modalAdditionalClass: 'apc--reserve-expired-modal',
            
            timeTemplate: "<span class=minutes>[[min]]</span> min <span class=seconds>[[sec]]</span> s",
            
            removeReservationCtrl: null,
        },
        
        init: function() {
            var me = this,
                opts = me.opts;
            
            me.applyDataAttributes();
            
            me.$timeField = $(opts.timerFieldSelector);
            
            if(opts.timeLeft > 0 && me.opts.shouldNotify == false) {
                 me.runTimer();
                 window.timerRunning = true;
            }
            
            if(window.timerRunning != true) {
                me.sceduleNotification();
            }
        },
        
        subscribeEvents: function() {
			var me = this;
			
			$.subscribe('plugin/swAjaxVariant/onRequestData', function() {
				me.runTimer();
			});
		},
        
        sceduleNotification: function(){
            var me = this,
                opts = me.opts;

            if(opts.timeLeft == -1){
                me.modalOpen();
            } else if(opts.timeLeft > 0){
                setTimeout(function(){
                    me.sendAjax();
                    $.publish('plugin/swAddArticle/onAddArticle', [me]);
                    me.modalOpen();
                }, (me.opts.timeLeft * 1000));
            }
        },
        
        runTimer: function() {
            var me = this;
			
			var intervalId = setInterval(function() {
				var distance = me.opts.timeLeft,
                    minutes = Math.floor(distance / 60),
				    seconds = Math.floor(distance % 60);
				
				if (distance <= 0) {
					minutes = "00";
					seconds = "00";
				}
				
				var displayedDate = me.opts.timeTemplate.split('[[min]]').join(minutes).split('[[sec]]').join(seconds);
                
				me.$timeField.html(displayedDate);
				
				if(distance <= 0) {
					clearInterval(intervalId);
                    if(me.opts.isReservedBySessionUser == true) {
                        me.sendAjax();
                        $.publish('plugin/swAddArticle/onAddArticle', [me]);
                        me.modalOpen();
                    } else {
                        setTimeout(function() {
                            me.sendAjax(true);
                            $.publish('plugin/swAddArticle/onAddArticle', [me]);
                        }, 1500);
                    }
				}
                
                me.opts.timeLeft--;
			}, 1000);
			
        },

        modalOpen: function() {
			var me = this,
                $modal = $(me.opts.modalContentSelector);
            
            me.sendAjax();
            $.publish('plugin/swAddArticle/onAddArticle', [me]);

			$.modal.open($modal.html(), {
                title: $modal.data('title'),
                animationSpeed: 350,
                sizing: 'content',
                width: 520,
				additionalClass: me.opts.modalAdditionalClass,
				onClose: function() {
                    location.reload();
				}
            });
        },

        sendAjax: function(reload = false) {
            var me = this;
            
            $.ajax({
                method: 'POST',
                url: me.opts.removeReservationCtrl,
                success: function() {
                    if(reload == true) {
                        location.reload();
                    }
                },
            });
        },
        
    });

    window.StateManager.addPlugin('*[data-apc-article-reserve-timer="true"]','apcArticleReserveTimer');
    
})($,window,document);
