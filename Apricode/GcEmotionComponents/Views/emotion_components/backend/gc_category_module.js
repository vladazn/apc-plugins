//
//{block name="emotion_components/backend/gc_category_module"}
Ext.define('Shopware.apps.Emotion.view.components.GcCategoryModule', {

    extend: 'Shopware.apps.Emotion.view.components.Base',
    
    alias: 'widget.emotion-components-gccategorymodule',

    initComponent: function () {
        var me = this;
        me.callParent(arguments); 
         me.categoryData = me.getForm().findField('gc_category');
         for(var i = 0; i <= me.categoryData.store.data.items.length; i++) {
//             me.categoryData.store.items[i].name;
         }
    }

});
//{/block}