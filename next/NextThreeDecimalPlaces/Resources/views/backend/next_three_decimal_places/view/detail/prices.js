//
//{block name="backend/article/view/detail/prices"}
//{$smarty.block.parent}
Ext.define('Shopware.apps.NextThreeDecimalPlaces.view.detail.Prices', {

	override:'Shopware.apps.Article.view.detail.Prices',

    /**
     * Define that the billing field set is an extension of the Ext.form.FieldSet
     * @string
     */
    extend:'Ext.form.FieldSet',
    /**
     * The Ext.container.Container.layout for the fieldset's immediate child items.
     * @object
     */
    layout: 'anchor',
    /**
     * List of short aliases for class names. Most useful for defining xtypes for widgets.
     * @string
     */
    alias:'widget.article-prices-field-set',
    /**
     * Set css class for this component
     * @string
     */
    cls: Ext.baseCSSPrefix + 'article-prices-field-set',
    /**
     * Contains all snippets for the view component
     * @object
     */
    snippets:{
        title:'{s name=detail/prices/title namespace="backend/article/view/main"}Prices{/s}',
        any:'{s name=detail/prices/any namespace="backend/article/view/main"}Arbitrary{/s}',
        grid: {
            titleGross:'{s name=detail/price/title_gross namespace="backend/article/view/main"}[0] Gross{/s}',
            titleNet:'{s name=detail/price/title_net namespace="backend/article/view/main"}[0] Net{/s}',
            columns: {
                from: '{s name=detail/price/from namespace="backend/article/view/main"}From{/s}',
                to: '{s name=detail/price/to namespace="backend/article/view/main"}To{/s}',
                price: '{s name=detail/price/price namespace="backend/article/view/main"}Price{/s}',
                percent: '{s name=detail/price/percent namespace="backend/article/view/main"}Percent discount{/s}',
                pseudoPrice: '{s name=detail/price/pseudo_price namespace="backend/article/view/main"}Pseudo price{/s}'
            },
            any:'{s name=detail/price/any namespace="backend/article/view/main"}Arbitrary{/s}'
        }
    },

    attributeTable: 's_articles_prices_attributes',

    /**
     * The initComponent template method is an important initialization step for a Component.
     * It is intended to be implemented by each subclass of Ext.Component to provide any needed constructor logic.
     * The initComponent method of the class being created is called first,
     * with each initComponent method up the hierarchy to Ext.Component being called thereafter.
     * This makes it easy to implement and, if needed, override the constructor logic of the Component at any step in the hierarchy.
     * The initComponent method must contain a call to callParent in order to ensure that the parent class' initComponent method is also called.
     *
     * @return void
     */
    initComponent:function () {
        var me = this,
            mainWindow = me.subApp.articleWindow;

        mainWindow.on('storesLoaded', me.onStoresLoaded, me);
        me.title = me.snippets.title;
        me.registerEvents();
        me.callParent(arguments);
    },

    /**
     * Registers additional component events.
     */
    registerEvents: function() {
        this.addEvents(
            /**
             * Event will be fired when the user change the tab panel in the price field set.
             *
             * @event
             * @param [object] The previous tab panel
             * @param [object] The clicked tab panel
             * @param [Ext.data.Store] The price store
             * @param [array] The price data of the first customer group.
             */
            'priceTabChanged',
            /**
             * Fired when the user clicks the remove action column of the price grid
             *
             * @event
             * @param [array] The row record
             */
            'removePrice'
        );
    },

    /**
     * Creates the elements for the description field set.
     * @return array Contains all Ext.form.Fields for the description field set
     */
    createElements: function () {
        var me = this, tabs = [];

        me.preparePriceStore();

        me.customerGroupStore.each(function(customerGroup) {
            if (customerGroup.get('mode') === false) {
                var tab = me.createPriceGrid(customerGroup, me.priceStore);
                tabs.push(tab);
            }
        });
        me.priceGrids = tabs;

        me.tabPanel = Ext.create('Ext.tab.Panel', {
            height: 150,
            activeTab: 0,
            plain: true,
            items : tabs,
            listeners: {
                beforetabchange: function(panel, newTab, oldTab) {
                    me.fireEvent('priceTabChanged', oldTab, newTab, me.priceStore, me.customerGroupStore)
                }
            }
        });

        return me.tabPanel;
    },

    /**
     * Prepares the price store items for the selected customer group
     */
    preparePriceStore: function() {
        var me = this, firstGroup = me.customerGroupStore.first();

        me.priceStore.clearFilter();
        me.priceStore.filter({
            filterFn: function(item) {
                return item.get("customerGroupKey") === firstGroup.get('key');
            }
        });

        if (me.priceStore.data.length === 0) {
            var price = Ext.create('Shopware.apps.Article.model.Price', {
                from: 1,
                to: me.snippets.any,
                price: 0,
                pseudoPrice: 0,
                percent: 0,
                customerGroupKey: firstGroup.get('key')
            });
            me.priceStore.add(price)
        }
    },

    /**
     * Creates a grid for the article prices.
     *
     * @param customerGroup
     * @param priceStore
     * @return Ext.grid.Panel
     */
    createPriceGrid: function(customerGroup, priceStore) {
        var me = this;

        var title = me.snippets.grid.titleNet;
        if (customerGroup.get('taxInput')) {
            title = me.snippets.grid.titleGross;
        }
        title = Ext.String.format(title, customerGroup.get('name'));
        return Ext.create('Ext.grid.Panel', {
            alias:'widget.article-price-grid',
            cls: Ext.baseCSSPrefix + 'article-price-grid',
            height: 100,
            sortableColumns: false,
            plugins: [{
                ptype: 'cellediting',
                clicksToEdit: 1
            }, {
                ptype: 'grid-attributes',
                table: me.attributeTable
            }],
            defaults: {
                align: 'right',
                flex: 2
            },
            title: title,
            store: priceStore,
            customerGroup: customerGroup,
            columns: me.getColumns()
        });
    },

    /**
     * Creates the elements for the description field set.
     * @return Array -  Contains all Ext.form.Fields for the description field set
     */
    getColumns: function () {
        var me = this;

        return [
            {
                header: me.snippets.grid.columns.from,
                dataIndex: 'from'
            }, {
                xtype: 'numbercolumn',
                header: me.snippets.grid.columns.to,
                dataIndex: 'to',
				decimalPrecision: 3,
                flex: 1,
                editor: {
                    xtype: 'numberfield',
                    minValue: 0,
                    decimalPrecision: 3
                },
                renderer: function(v) {
                    if (Ext.isNumeric(v)) {
                        return v;
                    } else {
                        return me.snippets.grid.any;
                    }
                }

            }, {
                xtype: 'numbercolumn',
                header: me.snippets.grid.columns.price,
                dataIndex: 'price',
				decimalPrecision: 3,
				precision: 3,
				renderer: function(v) {
					return Ext.util.Format.number(v, '0,00.000');
				},
                editor: {
                    xtype: 'numberfield',
                    decimalPrecision: 3,
                    minValue: 0
                }
            }, {
                xtype: 'numbercolumn',
                header: me.snippets.grid.columns.percent,
                dataIndex: 'percent',
				decimalPrecision: 3,
                editor: {
                    xtype: 'numberfield',
                    minValue: 0,
                    decimalPrecision: 3,
                    maxValue: 100
                },
                renderer: function(v) {
                    if (!Ext.isNumeric(v)) {
                        return ''
                    }
                    return Ext.util.Format.number(v) + ' %'
                }
            }, {
                xtype: 'numbercolumn',
                header: me.snippets.grid.columns.pseudoPrice,
                dataIndex: 'pseudoPrice',
				decimalPrecision: 3,
				precision: 3,
				renderer: function(v) {
					return Ext.util.Format.number(v, '0,00.000');
				},
                editor: {
                    xtype: 'numberfield',
                    decimalPrecision: 3,
                    minValue: 0
                }
            }, {
                xtype: 'actioncolumn',
                width: 25,
                items: [
                    {
                        iconCls: 'sprite-minus-circle-frame',
                        action: 'delete',
                        tooltip: me.snippets.grid.delete,
                        handler: function (view, rowIndex, colIndex, item, opts, record) {
                            me.fireEvent('removePrice', record, view, rowIndex);
                        },
                        /**
                         * If the item has no leaf flag, hide the add button
                         * @param value
                         * @param metadata
                         * @param record
                         * @return string
                         */
                        getClass: function(value, metadata, record, rowIdx) {
                            if (Ext.isNumeric(record.get('to')) || rowIdx === 0)  {
                                return 'x-hidden';
                            }
                        }
                    }
                ]
            }
        ];
    },

    onStoresLoaded: function(article, stores) {
        var me = this;
        me.article = article;

        me.customerGroupStore = stores['customerGroups'];
        me.priceStore = me.priceStore = me.article.getPrice();
        me.add(me.createElements());
    }

});
//{/block}
