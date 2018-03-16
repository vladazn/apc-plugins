{extends file="parent:frontend/blog/images.tpl"}

{block name='frontend_blog_images_thumbnails'} {/block}

{block name='frontend_blog_images_main_image'}
    <div class="emotion--banner-slider image-slider"
         data-image-slider="true"
         data-thumbnails="true"
         data-lightbox="true"
         data-loopSlides="true"
         data-arrowControls="{$CcBlogExtendedPluginConfig.show_arrow_controls}"
         data-autoSlide="{$CcBlogExtendedPluginConfig.autoslide}"
         data-imageSelector=".image-slider--item">
        <div class="banner-slider--container image-slider--container">
            <div class="banner-slider--slide image-slider--slide">
                {foreach $sArticle.media as $sArticleMedia}
                    <div class="banner-slider--item image-slider--item"
                         data-coverImage="true"
                         data-containerSelector=".banner-slider--banner">
                        <div class="banner-slider--banner">
                            <img srcset="{$sArticleMedia.thumbnails[1].sourceSet}"
                                 class="blog--thumbnail-image"
                                 alt="{s name="BlogThumbnailText" namespace="frontend/blog/detail"}{/s}: {$alt}"
                                 title="{s name="BlogThumbnailText" namespace="frontend/blog/detail"}{/s}: {$alt|truncate:160}" />
                        </div>   
                    </div>          
                {/foreach}
            </div>
        </div>
    </div>
{/block}