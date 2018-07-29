{namespace name="frontend/index/menu_footer"}

{* Service hotline *}
{block name="frontend_index_footer_column_service_hotline"}
{/block}

{block name="frontend_index_footer_column_newsletter"}
    <div class="footer--column column--newsletter is--first block">
        {block name="frontend_index_footer_column_newsletter_headline"}
            <div class="column--headline">
                <div class='newsletter--head'>
                    <div class='newsletter--icon'><img src="{media path='media/image/5ae9860dcfeaf9da5c1d0590_mail.png'}"></div>
                    <div class='newsletter--title'>{s name="sFooterNewsletterHead"}{/s}</div>
                </div>
            </div>
        {/block}

        {block name="frontend_index_footer_column_newsletter_content"}
            <div class="column--content">
                {block name="frontend_index_footer_column_newsletter_form"}
                    <form class="newsletter--form" action="{url controller='newsletter'}" method="post">
                        <input type="hidden" value="1" name="subscribeToNewsletter" />

                        {block name="frontend_index_footer_column_newsletter_form_field"}
                            <input type="email" name="newsletter" class="newsletter--field" placeholder="{s name="IndexFooterNewsletterValue"}{/s}" />
                            {if {config name="newsletterCaptcha"} !== "nocaptcha"}
                                <input type="hidden" name="redirect">
                            {/if}
                        {/block}

                        {block name="frontend_index_footer_column_newsletter_form_submit"}
                            <button type="submit" class="newsletter--button btn">
                                {s name='IndexFooterNewsletterSubmit'}{/s}
                            </button>
                        {/block}

                        {* Data protection information *}
                        {block name="frontend_index_footer_column_newsletter_privacy"}

                        {/block}
                    </form>
                {/block}
            </div>
        {/block}
    </div>
{/block}

{block name="frontend_index_footer_column_service_menu"}
    <div class="footer--column column--menu wav--column-menu block">
        {block name="frontend_index_footer_column_service_menu_headline"}
            <div class="column--headline">{s name="sFooterShopNavi1"}{/s}</div>
        {/block}

        {block name="frontend_index_footer_column_service_menu_content"}
            <nav class="column--navigation column--content">
                <ul class="navigation--list" role="menu">
                    {block name="frontend_index_footer_column_service_menu_before"}{/block}
                    {foreach $sMenu.gBottom as $item}

                        {block name="frontend_index_footer_column_service_menu_entry"}
                            <li class="navigation--entry" role="menuitem">
                                <a class="navigation--link" href="{if $item.link}{$item.link}{else}{url controller='custom' sCustom=$item.id title=$item.description}{/if}" title="{$item.description|escape}"{if $item.target} target="{$item.target}"{/if}>
                                    {$item.description}
                                </a>
                            </li>
                        {/block}
                    {/foreach}

                    {block name="frontend_index_footer_column_service_menu_after"}{/block}
                </ul>
            </nav>
        {/block}
    </div>
{/block}

{block name="frontend_index_footer_column_social_menu"}
    <div class="footer--column column--menu block">
        {block name="frontend_index_footer_column_social_headline"}
            <div class="column--headline">{s name="sFooterShopNaviSocial"}Social Networks{/s}</div>
        {/block}
        {block name="frontend_index_footer_column_social_content"}
            <nav class="column--navigation column--content">
                <ul class="navigation--list" role="menu">
                    {block name="frontend_index_footer_column_social_before"}{/block}
                        {foreach $sMenu.gBottom4 as $item}

                            {block name="frontend_index_footer_column_social_entry"}
                                <li class="navigation--entry" role="menuitem">
                                    <a class="navigation--link" href="{if $item.link}{$item.link}{else}{url controller='custom' sCustom=$item.id title=$item.description}{/if}" title="{$item.description|escape}"{if $item.target} target="{$item.target}"{/if}>
                                        {$item.description}
                                    </a>
                                </li>
                            {/block}
                        {/foreach}
                    {block name="frontend_index_footer_column_social_after"}{/block}
                </ul>
            </nav>
        {/block}
    </div>
{/block}

{block name="frontend_index_footer_column_information_menu"}
    <div class="footer--column column--menu is--informarion-menu block">
        {block name="frontend_index_footer_column_information_menu_headline"}
            <div class="column--headline">{s name="sFooterShopNavi2"}{/s}</div>
        {/block}
        {block name="frontend_index_footer_column_information_menu_content"}
            <nav class="column--navigation column--content">
                <ul class="navigation--list" role="menu">
                    {block name="frontend_index_footer_column_information_menu_before"}{/block}
                        {foreach $sMenu.gBottom2 as $item}

                            {block name="frontend_index_footer_column_information_menu_entry"}
                                <li class="navigation--entry" role="menuitem">
                                    <a class="navigation--link" href="{if $item.link}{$item.link}{else}{url controller='custom' sCustom=$item.id title=$item.description}{/if}" title="{$item.description|escape}"{if $item.target} target="{$item.target}"{/if}>
                                        <div class='wav--menu-icon'>{if $item.wavTitleIconPath}<img src='{media path=$item.wavTitleIconPath}'>{/if}</div><div class='wav--menu-text'>{$item.description}</div>
                                    </a>
                                </li>
                            {/block}
                        {/foreach}
                    {block name="frontend_index_footer_column_information_menu_after"}{/block}
                </ul>
            </nav>
        {/block}
    </div>
{/block}
