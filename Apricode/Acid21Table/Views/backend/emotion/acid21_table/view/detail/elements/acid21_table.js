//
//{block name="backend/emotion/view/detail/elements/base"}
//{$smarty.block.parent}
Ext.define('Shopware.apps.Emotion.view.detail.elements.Acid21Table', {
    extend: 'Shopware.apps.Emotion.view.detail.elements.Base',
    alias: 'widget.detail-element-emotion-components-acid21table',
    componentCls: 'emotion--acid21table-element',
    icon: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAcCAYAAAAJKR1YAAAASUlEQVRIiWPsnbXoP8MgAkwD7QB0MOqgUTAKaA0YR8shAmDUQaNgFNAajJZDhMCog0bBKKA1oFc5tLE4LS6AGIWDLpeNOogQAADIjg11nUruLwAAAABJRU5ErkJggg==',
    createPreview: function () {
        var me = this,
                preview = '',
                text = 'Grid for shop pages';

        if (Ext.isDefined(text)) {
            preview = '<div class="x-emotion-element-preview">' + text + '</div>';
        }

        return preview;
    }
});
//{/block}
