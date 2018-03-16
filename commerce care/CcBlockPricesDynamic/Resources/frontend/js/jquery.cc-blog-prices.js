;(function($, window) {

    var blockPrices = {
        
        blockPricesContainerSelector: '#cc--block--prices-container',
        blockPriceIntervalSelector: '#cc--block--prices-container .block--price-interval',
        mainPriceFieldSelector: '#block--price-current-value',
        quantityFieldSelector: '#sQuantity',
        
        priceList: {}, 
        
        init: function() {
            var me = this;
            me.initPriceList();
            me.onQuantityChange();
            me.subscribeEvents();
        },
        
        subscribeEvents: function() {
            var me = this;
            
            $.subscribe('plugin/swAjaxVariant/onRequestData', function(){
                me.init();
            });
        },
        
        
        initPriceList: function() {
            var me = this;
            $(me.blockPriceIntervalSelector).each(function(index){
                var interval = $(this);
                me.priceList[index] = {
                    'from' : interval.data('from'),
                    'to' : interval.data('to'),
                    'price' : interval.data('price')
                };
            });
        },
        
        onQuantityChange: function() {
            var me = this;
            
            $(me.quantityFieldSelector).change(function(){
                var quantity = $(this).val();
                
                for (var key in me.priceList) {
                    if(quantity >= me.priceList[key].from && (quantity <= me.priceList[key].to || me.priceList[key].to == "")) {
                         var price = me.priceList[key].price;
                         break;
                    }
                }
              
                $(me.mainPriceFieldSelector).text(price);
            });
            
        },
        
    };
    
    $(document).ready(function(){
        if($(blockPrices.blockPricesContainerSelector).length) {
            blockPrices.init();
        }
    });
    
})(jQuery, window);
