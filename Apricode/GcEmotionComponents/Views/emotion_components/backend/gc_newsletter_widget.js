//{block name="emotion_components/backend/gcnewsletter_widget"}
Ext.define('Shopware.apps.Emotion.view.components.GcNewsletterWidget', {

    /**
     * Extend from the base class for the emotion components
     */
    extend: 'Shopware.apps.Emotion.view.components.Base',

    /**
     * Create the alias matching the xtype you defined in your `createEmotionComponent()` method.
     * The pattern is always 'widget.' + xtype
     */
    alias: 'widget.emotion-components-GcNewsletter',

    /**
     * The constructor method of each component.
     */
    initComponent: function () {
        var me = this;
        me.callParent(arguments);
    }

});
//{/block}