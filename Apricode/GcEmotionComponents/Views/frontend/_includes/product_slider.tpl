{extends file="parent:frontend/_includes/product_slider.tpl"}

{block name="frontend_common_product_slider_component" prepend}
    {if ($additionalClass=='gc-product-slider-3' || $additionalClass=='gc-product-slider-4')}
        {$sliderAjaxCtrlUrl = $sliderAjaxCtrlUrl|cat:"/gcSlider/"|cat:true}
    {/if}
{/block}

{block name="frontend_common_product_slider_container"}
    <div class="product-slider--container" data-ajax-wishlist="true">
        {include file="frontend/_includes/product_slider_items.tpl" articles=$articles additionalClass=$additionalClass}
    </div>
{/block}