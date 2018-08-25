<div class='niceselect--container nice--select-field select-field'>
    <select name="group[{$config.groupID}]"{if $theme.ajaxVariantSwitch} data-ajax-select-variants="true"{else} data-auto-submit="true"{/if}
    {if $isNiceselect}
    data-no-fancy-select="true"
    data-nice-select="true"
    {/if}
    >
        {$disabledSelected=false}
        {foreach $config.values as $configValue}
            {if $configValue.attributes.core}
                {$disabled = $configValue.attributes.core->get("is_disabled")}
            {else}
                {$disabled=false}
            {/if}
            {if !{config name=hideNoInstock} || ({config name=hideNoInstock} && $configValue.selectable)}
                <option
                {if $disabled} disabled {/if}
                {if !$configValue.selectable}disabled="disabled"{/if}
                {if $preselected}
                  {if $configValue.selected} selected {/if}
                {else}
                    {if ($disabled && !$config.customer_selected) ||($disabled && $selectDisabled)} selected {$disabledSelected=true}{/if}
                    {if $configValue.optionID eq $config.customer_selected && !$disabledSelected} selected {/if}
                {/if}
                {if $configValue.selected} selected="selected"{/if} {if !$disabled}value="{$configValue.optionID}"{/if}
                {if $isNiceselect}
                {$color = $configValue.attributes.core->get('apc_option_color')}
                data-content="{strip}
                               {if $configValue.attributes.core->get('apc_option_color')}
                                   <span class='option--color' style='background: {$color} ;'></span>
                               {/if}<span class='option--text'>{$configValue.optionname}</span>{/strip}"
                {/if}
                >
                    {$configValue.optionname}{if $configValue.upprice} {if $configValue.upprice > 0}{/if}{/if}
                </option>
            {/if}
        {/foreach}
    </select>
</div>
