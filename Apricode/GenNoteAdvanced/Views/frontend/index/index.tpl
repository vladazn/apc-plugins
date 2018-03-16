{extends file="parent:frontend/index/index.tpl"}

{block name="frontend_index_header_javascript_inline" append}
    controller['ajax_note'] = "{url controller=note isXHR=1}";
    var direction = "{$apcNoteAdvancedConfig->side}";
{/block}

{block name='frontend_index_container_ajax_cart' append}
    <div class="container--ajax-note has--cssanimations">
        <i class="icon--loading-indicator"></i>
    </div>
{/block}