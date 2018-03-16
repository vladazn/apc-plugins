;(function($, window) {
    
    var gcProductSlider = {
        
        init: function(){
            var me = this;
            
            me.subscribeEvent();
        },
        
        subscribeEvent: function() {
            var me = this;
            
            $.subscribe('plugin/swProductSlider/onLoadItemsSuccess', function(){
                me.viewMoreInfo();    
                me.viewShortInfo();    
                me.openTabs();
                window.StateManager.destroyPlugin('*[data-ajax-wishlist="true"]', 'swAjaxWishlist');
                window.StateManager.addPlugin('*[data-ajax-wishlist="true"]', 'swAjaxWishlist');
            });
            
            $.subscribe('plugin/swProductSlider/onSlideNext', function(){
                me.onSlideRight(event);
            });
            
            $.subscribe('plugin/swProductSlider/onSlidePrev', function(){
                me.onSlideLeft(event);
            });
            
            $.subscribe('plugin/swProductSlider/onCloneItems', function(){
                me.viewMoreInfo();
                me.viewShortInfo();
                me.openTabs();
                window.StateManager.destroyPlugin('*[data-ajax-wishlist="true"]', 'swAjaxWishlist');
                window.StateManager.addPlugin('*[data-ajax-wishlist="true"]', 'swAjaxWishlist');
            });
            
        },
        
        onSlideRight: function(event){
            var $nextArrow = $(event.target);                 
            if($nextArrow.parents('.product-slider--content').find('.box--gcSlider').hasClass('is-scaled')){

                
                var scaledItem = $nextArrow.parents('.product-slider--content').find('.is-scaled').parents('.product-slider--item');
                var sliderContainer = $nextArrow.parents('.product-slider--content').find('.product-slider--container');
                
                var containerPositionRight = $(window).width() - (sliderContainer.offset().left +  sliderContainer.outerWidth());

                var itemPositionRight = $(window).width() - (scaledItem.offset().left + scaledItem.outerWidth()) - scaledItem.outerWidth();

                var containerPositionLeft = sliderContainer.offset().left;

                var itemPositionLeft = scaledItem.offset().left - scaledItem.outerWidth();

                $nextArrow.parent().find('.is-right').removeClass('is-right');

                if(containerPositionLeft - itemPositionLeft < 40 && containerPositionLeft - itemPositionLeft > -40){
                    if(!(scaledItem.hasClass('is-left'))){
                        scaledItem.addClass('is-left');
                        return;
                    }
                }
                
                if(scaledItem.hasClass('is-left')){
                    scaledItem.find('.icon--cross').trigger('click');
                    scaledItem.removeClass('is-left');
                }

            }

        },
        
        onSlideLeft: function(event){
            var $prevArrow = $(event.target);

            if($prevArrow.parents('.product-slider--content').find('.box--gcSlider').hasClass('is-scaled')){

                var scaledItem = $prevArrow.parents('.product-slider--content').find('.is-scaled').parents('.product-slider--item');
                var sliderContainer = $prevArrow.parents('.product-slider--content').find('.product-slider--container');
                
                var containerPositionRight = $(window).width() - (sliderContainer.offset().left +  sliderContainer.outerWidth());

                var itemPositionRight = $(window).width() - (scaledItem.offset().left + scaledItem.outerWidth()) - scaledItem.outerWidth();

                var containerPositionLeft = sliderContainer.offset().left;

                var itemPositionLeft = scaledItem.offset().left - scaledItem.outerWidth();
                
                $prevArrow.parent().find('.is-left').removeClass('is-left');


                if(containerPositionRight - itemPositionRight < 40 && containerPositionRight - itemPositionRight > -40){
                    if(!(scaledItem.hasClass('is-right'))){
                        scaledItem.addClass('is-right');
                        return;
                    }
                }
                
                if(scaledItem.hasClass('is-right')){
                    scaledItem.find('.icon--cross').trigger('click');
                    scaledItem.removeClass('is-right');
                }
            }
        },
        
        viewMoreInfo: function(){
            var me = this;
            
            $('.box--gcSlider .gc-quick-info').unbind('click').on('click', function(){
               var currentProduct = $(this);
                
               var scaledItem = currentProduct.parents('.product-slider--container').find('.is-scaled');
             
                if(currentProduct.parents('.product-slider--container').find('.box--gcSlider').hasClass('is-scaled')){
                    
                    scaledItem.find('.gc-slider-product-info-box').fadeOut(300, function(){
                       scaledItem.removeClass('is-scaled');
                       scaledItem.parents('.product-slider--item').removeClass('is-left');
                       scaledItem.parents('.product-slider--item').removeClass('is-right');
                        
                       scaledItem.find('.gc-short-info').fadeIn(300, function(){
                           currentProduct.parents('.box--gcSlider').find('.gc-short-info').fadeOut(300, function(){
                               currentProduct.parents('.box--gcSlider').addClass('is-scaled');
                               
                               me.checkPosition(currentProduct);
                               
                               currentProduct.parents('.box--gcSlider').find('.gc-slider-product-info-box').fadeIn(300);
                           });
                       });
                    }); 
                    
                }else{ 

                    currentProduct.parents('.box--gcSlider').find('.gc-short-info').fadeOut(300, function(){
                        currentProduct.parents('.box--gcSlider').addClass('is-scaled');

                        me.checkPosition(currentProduct);
                        
                       currentProduct.parents('.box--gcSlider').find('.gc-slider-product-info-box').fadeIn(300);
                    });    
                    
                }
                
            });
        },
        
        checkPosition: function(currentProduct){
            var containerPosition = $(window).width() - (currentProduct.parents('.product-slider--container').offset().left                      +  currentProduct.parents('.product-slider--container').outerWidth());
                
            var itemPosition = $(window).width() - (currentProduct.parents('.product-slider--item').offset().left +                            currentProduct.parents('.product-slider--item').outerWidth());

            if(currentProduct.parents('.product-slider--item').offset().left - currentProduct.parents('.product-slider--container').offset().left < 40){
                currentProduct.parents('.product-slider--item').addClass('is-left');
            }

            if(containerPosition - itemPosition < 40 && containerPosition - itemPosition > -40){
                currentProduct.parents('.product-slider--item').addClass('is-right');
            }
        },
        
        viewShortInfo: function(){
            $('.gc-slider-product-info-box .icon--cross').on('click', function(){
                var currentProduct = $(this);
                
                $(this).parents('.gc-slider-product-info-box').fadeOut(300, function(){
                    currentProduct.parents('.box--gcSlider').removeClass('is-scaled');
                    
                    currentProduct.parents('.product-slider--item').removeClass('is-left');
                    currentProduct.parents('.product-slider--item').removeClass('is-right');
                    
                    currentProduct.parents('.box--gcSlider').find('.gc-short-info').fadeIn(300);
                });
            });
        },
        
        openTabs: function(){
            $('.gc-slider-product-tabs li').unbind('click').on('click',function(){
                
                if( $(this).parents('.gc-slider-product-tabs').find('li').hasClass('is-opened')){
                    if($(this).hasClass('is-opened')){
                        
                        $(this).toggleClass('is-opened');
                        $(this).find('.gc-tab-content').slideToggle(400);
                        
                    }else{
                        var clickedTab = $(this);
                        var openedTab = clickedTab.parents('.gc-slider-product-tabs').find('li.is-opened');
                        openedTab.find('.gc-tab-content').slideToggle(400,function(){
                            openedTab.removeClass('is-opened');
                            clickedTab.toggleClass('is-opened');
                            clickedTab.find('.gc-tab-content').slideToggle(400);
                        });
                    }
                }else{

                    $(this).toggleClass('is-opened');
                    $(this).find('.gc-tab-content').slideToggle(400);
                    
                }
                
            });
        }
        
    };
    
    $(document).ready(function(){
        gcProductSlider.init();
    });    
    
})(jQuery, window);