
///

Ext.define('Shopware.apps.GcBannerSliderController.view.components.fields.GcColor', {
    extend: 'Ext.form.TriggerField',
    alias: [
        'widget.gc-color-field'
    ],

    triggerConfig: {
        src: Ext.BLANK_IMAGE_URL,
        tag: "img",
        cls: "x-form-trigger x-form-color-trigger"
    },

    //invalidText: "Colors must be in a the hex format #FFFFFF.",
  // regex: /^#[0-9A-F]{6}|[0-9A-F]{3}$/i,

    initComponent: function () {
        this.callParent()
        this.addEvents('select');
        this.on('change', function (c, v) {
            this.onSelect(c, v);
        }, this);
    },

    // private
    onDestroy: function () {
        Ext.destroy(this.menu);
        this.callParent();
    },

    afterRender: function () {
        this.callParent(arguments)
        this.inputEl.setStyle('background', this.value);
        this.detectFontColor();
    },

    onTriggerClick: function (e) {
        if (this.disabled) {
            return;
        }
        this.menu = new Ext.ux.ColorPicker({
            shadow: true,
            autoShow: true,
            hideOnClick: false
        });
        this.menu.alignTo(this.inputEl, 'tl-bl?');
        this.menuEvents('on');
        this.menu.show(this.inputEl);
    },

    menuEvents: function (method) {
        this.menu[method]('select', this.onSelect, this);
        this.menu[method]('hide', this.onMenuHide, this);
        this.menu[method]('show', this.onFocus, this);
    },

    onSelect: function (m, d) {
        d = Ext.isString(d) && d.substr(0, 1) != '#' ? '#' + d : d;
        this.setValue(d);
        this.fireEvent('select', this, d);
        this.inputEl.setStyle('background', d);
        this.detectFontColor();
    },

    detectFontColor: function () {
        var value = this.value;
        if (!this.menu || !this.menu.picker.rawValue) {
            if (!value) {
                value = '#FFF';
            }
            if (value.length < 6) {
                value = value + value.slice(1, 5);
            };
            var h2d = function (d) {
                return parseInt(d, 16);
            }
            value = [
                h2d(value.slice(1, 3)),
                h2d(value.slice(3, 5)),
                h2d(value.slice(5))
            ];
        } else {
            value = this.menu.picker.rawValue;
        }
        var avg = (value[0] + value[1] + value[2]) / 3;
        this.inputEl.setStyle('color', (isNaN(avg) || avg > 128) ? '#000' : '#FFF');
    },

    onMenuHide: function () {
        this.focus(false, 60);
        this.menuEvents('un');
    }
});

Ext.define('Ext.ux.ColorPicker', {
    extend: 'Ext.menu.ColorPicker',
    initComponent: function () {
        var me = this;
        me.height = 100;
        me.hideOnClick = true;
        me.callParent();
        return me.processEvent();
    },
    processEvent: function () {
        return;
        var me = this;
        me.picker.clearListeners();
        me.relayEvents(me.picker, ['select']);

        if (me.hideOnClick) {
            me.on('select', me.hidePickerOnSelect, me);
        }
    }
});