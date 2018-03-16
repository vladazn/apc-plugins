{block name="widgets_emotion_components_GcBannerSlider_element"}
    <div class="emotion--banner-slider image-slider gc-top-slider"
         data-image-slider="true"
         data-thumbnails="false"
         data-lightbox="false"
         data-loopSlides="true"
         data-animationSpeed='{$Data["scrol-speed"]}'
         data-arrowControls="{if $Data.Slider_arrows}true{else}false{/if}"
         data-autoSlideInterval='{$Data["rotate-speed"]}'
         data-autoSlide="{if $Data.autorotate eq '1'}true{else}false{/if}"
         data-imageSelector=".image-slider--item">

        {if $Data.bannerSliderTitle}
            <div class="banner-slider--title">{$Data.title}</div>
        {/if}
        {block name="frontend_widgets_banner_slider_container"}
            <div class="banner-slider--container image-slider--container">

                {block name="frontend_widgets_banner_slider_slide"}
                    <div class="banner-slider--slide image-slider--slide">
                            
                        {foreach $Data.banner_slider as $banner}
                            {block name="frontend_widgets_banner_slider_item"}
                                <div class="banner-slider--item image-slider--item"
                                     data-coverImage="true"
                                     data-containerSelector=".banner-slider--banner"
                                     data-width="{$banner.fileInfo.width}"
                                     data-height="{$banner.fileInfo.height}">
                                    
                                    {block name="frontend_widgets_banner_slider_banner"}
                                        <div class="banner-slider--banner">
                                         
                                            {block name="frontend_widgets_banner_slider_banner_picture"}
                                                {if $banner.thumbnails}
                                                    {$baseSource = $banner.thumbnails[0].source}
                                                    {$srcSet = ''}
                                                    {$itemSize = ''}

                                                    {foreach $element.viewports as $viewport}
                                                        {$cols = ($viewport.endCol - $viewport.startCol) + 1}
                                                        {$elementSize = $cols * $cellWidth}
                                                        {$size = "{$elementSize}vw"}

                                                        {if $breakpoints[$viewport.alias]}

                                                            {if $viewport.alias === 'xl' && !$emotionFullscreen}
                                                                {$size = "calc({$elementSize / 100} * {$baseWidth}px)"}
                                                            {/if}

                                                            {$size = "(min-width: {$breakpoints[$viewport.alias]}) {$size}"}
                                                        {/if}

                                                        {$itemSize = "{$size}{if $itemSize}, {$itemSize}{/if}"}
                                                    {/foreach}

                                                    {foreach $banner.thumbnails as $image}
                                                        {$srcSet = "{if $srcSet}{$srcSet}, {/if}{$image.source} {$image.maxWidth}w"}

                                                        {if $image.retinaSource}
                                                            {$srcSet = "{if $srcSet}{$srcSet}, {/if}{$image.retinaSource} {$image.maxWidth * 2}w"}
                                                        {/if}
                                                    {/foreach}
                                                {else}
                                                    {$baseSource = $banner.source}
                                                {/if}
                                        
                                                <img src="{$banner.path}"
                                                     class="banner-slider--image"
                                                     {if $srcSet}sizes="{$itemSize}" srcset="{$srcSet}"{/if}
                                                     {if $banner.altText}alt="{$banner.altText|escape}" {/if}/>
                                                   
                                            {/block}
                                         
                                        </div>
                                        
                                        {if $banner.GcBannerEditor}
                                            {if strpos($banner.GcBannerEditor[2], 'http') !== false}
                                                {$link = $banner.GcBannerEditor[2]}
                                                {$text = $banner.GcBannerEditor[3]}
                                            {else}
                                                {$link = $banner.GcBannerEditor[3]}
                                                {$text = $banner.GcBannerEditor[2]}
                                            {/if}
                                            
                                              <div class="gc-emotion-element-style gc-banner-slider" 
                                                 style="{if $Data.background_color}background-color: {$Data.background_color}{/if}">
                                                  {if $banner.GcBannerEditor[0] != ""}
                                                  <h2 class='gc-headline'>{$banner.GcBannerEditor[0]}</h2>
                                                  {/if}
                                                  {if $banner.GcBannerEditor[1] != ""}<p class='gc-subheadline'>{$banner.GcBannerEditor[1]}</p>{/if}
                                                  {if $text != ""}
                                                  <a class="gc-link" href="{$link}" title="{$text|escape}" 
                                                     style="{if $Data.button_background_color}background-color: {$Data.button_background_color};
                                                     color: {$Data.background_color}
                                                     {/if}">
                                                     {$text}
                                                  </a>
                                                  {/if}
                                              </div>
                                         {/if}
                                    {/block}

                                    {if $banner.link}
                                        {block name="frontend_widgets_banner_slider_link"}
                                            <a class="banner-slider--link" href="{$banner.link}" title="{$banner.title|escape}">
                                                {$banner.altText}

                                            </a>
                                        {/block}
                                    {/if}
                                </div>
                            {/block}
                        {/foreach}
                    </div>
                {/block}

                {block name="frontend_widgets_banner_slider_navigation"}
                        {* hotfix for dots *}
                        <div class="image-slider--dots">
                            {foreach $Data.banner_slider as $link}
                                <div class="dot--link">{$link@iteration}</div>
                            {/foreach}
                        </div>
                    {if $Data.banner_slider_numbers}
                        <div class="image-slider--dots">
                            {foreach $Data.values as $link}
                                <div class="dot--link">{$link@iteration}</div>
                            {/foreach}
                        </div>
                    {/if}
                {/block}
            </div>
        {/block}
        
        {if $Data.slider_category_1 || $Data.slider_category_2 || $Data.slider_category_3}
           {$categoryCount = 0}
           {if $Data.slider_category_1}
               {$categoryCount = $categoryCount + 1}
           {/if}
           {if $Data.slider_category_2}
               {$categoryCount = $categoryCount + 1}
           {/if}
           {if $Data.slider_category_3}
               {$categoryCount = $categoryCount + 1}
           {/if}
            <div class="gc-banner-slider-categories-box">
                <ul>
                   {if $Data.slider_category_1}
                    <li class="columns-count-{$categoryCount}">
                       <a href="{url controller=listing sCategory=$Data.slider_category_1}" class="gc-category-link">
                            <img src="{$Data.slider_category_1_icon}">
                            <p class=gc-category-title>
                               {if $Data.slider_category_1_title}
                                {$Data.slider_category_1_title}
                               {else}
                                {action module=widgets controller=GcCategoryController categoryId=$Data.slider_category_1}
                               {/if}
                            </p>
                        </a>
                    </li>
                   {/if}
                   {if $Data.slider_category_2}
                    <li class="columns-count-{$categoryCount}">
                       <a href="{url controller=listing sCategory=$Data.slider_category_2}" class="gc-category-link">
                            <img src="{$Data.slider_category_2_icon}">
                            <p class=gc-category-title>
                               {if $Data.slider_category_2_title}
                                {$Data.slider_category_2_title}
                               {else}
                                {action module=widgets controller=GcCategoryController categoryId=$Data.slider_category_2}
                               {/if}
                            </p>
                        </a>
                    </li>
                    {/if}
                    {if $Data.slider_category_3}
                    <li class="columns-count-{$categoryCount}">
                       <a href="{url controller=listing sCategory=$Data.slider_category_3}" class="gc-category-link">
                            <img src="{$Data.slider_category_3_icon}">
                            <p class=gc-category-title>
                               {if $Data.slider_category_3_title}
                                {$Data.slider_category_3_title}
                               {else}
                                {action module=widgets controller=GcCategoryController categoryId=$Data.slider_category_3}
                               {/if}
                            </p>
                        </a>
                    </li>
                    {/if}
                </ul>
            </div>
        {/if}
        
        
    </div>
{/block}