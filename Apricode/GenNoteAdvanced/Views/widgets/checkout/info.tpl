{extends file='parent:widgets/checkout/info.tpl'}

{* Notepad entry *}
{block name="frontend_index_checkout_actions_notepad"}
    {literal}
        <style>
            @keyframes ApcBeatHeart {
                0% {
                    transform: scale(1);
                    color: {/literal}{$apcNoteAdvancedConfig->color1}{literal};
                }
                25% {
                    transform: scale(1.1);
                    color: {/literal}{$apcNoteAdvancedConfig->color2}{literal};
                }
                40% {
                    transform: scale(1);
                    color: {/literal}{$apcNoteAdvancedConfig->color3}{literal};
                }
                60% {
                    transform: scale(1.1);
                    color: {/literal}{$apcNoteAdvancedConfig->color1}{literal};
                }
                100% {
                    transform: scale(1);
                    color: {/literal}{$apcNoteAdvancedConfig->color1}{literal};
                }
            }
        </style>
    {/literal}
   
    <li class="navigation--entry entry--notepad" role="menuitem">
        <a href="{url controller='note'}" title="{"{s namespace='frontend/index/checkout_actions' name='IndexLinkNotepad'}{/s}"|escape}" class="btn">
           <i class="icon--heart {if $apcNoteAdvancedConfig->show} apc-heart {/if}"></i>
            {if $sNotesQuantity > 0}
                <span class="badge notes--quantity">
                    {$sNotesQuantity}
                </span>
            {/if}
        </a>
    </li>
{/block}