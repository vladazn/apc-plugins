{extends file="parent:frontend/detail/tabs/description.tpl"}

{block name='frontend_detail_description_title'}
    <div class="content--title">
        {$sArticle.articleName}
    </div>
    <div class="product--description">
        {$sArticle.apc_subtitle}
    </div>
{/block}

{block name='frontend_detail_description_properties'}
    {if $sArticle.sProperties}
        <div class="product--properties panel apc--table">
            <table class="product--properties-table">
                {foreach $sArticle.sProperties as $sProperty}
                    {if !$sProperty.id|in_array:[6,7]}
                        {continue}
                    {/if}
                    <tr class="product--properties-row">
                        {* Property label *}
                        {block name='frontend_detail_description_properties_label'}
                            <td class="product--properties-label is--bold">{$sProperty.name|escape}:</td>
                        {/block}

                        {* Property content *}
                        {block name='frontend_detail_description_properties_content'}
                            {if $sProperty.id == 7}
                                {foreach $sProperty.options as $propertyOption}
                                    {$allergyName = $propertyOption.attributes.core->toArray()}
                                    {append 'allergyValues' $allergyName.apc_property_long}
                                {/foreach}
                                <td class="product--properties-value">{', '|implode:$allergyValues}</td>
                            {else}
                                <td class="product--properties-value">{$sProperty.value|escape}</td>
                            {/if}
                        {/block}
                    </tr>
                {/foreach}
            </table>
        </div>
    {/if}
{/block}
