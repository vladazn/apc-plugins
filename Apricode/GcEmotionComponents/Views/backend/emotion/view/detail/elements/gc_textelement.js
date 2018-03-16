//
//{block name="backend/emotion/view/detail/elements/base"}
//{$smarty.block.parent}
Ext.define('Shopware.apps.Emotion.view.detail.elements.GcTextelement', {

    extend: 'Shopware.apps.Emotion.view.detail.elements.Base',

    alias: 'widget.detail-element-emotion-components-gctextelement',
    componentCls: 'emotion--GcTextElement-element',

   
    icon: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAcCAYAAAAJKR1YAAAASUlEQVRIiWPsnbXoP8MgAkwD7QB0MOqgUTAKaA0YR8shAmDUQaNgFNAajJZDhMCog0bBKKA1oFc5tLE4LS6AGIWDLpeNOogQAADIjg11nUruLwAAAABJRU5ErkJggg==',

   
    createPreview: function() {
        var me = this,
            preview = '',
            text = me.getConfigValue('text');

        if (Ext.isDefined(text)) {
            preview = '<div class="x-emotion-html-element-preview">' + text + '</div>';
        }

        return preview;
    }
});
//{/block}
