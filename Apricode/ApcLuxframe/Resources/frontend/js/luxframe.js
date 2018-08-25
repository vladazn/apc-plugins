;(function ($, window) {
    'use strict';

    $.plugin('apcLuxframe', {

        defaults: {

        },

        init: function() {
            var me = this;
            me.registerEvents();
        },

        registerEvents: function(){
            var me = this;
            me._on(me.$el.find('.lightbox--title'), 'click', $.proxy(me.onTabTitleClick, me));
            me._on(me.$el.find('#frame_width'), 'blur', $.proxy(me.onPropChange, me));
            me._on(me.$el.find('#frame_height'), 'blur', $.proxy(me.onPropChange, me));
            $.subscribe('plugin/swAjaxVariant/onChange', function(e, plugin, values, $target){
                window.lastTargetIndex = $($target).parents('.lightbox--tab').index();
            });
            $.subscribe('plugin/swAjaxVariant/onRequestData', function(e, plugin, response, values, location){
                me.onVariantChange(window.lastTargetIndex);
            });

            // $('#image--upload').cropper();
            var width = parseInt(me.$el.find('#frame_width').val()),
              height = parseInt(me.$el.find('#frame_height').val());
              var vwidth, vheight;
              if(width > height){
                  vwidth = 400;
                  vheight = height/width*400;
              }else{
                  vheight = 400;
                  vwidth = width/height*400;
              }
            var $image_crop = $('#image_demo').croppie({
                viewport: {
                    width:vwidth,
                    height:vheight,
                    type:'square' //circle
                },
                boundary:{
                    width:500,
                    height:500
                },
                enableExif: true,
            });

            $('#upload_image').on('change', function(){
                var reader = new FileReader();
                reader.onload = function (event) {
                  $image_crop.croppie('bind', {
                    url: event.target.result
                });
                  // .then(function(){
                  //   console.log('jQuery bind complete');
                  // });
                }
                // console.log(this.files);
                reader.readAsDataURL(this.files[0]);
                $('#uploadimageModal').removeClass('is--hidden');
          });

          $('.crop_image').click(function(event){
              $.loadingIndicator.open();
              $image_crop.croppie('result', {
                      type: 'canvas',
                      size: 'viewport'
                  }).then(function(response){
                  $.ajax({
                      url:"/luxframe/upload",
                      type: "POST",
                      data:{"image": response},
                      success:function(data)
                      {
                          $.loadingIndicator.close();
                          $('#uploaded_image').html(data.data);
                          $('.media_buy').attr('value', data.id);
                          $('#uploadimageModal').addClass('is--hidden');
                          var activeTab = $('input:checked').last().parents('.lightbox--tab');
                          for(var i = 0; i <= activeTab.index(); i++) {
                              $('.lightbox--tab').eq(i).addClass('is--completed').removeClass('is--disabled').removeClass('is--active');
                          }
                          activeTab.next('.lightbox--tab').addClass('is--active').removeClass('is--disabled');
                      }
                  });
              })
          });


        },

        onTabTitleClick: function(e){
            var me = this;
            if($(e.currentTarget).parent('.lightbox--tab').hasClass('is--disabled')){
                return;
            }
            $('.lightbox--tab').removeClass('is--active');
            $(e.currentTarget).parent('.lightbox--tab').addClass('is--active');
        },

        onVariantChange: function(lastTargetIndex){
            var me = this;

            $('.lightbox--tab').removeClass('is--active');
            var activeTab = $('input:checked').last().parents('.lightbox--tab');
            activeTab.removeClass('is--disabled');
            if(activeTab.find('input:checked').length == activeTab.data('selection')){
                if(activeTab.data('needimage')){
                    activeTab.addClass('is--active');
                    for(var i = 0; i < activeTab.index(); i++) {
                        $('.lightbox--tab').eq(i).addClass('is--completed').removeClass('is--disabled').removeClass('is--active');
                    }
                }else if(activeTab.data('needcolor') && !activeTab.find('select').val()){
                    activeTab.addClass('is--active');
                    for(var i = 0; i < activeTab.index(); i++) {
                        $('.lightbox--tab').eq(i).addClass('is--completed').removeClass('is--disabled').removeClass('is--active');
                    }
                }else if(activeTab.data('last')){
                    for(var i = 0; i <= activeTab.index(); i++) {
                        $('.lightbox--tab').eq(i).addClass('is--completed').removeClass('is--disabled').removeClass('is--active');
                    }
                    $('.buybox--button').removeClass('is--disabled').removeAttr('disabled');
                }else{
                    for(var i = 0; i <= activeTab.index(); i++) {
                        $('.lightbox--tab').eq(i).addClass('is--completed').removeClass('is--disabled').removeClass('is--active');
                    }
                    activeTab.next('.lightbox--tab').addClass('is--active').removeClass('is--disabled');
                }
            }else{
                for(var i = 0; i < activeTab.index(); i++) {
                    $('.lightbox--tab').eq(i).addClass('is--completed').removeClass('is--disabled').removeClass('is--active');
                }
                activeTab.addClass('is--active');
            }
        },


        onPropChange: function(e){
            var me = this,
                width = me.$el.find('#frame_width').val(),
                height = me.$el.find('#frame_height').val();

            if(width < 500){
                me.$el.find('#frame_width').val(500);
                width = 500;
            }else if(width > 4000){
                me.$el.find('#frame_width').val(4000);
                width = 4000;
            }
            if(height < 500){
                me.$el.find('#frame_height').val(500);
                height = 500;
            }else if(height > 4000){
                me.$el.find('#frame_height').val(4000);
                height = 4000;
            }

            $('.option--input').first().change();
        },

    });

    $.subscribe('plugin/swAjaxVariant/onRequestData',function(){
        window.StateManager.addPlugin('*[data-luxframe="true"]', 'apcLuxframe')
    })
    window.StateManager.addPlugin('*[data-luxframe="true"]', 'apcLuxframe')

    $( document ).ready(function() {
        if($('#data_preselected').length){
            $('input:checked').last().change();
        }
    });

})(jQuery, window);
