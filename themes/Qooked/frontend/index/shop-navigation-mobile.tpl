<nav class="shop--navigation block-group">
    <div class="navigation--list block-group" role="menubar">

        {* Menu (Off canvas left) trigger *}
            <div class="navigation--entry entry--menu-left" role="menuitem">
                <a class="entry--link entry--trigger btn is--icon-left" href="#offcanvas--left" data-offcanvas="true" data-offCanvasSelector=".sidebar-main">
                    <i class="icon--menu"></i>
                </a>
            </div>

        {* Search form *}
            <div class="navigation--entry entry--logo-mobile">
                    {include file="frontend/index/logo-container.tpl"}
            </div>

        {* Cart entry *}
        <div class="navigation--entry entry--menu-right">
            <ul class="navigation--mobile">
                {action module=widgets controller=checkout action=info}
            </ul>
        </div>
    </div>
</nav>
