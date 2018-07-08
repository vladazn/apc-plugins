
{block name='frontend_index_content'}
    <div class="forms--content content right">

        {* Forms Content *}
        {block name='frontend_forms_index_content'}
            {if $sSupport.sElements}
                <div class="forms--container panel has--border is--rounded">
                    <div class="panel--title is--underline">{$sSupport.name}</div>
                    <div class="panel--body">
                        {block name='frontend_forms_index_form_elements'}
                            {include file="frontend/forms/form-elements.tpl"}
                        {/block}
                    </div>
                </div>
            {/if}
        {/block}

    </div>
{/block}
