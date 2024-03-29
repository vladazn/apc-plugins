{extends file='parent:frontend/detail/content.tpl'}

{block name="frontend_detail_index_configurator_settings" prepend}
<div class='detail--banner-topbar'>
    <div class='apc--weekday'>
        {$sArticle.sProperties[5]['value']}
    </div>
    <div class='detail--banner-social'>
        <a href='#' class='social--icon email' data-text='Share me via Email'>
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 27.857 27.857" style="enable-background:new 0 0 27.857 27.857;" xml:space="preserve">
                <g>
                    <g>
                        <path style="fill:#010002;" d="M2.203,5.331l10.034,7.948c0.455,0.36,1.082,0.52,1.691,0.49c0.608,0.03,1.235-0.129,1.69-0.49    l10.034-7.948c0.804-0.633,0.622-1.152-0.398-1.152H13.929H2.604C1.583,4.179,1.401,4.698,2.203,5.331z"/>
                        <path style="fill:#010002;" d="M26.377,7.428l-10.965,8.325c-0.41,0.308-0.947,0.458-1.482,0.451    c-0.536,0.007-1.073-0.144-1.483-0.451L1.48,7.428C0.666,6.811,0,7.142,0,8.163v13.659c0,1.021,0.836,1.857,1.857,1.857h12.071H26    c1.021,0,1.857-0.836,1.857-1.857V8.163C27.857,7.142,27.191,6.811,26.377,7.428z"/>
                    </g>
                </g>
            </svg>
        </a>
        <a href='#' class='social--icon facebook' data-text='Share me on Facebook'>
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 408.788 408.788" style="enable-background:new 0 0 408.788 408.788;" xml:space="preserve">
                <path style="fill:#475993;" d="M353.701,0H55.087C24.665,0,0.002,24.662,0.002,55.085v298.616c0,30.423,24.662,55.085,55.085,55.085  h147.275l0.251-146.078h-37.951c-4.932,0-8.935-3.988-8.954-8.92l-0.182-47.087c-0.019-4.959,3.996-8.989,8.955-8.989h37.882  v-45.498c0-52.8,32.247-81.55,79.348-81.55h38.65c4.945,0,8.955,4.009,8.955,8.955v39.704c0,4.944-4.007,8.952-8.95,8.955  l-23.719,0.011c-25.615,0-30.575,12.172-30.575,30.035v39.389h56.285c5.363,0,9.524,4.683,8.892,10.009l-5.581,47.087  c-0.534,4.506-4.355,7.901-8.892,7.901h-50.453l-0.251,146.078h87.631c30.422,0,55.084-24.662,55.084-55.084V55.085  C408.786,24.662,384.124,0,353.701,0z"/>
            </svg>
        </a>
        <a href='#' class='social--icon twitter' data-text='Share me on Twitter'>
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 410.155 410.155" style="enable-background:new 0 0 410.155 410.155;" xml:space="preserve">
                <path style="fill:#76A9EA;" d="M403.632,74.18c-9.113,4.041-18.573,7.229-28.28,9.537c10.696-10.164,18.738-22.877,23.275-37.067  l0,0c1.295-4.051-3.105-7.554-6.763-5.385l0,0c-13.504,8.01-28.05,14.019-43.235,17.862c-0.881,0.223-1.79,0.336-2.702,0.336  c-2.766,0-5.455-1.027-7.57-2.891c-16.156-14.239-36.935-22.081-58.508-22.081c-9.335,0-18.76,1.455-28.014,4.325  c-28.672,8.893-50.795,32.544-57.736,61.724c-2.604,10.945-3.309,21.9-2.097,32.56c0.139,1.225-0.44,2.08-0.797,2.481  c-0.627,0.703-1.516,1.106-2.439,1.106c-0.103,0-0.209-0.005-0.314-0.015c-62.762-5.831-119.358-36.068-159.363-85.14l0,0  c-2.04-2.503-5.952-2.196-7.578,0.593l0,0C13.677,65.565,9.537,80.937,9.537,96.579c0,23.972,9.631,46.563,26.36,63.032  c-7.035-1.668-13.844-4.295-20.169-7.808l0,0c-3.06-1.7-6.825,0.485-6.868,3.985l0,0c-0.438,35.612,20.412,67.3,51.646,81.569  c-0.629,0.015-1.258,0.022-1.888,0.022c-4.951,0-9.964-0.478-14.898-1.421l0,0c-3.446-0.658-6.341,2.611-5.271,5.952l0,0  c10.138,31.651,37.39,54.981,70.002,60.278c-27.066,18.169-58.585,27.753-91.39,27.753l-10.227-0.006  c-3.151,0-5.816,2.054-6.619,5.106c-0.791,3.006,0.666,6.177,3.353,7.74c36.966,21.513,79.131,32.883,121.955,32.883  c37.485,0,72.549-7.439,104.219-22.109c29.033-13.449,54.689-32.674,76.255-57.141c20.09-22.792,35.8-49.103,46.692-78.201  c10.383-27.737,15.871-57.333,15.871-85.589v-1.346c-0.001-4.537,2.051-8.806,5.631-11.712c13.585-11.03,25.415-24.014,35.16-38.591  l0,0C411.924,77.126,407.866,72.302,403.632,74.18L403.632,74.18z"/>
            </svg>
        </a>
        <a href='#' class='social--icon googleplus' data-text='Share me on Google+'>
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                     viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                <circle style="fill:#CF4C3C;" cx="256" cy="256" r="256"/>
                <path style="fill:#AD3228;" d="M372.97,215.509l-36.521,43.939l-68.763-71.518h-95.008l-38.453,41.637v89.912L318.85,504.217
                    c83.594-21.102,150.816-83.318,178.916-163.887L372.97,215.509z"/>
                <path style="fill:#FFFFFF;" d="M212.289,275.344h45.789c-8.037,22.721-29.806,39.012-55.287,38.826
                    c-30.92-0.228-56.491-24.964-57.689-55.863c-1.286-33.12,25.285-60.478,58.123-60.478c15.017,0,28.72,5.723,39.05,15.098
                    c2.448,2.22,6.17,2.236,8.578-0.031l16.818-15.825c2.631-2.476,2.639-6.658,0.016-9.14c-16.382-15.524-38.359-25.198-62.595-25.669
                    c-51.69-1.012-95.261,41.37-95.62,93.07c-0.365,52.09,41.75,94.429,93.753,94.429c50.014,0,90.869-39.159,93.605-88.485
                    c0.072-0.619,0.121-21.52,0.121-21.52H212.29c-3.47,0-6.282,2.813-6.282,6.282v23.024
                    C206.007,272.531,208.82,275.344,212.289,275.344L212.289,275.344z"/>
                <path style="fill:#D1D1D1;" d="M374.531,241.847V219.35c0-3.041-2.463-5.504-5.504-5.504h-18.934c-3.041,0-5.506,2.463-5.506,5.504
                    v22.497h-22.492c-3.041,0-5.51,2.463-5.51,5.506v18.932c0,3.039,2.467,5.506,5.51,5.506h22.492v22.494
                    c0,3.041,2.463,5.506,5.506,5.506h18.934c3.041,0,5.504-2.465,5.504-5.506v-22.494h22.497c3.039,0,5.506-2.467,5.506-5.506v-18.932
                    c0-3.041-2.467-5.506-5.506-5.506H374.531z"/>
            </svg>
        </a>
        <a href='#' class='social--icon pinterest' data-text='Share me on Pinterest'>
            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                     viewBox="0 0 112.198 112.198" style="enable-background:new 0 0 112.198 112.198;" xml:space="preserve">
                <g>
                    <circle style="fill:#CB2027;" cx="56.099" cy="56.1" r="56.098"/>
                    <g>
                        <path style="fill:#F1F2F2;" d="M60.627,75.122c-4.241-0.328-6.023-2.431-9.349-4.45c-1.828,9.591-4.062,18.785-10.679,23.588
                            c-2.045-14.496,2.998-25.384,5.34-36.941c-3.992-6.72,0.48-20.246,8.9-16.913c10.363,4.098-8.972,24.987,4.008,27.596
                            c13.551,2.724,19.083-23.513,10.679-32.047c-12.142-12.321-35.343-0.28-32.49,17.358c0.695,4.312,5.151,5.621,1.78,11.571
                            c-7.771-1.721-10.089-7.85-9.791-16.021c0.481-13.375,12.018-22.74,23.59-24.036c14.635-1.638,28.371,5.374,30.267,19.14
                            C85.015,59.504,76.275,76.33,60.627,75.122L60.627,75.122z"/>
                    </g>
                </g>
            </svg>

        </a>
    </div>
</div>
{/block}

{block name="frontend_detail_index_image_container"}
<div class="apc--product-description" itemprop="description">
   {$sArticle.description_long}
</div>
{/block}


{block name="frontend_detail_index_bundle" prepend}
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
