//
//{block name="backend/emotion/view/detail/elements/base"}
//{$smarty.block.parent}
Ext.define('Shopware.apps.Emotion.view.detail.elements.GcbannerSlider', {

    extend: 'Shopware.apps.Emotion.view.detail.elements.Base',

    alias: 'widget.detail-element-emotion-components-GcBanner',

    componentCls: 'emotion--GcBanner-slider',

    icon: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACQAAAAfCAYAAACPvW/2AAACEElEQVRYhd2XP2gUQRSHv9O9QsWYC9onNnbmsFAI2kkQbMTiSIrdwmKEgIgMxC74pxCEQQsbH6l2ilgKNkYE06VIc9dYWYRgn6CkVYvMHpvl3J095nDxV+2+eW/mY+a9t7MtSmTE/i4bH1daxa2/jUUe8Y+AfiCWLvCqzMEHqK9VvBWCxoit9DkRYqGQ8tmhYzKSXgW0i32jVfIlJFCtHTKSzgJbQA+4C2waSef/GRBwCziVe28Dt8Ph1AfaG2H7HgIkU12gj0C+VD4AG+Fwaia1VskvIDGSrgGRVsm3kDC1gTJplewG5hiqcX2ocUDjNMY2cBk4A+wVj89IehN4ANxwph3gsVaJ1/fQG8hI2gLuA8+B8zn7T+ArsA9cAuYKoYvAFeBCUCCOSnxUEzwLXKuIbfsuUieHrtfwHVuNS+rGAXnnkFbJ9CRBMvkAdX1uep7qVjn4AJXegf8bGbEj/zyigtNpYB1Y0So+mDDTOSP2LXBPq/gwMw6rzIi9CGwDyxMGyasHbLu1AWg5mEXgHdBx9nngR8lEB1U7aMTOAFMlLlPAwD3vAz2t4s+REbsKvOB4TxoUowt6Cjyp8FkDHlb4ZOoAm0bsatMa48lIq/ilEdvn6G484wYqj8xj8mfA65Lx4pEtaRV/GpaeETsLvHcwnUlXmRE77UAGwB2t4l3I5Y0zLBD4L6JCG8BCBgPwB6BfgVu8f9cIAAAAAElFTkSuQmCC',

   
    createPreview: function () {
        var me = this,
            preview = '',
            image = me.getConfigValue('banner_slider'),
            style;

        if (Ext.isDefined(image)) {
            style = Ext.String.format('background-image: url([0]);font-family: fantasy;', image);

            preview = Ext.String.format('<div class="x-emotion-banner-element-preview" style="[0]"></div>', style);
        }

        return preview;
    }
});
//{/block}