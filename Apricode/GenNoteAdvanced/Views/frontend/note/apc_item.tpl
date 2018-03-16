<div class="note--item panel--tr">
    {if $sBasketItem.sConfigurator}
        {$detailLink={url controller="detail" sArticle=$sBasketItem.articleID number=$sBasketItem.ordernumber}}
    {else}
        {$detailLink=$sBasketItem.linkDetails}
    {/if}
    {* Article information *}
    <div class="note--info panel--td">
        {* Article picture *}
        <div class="note--image-container">
            {$desc = $sBasketItem.articlename|escape}
            {if $sBasketItem.image.thumbnails[0]}
                {if $sBasketItem.image.description}
                    {$desc = $sBasketItem.image.description|escape}
                {/if}
                <a href="{$detailLink}" title="{$sBasketItem.articlename|escape}" class="note--image-link">
                    <img srcset="{$sBasketItem.image.thumbnails[0].sourceSet}" alt="{$desc}" title="{$desc|truncate:160}" class="note--image" />
                </a>
            {else}
                <a href="{$detailLink}" title="{$sBasketItem.articlename|escape}" class="note--image-link">
                    <img src="{link file='frontend/_public/src/img/no-picture.jpg'}" alt="{$desc}" title="{$desc|truncate:160}" class="note--image" />
                </a>
            {/if}
        </div>
        {* Article details *}
        <div class="note--details">
            {* Article name *}
            <a class="note--title" href="{$detailLink}" title="{$sBasketItem.articlename|escape}">
                {$sBasketItem.articlename|truncate:30}
            </a>
            {* item price *}
            <div class="note--price">
                {if $sBasketItem.itemInfo}
                    {$sBasketItem.itemInfo}
                {else}
                    <div class="note--price">{if $sBasketItem.priceStartingFrom}{s namespace='frontend/listing/box_article' name='ListingBoxArticleStartsAt'}{/s} {/if}{$sBasketItem.price|currency}*</div>
                {/if}
            </div>
        </div>
        {if $apcNoteAdvancedConfig->show_remove}
            {* Remove article *}
            <form action="{url controller='note' action='delete' sDelete=$sBasketItem.id}" method="post">
                <button type="submit" title="{"{s namespace='frontend/note/item' name='NoteLinkDelete'}{/s}"|escape}" class="note--delete">
                    <i class="icon--cross"></i>
                </button>
            </form>
        {/if}
    </div>
</div>