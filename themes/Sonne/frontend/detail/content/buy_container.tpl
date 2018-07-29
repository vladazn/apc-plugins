{extends file="parent:frontend/detail/content/buy_container.tpl"}

{block name='frontend_detail_index_data' prepend}
    {block name='frontend_detail_index_header'}
    <header class="product--header">
        {block name='frontend_detail_index_header_inner'}
            <div class="product--info">
                {block name='frontend_detail_index_product_info'}

                    {* Product name *}
                    {block name='frontend_detail_index_name'}
                        <h1 class="product--title" itemprop="name">
                            {$sArticle.articleName}
                        </h1>
                    {/block}

                    {* Product - Supplier information *}
                    {block name='frontend_detail_supplier_info'}
                        {if $sArticle.supplierImg}
                            <div class="product--supplier">
                                <a href="{url controller='listing' action='manufacturer' sSupplier=$sArticle.supplierID}"
                                   title="{"{s name="DetailDescriptionLinkInformation" namespace="frontend/detail/description"}{/s}"|escape}"
                                   class="product--supplier-link">
                                    <img src="{$sArticle.supplierImg}" alt="{$sArticle.supplierName|escape}">
                                </a>
                            </div>
                        {/if}
                    {/block}
                {/block}
            </div>
        {/block}
    </header>
    {/block}

{/block}
{block name='frontend_detail_index_buy_container_base_info'}{/block}

{block name='frontend_detail_index_actions' append}
    {if ($sArticle.sConfiguratorSettings.type != 1 && $sArticle.sConfiguratorSettings.type != 2) || $activeConfiguratorSelection == true}
        {include file="frontend/plugins/index/delivery_informations.tpl" sArticle=$sArticle}
    {/if}
{/block}
