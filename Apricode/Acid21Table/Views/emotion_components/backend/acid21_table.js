//
//{block name="emotion_components/backend/acid21_table"}
Ext.define('Shopware.apps.Emotion.view.components.Acid21Table', {
    extend: 'Shopware.apps.Emotion.view.components.Base',
    alias: 'widget.emotion-components-acid21table',
    snippets: {
        'table_administration': '{s name=banner_administration}<h2><i>Table Administration</i></h2>{/s}',
        'field1': '{s name=field1}<i>Field 1</i>{/s}',
        'field2': '{s name=field2}<i>Field 2</i>{/s}',
        'field3': '{s name=field3}<i>Field 3</i>{/s}',
        'field4': '{s name=field4}<i>Field 4</i>{/s}',
        'field5': '{s name=field5}<i>Field 5</i>{/s}',
        'field6': '{s name=field6}<i>Field 6</i>{/s}',
        'field7': '{s name=field7}<i>Field 7</i>{/s}',
        'field8': '{s name=field8}<i>Field 8</i>{/s}',
        'field9': '{s name=field9}<i>Field 9</i>{/s}',
        'field10': '{s name=field10}<i>Field 10</i>{/s}',
        'field11': '{s name=field11}<i>Field 11</i>{/s}',
        'field12': '{s name=field12}<i>Field 12</i>{/s}',
        'field13': '{s name=field13}<i>Field 13</i>{/s}',
        'field14': '{s name=field14}<i>Field 14</i>{/s}',
        'field15': '{s name=field15}<i>Field 15</i>{/s}',
        'field16': '{s name=field16}<i>Field 16</i>{/s}',
        'field17': '{s name=field17}<i>Field 17</i>{/s}',
        'field18': '{s name=field18}<i>Field 18</i>{/s}',
        'field19': '{s name=field19}<i>Field 19</i>{/s}',
        'field20': '{s name=field20}<i>Field 20</i>{/s}',
        'toolbar': '{s name=table_toolbar}<i>Add empty rows</i>{/s}'

    },
    /**
     * Initialize the component.
     *
     * @public
     * @return void
     */
    initComponent: function () {
        var me = this;
        me.callParent(arguments);
        me.elementFieldset.setVisible(false);
        me.items.add(me.createTableFieldset());
        me.getGridData();
        me.refreshHiddenValue();
        me.hidden_field = me.getForm().findField('tm_text_hidden_field');
    },
    refreshHiddenValue: function (editor, e) {
        var me = this,
                store = me.TableStore,
                cache = [];
        store.each(function (item) {
            cache.push(item.data);
        });

        var record = me.getSettings('record');
        record.set('mapping', cache);

    },
    createTableFieldset: function () {
        var me = this;

        me.TableStore = Ext.create('Ext.data.Store', {
            start: 0,
            limit: 10,
            fields: ['field1', 'field2', 'field3', 'field4', 'field5', 'field6', 'field7',
                'field8', 'field9', 'field10', 'field11', 'field12', 'field13', 'field14',
                'field15', 'field16', 'field17', 'field18', 'field19', 'field20']
        });


        me.cellEditing = Ext.create('Ext.grid.plugin.RowEditing', {
            clicksToEdit: 2,
            listeners:
                    {
                        edit: function (editor, e) {

                            var gridData = e.grid.getStore().data.items;
                            var Alldata = [];
                            for (var i = 0; i < gridData.length; i++) {
                                Alldata.push(Ext.encode(gridData[i].data));
                            }
                            me.hidden_field.setValue('[' + Alldata + ']');
                        }
                    }
        });


        me.getToolbarTable = Ext.create('Ext.toolbar.Toolbar', {
            dock: 'top',
            ui: 'shopware-ui',
            items: [
                {
                    iconCls: 'sprite-plus-circle-frame',
                    text: me.snippets.toolbar,
                    height: 30,
                    handler: function () {
                        var model = Ext.create('Shopware.apps.ACID21table.model.AcidFields')
                        me.TableStore.insert(0, model);
                        me.cellEditing.startEdit(0, 0);
                        me.refreshHiddenValue();
                    }
                }
            ]
        });

        me.ddGridPlugin = Ext.create('Ext.grid.plugin.DragDrop');
        me.tableGrid = Ext.create('Ext.grid.Panel', {
            columns: me.createColumns(),
            autoScroll: true,
            store: me.TableStore,
            height: 350,
            margin: 6,
            plugins: [me.cellEditing],
            viewConfig: {
                plugins: [me.ddGridPlugin],
            },
            listeners: {
                scope: me,
                edit: function () {
                    me.refreshHiddenValue();
                }
            }
        });
        me.tableGrid.addDocked(me.getToolbarTable);
        return me.bannerFieldset = Ext.create('Ext.form.FieldSet', {
            title: me.snippets.table_administration,
            layout: 'anchor',
            defaults: {
                anchor: '100%'
            },
            items: [me.getToolbar, me.tableGrid]

        });  },
    createColumns: function () {
        var me = this, snippets = me.snippets;

        return [{
                dataIndex: 'field1',
                header: snippets.field1,
                flex: 1,
                editor: {
                    xtype: 'textfield',
                    allowBlank: true
                }
            }, {
                dataIndex: 'field2',
                header: snippets.field2,
                flex: 1,
                editor: {
                    xtype: 'textfield',
                    allowBlank: true
                }
            }, {
                dataIndex: 'field3',
                header: snippets.field3,
                flex: 1,
                editor: {
                    xtype: 'textfield',
                    allowBlank: true
                }
            }, {
                dataIndex: 'field4',
                header: snippets.field4,
                flex: 1,
                editor: {
                    xtype: 'textfield',
                    allowBlank: true
                }
            }, {
                dataIndex: 'field5',
                header: snippets.field5,
                flex: 1,
                editor: {
                    xtype: 'textfield',
                    allowBlank: true
                }
            }, {
                dataIndex: 'field6',
                header: snippets.field6,
                flex: 1,
                editor: {
                    xtype: 'textfield',
                    allowBlank: true
                }
            }, {
                dataIndex: 'field7',
                header: snippets.field7,
                hidden: true,
                flex: 1,
                editor: {
                    xtype: 'textfield',
                    allowBlank: true
                }
            }, {
                dataIndex: 'field8',
                header: snippets.field8,
                hidden: true,
                flex: 1,
                editor: {
                    xtype: 'textfield',
                    allowBlank: true
                }
            }, {
                dataIndex: 'field9',
                header: snippets.field9,
                hidden: true,
                flex: 1,
                editor: {
                    xtype: 'textfield',
                    allowBlank: true
                }
            }, {
                dataIndex: 'field10',
                header: snippets.field10,
                hidden: true,
                flex: 1,
                editor: {
                    xtype: 'textfield',
                    allowBlank: true
                }
            }, {
                dataIndex: 'field11',
                header: snippets.field11,
                hidden: true,
                flex: 1,
                editor: {
                    xtype: 'textfield',
                    allowBlank: true
                }
            }, {
                dataIndex: 'field12',
                header: snippets.field12,
                hidden: true,
                flex: 1,
                editor: {
                    xtype: 'textfield',
                    allowBlank: true
                }
            }, {
                dataIndex: 'field13',
                header: snippets.field13,
                hidden: true,
                flex: 1,
                editor: {
                    xtype: 'textfield',
                    allowBlank: true
                }
            }, {
                dataIndex: 'field14',
                header: snippets.field14,
                hidden: true,
                flex: 1,
                editor: {
                    xtype: 'textfield',
                    allowBlank: true
                }
            }, {
                dataIndex: 'field15',
                header: snippets.field15,
                hidden: true,
                flex: 1,
                editor: {
                    xtype: 'textfield',
                    allowBlank: true
                }
            }, {
                dataIndex: 'field16',
                header: snippets.field16,
                hidden: true,
                flex: 1,
                editor: {
                    xtype: 'textfield',
                    allowBlank: true
                }
            }, {
                dataIndex: 'field17',
                header: snippets.field17,
                hidden: true,
                flex: 1,
                editor: {
                    xtype: 'textfield',
                    allowBlank: true
                }
            }, {
                dataIndex: 'field18',
                header: snippets.field18,
                hidden: true,
                flex: 1,
                editor: {
                    xtype: 'textfield',
                    allowBlank: true
                }
            }, {
                dataIndex: 'field19',
                header: snippets.field19,
                hidden: true,
                flex: 1,
                editor: {
                    xtype: 'textfield',
                    allowBlank: true
                }
            }, {
                dataIndex: 'field20',
                header: snippets.field20,
                hidden: true,
                flex: 1,
                editor: {
                    xtype: 'textfield',
                    allowBlank: true
                }
            }, {
                xtype: 'actioncolumn',
                header: snippets.actions,
                width: 40,
                items: [{
                        iconCls: 'sprite-minus-circle',
                        action: 'delete-banner',
                        scope: me,
                        handler: me.onDeleteTblRow
                    }]
            }];
    },
    onDeleteTblRow: function (grid, rowIndex, colIndex, item, eOpts, record) {
        var me = this;
        var store = grid.getStore();
        store.remove(record);
        var gridData = store.data.items;
        var Alldata = [];
        for (var i = 0; i < gridData.length; i++) {
            Alldata.push(Ext.encode(gridData[i].data));
        }
        me.hidden_field.setValue('[' + Alldata + ']');

    },
    getGridData: function () {
        var me = this,
                elementStore = me.getSettings('record').get('data'),
                Acid21Table;

        Ext.each(elementStore, function (element) {
            if (element.key === 'tm_text_hidden_field') {
                Acid21Table = element;
                return false;
            }
        });

        if (Acid21Table && Acid21Table.value) {
            Ext.each(Ext.decode(Acid21Table.value), function (item) {
                me.TableStore.add(Ext.create('Shopware.apps.ACID21table.model.AcidFields', item));
            });
        }

    }

});
//{/block}