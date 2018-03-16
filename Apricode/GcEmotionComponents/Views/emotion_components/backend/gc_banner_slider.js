//{block name="emotion_components/backend/gcbanner_slider"}
Ext.define('Shopware.apps.Emotion.view.components.GcbannerSlider', {

    /**
     * Extend from the base class for the emotion components
     */
    extend: 'Shopware.apps.Emotion.view.components.Base',

    /**
     * Create the alias matching the xtype you defined in your `createEmotionComponent()` method.
     * The pattern is always 'widget.' + xtype
     */
    alias: 'widget.emotion-components-GcBanner',

    /**
     * The constructor method of each component.

     */

    snippets: {
        'select_banner': '{s name=select_banner}Select banner(s){/s}',
        'banner_administration': '{s name=banner_administration}Banner administration{/s}',
        'path': '{s name=path}Image path{/s}',
        'actions': '{s name=actions}Action(s){/s}',
        'link': '{s name=link}Link{/s}',
        'altText': '{s name=altText}Alternative text{/s}',
        'title': '{s name=title}Title{/s}',
        'htmleditor':'{s name=Gchtmleditor}Html text{/s}',
        banner_slider_title: '{s name=banner_slider_title}Title{/s}',
        banner_slider_arrows: '{s name=banner_slider_arrows}Display arrows{/s}',
        banner_slider_numbers: {
            fieldLabel: '{s name=banner_slider_numbers/label}Display numbers{/s}',
            supportText: '{s name=banner_slider_numbers/support}Please note that this setting only affects the "emotion" template.{/s}'
        },
        banner_slider_scrollspeed: '{s name=banner_slider_scrollspeed}Scroll speed{/s}',
        banner_slider_rotation: '{s name=banner_slider_rotation}Rotate automatically{/s}',
        banner_slider_rotatespeed: '{s name=banner_slider_rotatespeed}Rotation speed{/s}'
    },

    initComponent: function () {
        var me = this;

        me.callParent(arguments);
          me.setDefaultValues();
          me.add(me.createBannerFieldset());
          me.getGridData();
          me.refreshHiddenValue();
       
        
    },


    setDefaultValues: function() {
        var me = this,
            numberfields =  me.query('numberfield');

        Ext.each(numberfields, function(field) {
            if(!field.getValue()) {
                field.setValue(500);
            }
        });
    },

     createBannerFieldset: function() {
        var me = this;

   
          me.mediaSelection = Ext.create('Shopware.form.field.MediaSelection', {
            fieldLabel: me.snippets.select_banner,
            labelWidth: 155,
            albumId: -3,
            listeners: {
                scope: me,
                selectMedia: me.onAddBannerToGrid
            }
        });

        me.bannerStore = Ext.create('Ext.data.Store', {
            fields: [ 'position', 'path', 'link', 'altText', 'title', 'mediaId','GcBannerEditor' ]
        });

        me.ddGridPlugin = Ext.create('Ext.grid.plugin.DragDrop');

        me.cellEditing = Ext.create('Ext.grid.plugin.CellEditing', {
            clicksToEdit: 2
        });

        me.bannerGrid = Ext.create('Ext.grid.Panel', {
            columns: me.createColumns(),
            autoScroll: true,
            store: me.bannerStore,
            height: 200,
            plugins: [ me.cellEditing ],
            viewConfig: {
                plugins: [ me.ddGridPlugin ],
                listeners: {
                    scope: me,
                    drop: me.onRepositionBanner
                }
            },
            listeners: {
                scope: me,
                edit: function() {
                    me.refreshHiddenValue();
                }
            }
        });

        return me.bannerFieldset = Ext.create('Ext.form.FieldSet', {
            title: me.snippets.banner_administration,
            layout: 'anchor',
            defaults: { anchor: '100%' },
            items: [ me.mediaSelection, me.bannerGrid ]
        });
    },

     createColumns: function() {
        var me = this, snippets = me.snippets;

        return [{
            header: '&#009868;',
            width: 24,
            hideable: false,
            renderer : me.renderSorthandleColumn
        }, {
            dataIndex: 'path',
            header: snippets.path,
            flex: 0.4
        }, {
            dataIndex: 'link',
            header: snippets.link,
            flex: 0.7,
            editor: {
                xtype: 'textfield',
                allowBlank: true
            }
        }, {
            dataIndex: 'GcBannerEditor',
            header: snippets.htmleditor,
            id:'GcBannerEditorID',
            flex: 3
                             
        }, {
            dataIndex: 'altText',
            header: snippets.altText,
            flex: 1,
            editor: {
                xtype: 'textfield',
                allowBlank: true
            }
        }, {
            dataIndex: 'title',
            header: snippets.title,
            flex:1,
            editor: {
                xtype: 'textfield',
                allowBlank: true
            }
        }, {
            xtype: 'actioncolumn',
            header: snippets.actions,
            width: 60,
            items: [{
                iconCls:'sprite-pencil',
                action: 'html-atribute',
                scope: me,
                handler: me.GcOnPensil
            },{
                iconCls: 'sprite-minus-circle',
                action: 'delete-banner',
                scope: me,
                handler: me.onDeleteBanner
            }]
        }];
    },

    onAddBannerToGrid: function(field, records) {
        var me = this, store = me.bannerStore;

        Ext.each(records, function(record) {
            var count = store.getCount();
            var model = Ext.create('Shopware.apps.GcBannerSliderController.model.GcEditor', {
                position: count,
                path: record.get('path'),
                mediaId: record.get('id'),
                link: record.get('link'),
                altText: record.get('altText'),
                title: record.get('title'),
                GcBannerEditor: record.get('GcBannerEditor')
            });
            store.add(model);
        });

        // We need a defer due to early firing of the event
        Ext.defer(function() {
            me.mediaSelection.inputEl.dom.value = '';
            me.refreshHiddenValue();
        }, 10);

    },
    onDeleteBanner: function(grid, rowIndex, colIndex, item, eOpts, record) {
        var me = this;
        var store = grid.getStore();
        store.remove(record);
        me.refreshHiddenValue();
    },
    
    GcOnPensil:function(grid, rowIndex, colIndex, item, eOpts, record){
        var me = this;
        var gridstore = grid.getStore();
         var models = gridstore.getRange();
        
      var Win=  Ext.create('Enlight.app.Window',{
         height:400,
         width: 600,
         region: 'center',
         title : '{s name=window_title}Add html text in image{/s}',
         layout:'form',
         autoScroll:true,
          bodyStyle: 'padding: 20px 10px 0px;',
          items:[
                {    
                  xtype:'textfield',
                  fieldLabel:'slideHeadline',
                  id:'slideHeadlineID',
                  margin: 5,
                  formBind: true,
                  value:models[rowIndex].data.GcBannerEditor[0]
                },
                {    
                  xtype:'htmleditor',
                  fieldLabel:'slideSubHeadline',
                  id:'slideSubHeadlineID',
                  margin: 5,
                  formBind: true,
                  value:models[rowIndex].data.GcBannerEditor[1]
                },
                {    
                  xtype:'textfield',
                  fieldLabel:'slideButtonText',
                  id:'slideButtonTextID',
                  margin: 5,
                  formBind: true,
                  value:models[rowIndex].data.GcBannerEditor[2]
                  
                },
                {    
                  xtype:'textfield',
                  fieldLabel:'slideButtonTarget',
                  id:'slideButtonTargetID',
                  margin: 5,
                  formBind: true,
                  value:models[rowIndex].data.GcBannerEditor[3]
                }
          ],
         fbar: [{
           text: 'save',
           cls:'primary',
           formBind:true,
           handler:function(){
            var Headline = Ext.getCmp('slideHeadlineID').getValue();
             var SubHeadline = Ext.getCmp('slideSubHeadlineID').getValue();
             var ButtonTarget = Ext.getCmp('slideButtonTargetID').getValue();
             var ButtonText = Ext.getCmp('slideButtonTextID').getValue();
            var value= []; 
            value.push(Headline);   
            value.push(SubHeadline);   
            value.push(ButtonTarget);   
            value.push(ButtonText);        
             models[rowIndex].set('GcBannerEditor',value);

              Win.close();
           
              }
             },{
           text:'Cancel',
           cls:'secondary',
           handler:function(){  
            Win.close();

           }
             
             }]
        }).show(); 
             
    },
      
      onRepositionBanner: function() {
        var me = this;

        var i = 0;
        me.bannerStore.each(function(item) {
            item.set('position', i);
            i++;
        });
        me.refreshHiddenValue();
    },
    refreshHiddenValue: function() {
        var me = this,
            store = me.bannerStore,
            cache = [];
        store.each(function(item) {
            cache.push(item.data);
        });
        var record = me.getSettings('record');
        record.set('mapping', cache);
        
        
    },

   
    getGridData: function() {
        var me = this,
            elementStore = me.getSettings('record').get('data'), bannerSlider;
            
        Ext.each(elementStore, function(element) {

            if(element.key === 'banner_slider') {
                bannerSlider = element;
                return false;
            }

        });
            

        if(bannerSlider && bannerSlider.value) {
            Ext.each(bannerSlider.value, function(item) {
                me.bannerStore.add(Ext.create('Shopware.apps.GcBannerSliderController.model.GcEditor', item));
            });
        }
    },

    renderSorthandleColumn: function() {
        return '<div style="cursor: move;">&#009868;</div>';
    }
});
//{/block}