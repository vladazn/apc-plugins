$(function () {
    GcEmotionComponent.init();
});

var GcEmotionComponent = {
    defaults: {
        /**
         * Plugin name.
         * 
         * @type {String}
         */
        pluginName: "GcEmotionComponent",
        /**
         * Selector for the advanced banner container.
         * 
         * @type {String}
         */
        emotionComponentSelector: ".gc--emotion-component",
    },
    /**
     * Initialize the plugin
     * 
     * @method init
     * @return void
     */
    init: function () {
        var self = this;
        self.opt = self.defaults;
        
        self.subscribeShopwarePluginsEvents();
      
        
        $.publish('plugin/' + self.opt.pluginName + '/init', [self]);
    },
    /**
     * Subscribe to shopware javascript plugins published events.
     *
     * @public
     * @method subscribeShopwarePluginsEvents
     */
    subscribeShopwarePluginsEvents: function () {
        var self = this;
        $.publish('plugin/' + self.opt.pluginName + '/subscribeShopwarePluginsEvents', [self]);
    },
};