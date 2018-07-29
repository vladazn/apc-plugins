    {if {config name="compareShow"}}
        <form action="{url controller='compare' action='add_article' articleID=$sArticle.articleID}" method="post" class="action--form">
            <button type="submit" data-product-compare-add="true" title="{"{s name='DetailActionLinkCompare'}{/s}"|escape}" class="action--link action--compare">
                <i class="icon--compare"></i>
            </button>
        </form>
    {/if}

    <form action="{url controller='note' action='add' ordernumber=$sArticle.ordernumber}" method="post" class="action--form">
        <button type="submit"
           class="action--link link--notepad"
           title="{"{s name='DetailLinkNotepad'}{/s}"|escape}"
           data-ajaxUrl="{url controller='note' action='ajaxAdd' ordernumber=$sArticle.ordernumber}"
           data-text="{s name="DetailNotepadMarked"}{/s}">
            <i class="icon--heart"></i>
        </button>
    </form>

    {if !{config name=VoteDisable}}
        <a href="#content--product-reviews" data-show-tab="true" class="action--link link--publish-comment" rel="nofollow" title="{"{s name='DetailLinkReview'}{/s}"|escape}">
            <i class="icon--star"></i>
        </a>
    {/if}
