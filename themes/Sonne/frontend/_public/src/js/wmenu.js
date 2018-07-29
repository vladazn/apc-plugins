;(function ($,window,document) {

   var wmenu = {


       triggerSelector: '.wmenu--trigger',
       listContainerSelector: '.wmenu--list-container',

       init: function() {
           var me = this;
           $(me.triggerSelector).click(function() {
               me.toggleListMenu();
           });
       },

       toggleListMenu: function(){
           var me = this;

           if(!$(me.listContainerSelector).hasClass('is--active')){
               $(me.listContainerSelector).addClass('is--active').slideDown();
               $(me.triggerSelector).addClass('is--active');
           }
           else if($(me.listContainerSelector).hasClass('is--active')){
               $(me.listContainerSelector).removeClass('is--active').slideUp();
               $(me.triggerSelector).removeClass('is--active');
           }
       },

    }

    $(document).ready(function(){
       var body = $('body');

       wmenu.init();

    });



})($,window,document);
