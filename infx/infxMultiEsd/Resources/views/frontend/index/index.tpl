{extends file='parent:frontend/index/index.tpl'}

{block name="frontend_index_header_javascript_inline" prepend}
    var infxModalAction = "{url controller='InfxDownload' action='modal'}";
{/block}
