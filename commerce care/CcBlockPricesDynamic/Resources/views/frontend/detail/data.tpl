{extends file="parent:frontend/detail/data.tpl"}

{block name="frontend_detail_data_block_price_include"}
    {if $CcPluginConfig.position eq 0}
        {$smarty.block.parent}
    {/if}
  
    <div id="cc--block--prices-container" class="is--hidden">
      {foreach $sArticle.sBlockPrices as $sBlockPrice}
         <input 
             type="hidden"
             class="block--price-interval"
             data-from="{$sBlockPrice.from}"
             data-to="{$sBlockPrice.to}"
             data-price="{$sBlockPrice.price|currency}">
      {/foreach}    
    </div>
  
    <span class="price--content content--default" id="block--price-current-value">
        <meta itemprop="price" content="{$sArticle.price|replace:',':'.'}">
        {if $sArticle.priceStartingFrom && !$sArticle.liveshoppingData}
            {s name='ListingBoxArticleStartsAt' namespace="frontend/listing/box_article"}{/s}
        {/if}
        {$sArticle.price|currency} {s name="Star" namespace="frontend/listing/box_article"}{/s}
    </span>
    
    {if $CcPluginConfig.position eq 1}
        {$smarty.block.parent}
    {/if}
    
{/block}


