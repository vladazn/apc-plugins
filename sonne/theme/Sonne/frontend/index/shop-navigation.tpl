{extends file="parent:frontend/index/shop-navigation.tpl"}

{block name='frontend_index_search'}
    <li class='navigation--entry entry--search wav--header-menu'>
        <a href="{url controller='account'}" class='wmenu--item'>{s name='HeaderSmallMenuAccount'}Mein Konto{/s}</a>
        <a href="{url controller='note'}" class='wmenu--item'>{s name='HeaderSmallMenuWhishlist'}Merkzettel{/s}</a>
        <a href="{url controller=custom sCustom=59}" class='wmenu--item'>{s name='HeaderSmallMenuService'}Service/Hilfe{/s}</a>
        <a href="#" class='wmenu--item'>{s name='HeaderSmallMenuLastLink'}Last Link{/s}</a>
    </li>
    <li class='navigation--entry entry--search wav--header-menu-mobile'>
        <div class='wmenu--trigger'><i class="icon--menu"></i></div>
        <div class='wmenu--list-container'>
            <div class='wmenu--list'>
                <a href="{url controller='account'}" class='wmenu--item'>{s name='HeaderSmallMenuAccount'}Mein Konto{/s}</a>
                <a href="{url controller='note'}" class='wmenu--item'>{s name='HeaderSmallMenuWhishlist'}Merkzettel{/s}</a>
                <a href="{url controller=custom sCustom=59}" class='wmenu--item'>{s name='HeaderSmallMenuService'}Service/Hilfe{/s}</a>
                <a href="#" class='wmenu--item'>{s name='HeaderSmallMenuLastLink'}Last Link{/s}</a>
            </div>
        </div>
    </li>
{/block}

{block name='frontend_index_offcanvas_left_trigger'}
{*}
    <li class="navigation--entry entry--menu-left" role="menuitem">
        <a class="entry--link entry--trigger btn is--icon-left" href="#offcanvas--left" data-offcanvas="true" data-offCanvasSelector=".sidebar-main">
            <i class="icon--menu"></i> {s namespace='frontend/index/menu_left' name="IndexLinkMenu"}{/s}
        </a>
    </li>
{*}
{/block}
