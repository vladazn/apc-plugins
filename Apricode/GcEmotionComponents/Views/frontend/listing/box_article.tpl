{extends file="parent:frontend/listing/box_article.tpl"}

{block name="frontend_listing_box_article_includes"}
   {if $productBoxLayout == 'gcSlider'}
       
       {namespace name="frontend/listing/box_article"}

        {block name="frontend_listing_box_article"}
            <div class="product--box box--{$productBoxLayout}" data-ordernumber="{$sArticle.ordernumber}">

                {block name="frontend_listing_box_article_content"}
                    <div class="box--content">

                        {block name='frontend_listing_box_article_info_container'}
                            <div class="product--info gc-short-info">

                                {* Product image *}
                                {block name='frontend_listing_box_article_picture'}
                                    <a href="{url controller=detail action=index sArticle=$sArticle.articleID}"
                                       title="{$sArticle.articleName|escape}"
                                       class="product--image{if $imageOnly} is--large{/if}">

                                        {block name='frontend_listing_gc_box_article_image_element'}
                                            <span class="image--element">

                                                {block name='frontend_listing_gc_box_article_image_media'}
                                                    <span class="image--media">

                                                        {block name='frontend_listing_gc_box_article_image_picture'}
                                                            {if $sArticle.image.thumbnails}

                                                                {$baseSource = $sArticle.image.thumbnails[1].source}

                                                                {if $itemCols && $emotion.grid.cols && !$fixedImageSize}
                                                                    {$colSize = 100 / $emotion.grid.cols}
                                                                    {$itemSize = "{$itemCols * $colSize}vw"}
                                                                {else}
                                                                    {$itemSize = "200px"}
                                                                {/if}

                                                                {foreach $sArticle.image.thumbnails as $image}
                                                                    {$srcSet = "{if $image@index !== 0}{$srcSet}, {/if}{$image.source} {$image.maxWidth}w"}

                                                                    {if $image.retinaSource}
                                                                        {$srcSetRetina = "{if $image@index !== 0}{$srcSetRetina}, {/if}{$image.retinaSource} {$image.maxWidth}w"}
                                                                    {/if}
                                                                {/foreach}
                                                            {elseif $sArticle.image.source}
                                                                {$baseSource = $sArticle.image.source}
                                                            {else}
                                                                {$baseSource = "{link file='frontend/_public/src/img/no-picture.jpg'}"}
                                                            {/if}

                                                            {$desc = $sArticle.articleName|escape}

                                                            {if $sArticle.image.description}
                                                                {$desc = $sArticle.image.description|escape}
                                                            {/if}

                                                            <picture>
                                                                {if $srcSetRetina}<source sizes="(min-width: 48em) {$itemSize}, 100vw" srcset="{$srcSetRetina}" media="(min-resolution: 192dpi)" />{/if}
                                                                {if $srcSet}<source sizes="(min-width: 48em) {$itemSize}, 100vw" srcset="{$srcSet}" />{/if}
                                                                <img src="{$baseSource}" alt="{$desc}" title="{$desc|truncate:160}" />
                                                            </picture>
                                                        {/block}
                                                    </span>
                                                {/block}
                                            </span>
                                        {/block}
                                    </a>
                                {/block}

                                <div class="product--details">

                                    {* Product name *}
                                    {block name='frontend_listing_gc_box_article_name'}
                                        <a href="{url controller=detail action=index sArticle=$sArticle.articleID}"
                                           class="product--title"
                                           title="{$sArticle.articleName|escapeHtml}">
                                            {$sArticle.articleName|truncate:50|escapeHtml} Lorem ipsum dolor sit amet 67-16. Uno ipsum dolor 54/687.
                                        </a>
                                    {/block}

                                    {block name='frontend_listing_gc_box_article_other_info'}
                                        <p class="gc-slider-order-number">
                                            {$sArticle.ordernumber}
                                        </p>
                                        
                                        <ul class="gc-product-controll-box">
                                            <li class="gc-quick-info">
                                                <i class="icon--plus3"></i> Quickinfo
                                            </li>
                                                
                                            <li>
                                                <form action="{url controller='note' action='add' ordernumber=$sArticle.ordernumber}" method="post" class="action--form">
                                                    <button type="submit"
                                                       class="action--link link--notepad"
                                                       title="{"{s name='DetailLinkNotepad'}{/s}"|escape}"
                                                       data-ajaxUrl="{url controller='note' action='ajaxAdd' ordernumber=$sArticle.ordernumber}">
                                                        <i class="icon--star"></i>
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    {/block}
                                </div>
                            </div>
                            
                            
                            <div class="gc-slider-product-info-box">
                                {block name='frontend_listing_box_article_additional_info'}
                                    <div class="gc-more-info-header-box">
                                        <i class="icon--cross"></i>
                                        
                                        <a href="{url controller=detail action=index sArticle=$sArticle.articleID}"
                                           class="product--title"
                                           title="{$sArticle.articleName|escapeHtml}">
                                            {$sArticle.articleName|truncate:50|escapeHtml} Lorem ipsum dolor sit amet 67-16. Uno ipsum dolor 54/687.
                                        </a>
                                        
                                        <p class="gc-slider-order-number">
                                            {$sArticle.ordernumber}
                                        </p>
                                    </div>
                                    
                                    
                                    <ul class="gc-slider-product-tabs">
                                        <li>
                                            <p class="gc-tab-header">
                                                lorem ipsum 
                                                <i class="icon--plus3"></i>
                                                <i class="icon--minus3"></i>
                                            </p>
                                            
                                            <div class="gc-tab-content">
                                                
                                            </div>
                                        </li>
                                            
                                        <li>
                                            <p class="gc-tab-header">
                                                lorem ipsum 
                                                <i class="icon--plus3"></i>
                                                <i class="icon--minus3"></i>
                                            </p>
                                            
                                            <div class="gc-tab-content">
                                                
                                            </div>
                                        </li>
                                        
                                        <li>
                                            <p class="gc-tab-header">
                                                lorem ipsum 
                                                <i class="icon--plus3"></i>
                                                <i class="icon--minus3"></i>
                                            </p>
                                            
                                            <div class="gc-tab-content">
                                                
                                            </div>
                                        </li>
                                        
                                        <li>
                                            <p class="gc-tab-header">
                                                lorem ipsum 
                                                <i class="icon--plus3"></i>
                                                <i class="icon--minus3"></i>
                                            </p>
                                            
                                            <div class="gc-tab-content">
                                                
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="gc-link-box">
                                        <a href="{url controller=detail action=index sArticle=$sArticle.articleID}"
                                           class="gc-to-detail"
                                           title="{$sArticle.articleName|escapeHtml}">
                                            Lorem ipsum
                                        </a>
                                    </div>
                                {/block}
                            </div>
                            
                        {/block}
                    </div>
                {/block}
            </div>
        {/block}
   {else}
       {$smarty.block.parent}
    {/if}
{/block}