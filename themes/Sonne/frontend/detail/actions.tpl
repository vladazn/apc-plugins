{extends file='parent:frontend/detail/actions.tpl'}

{block name='frontend_detail_actions_notepad'}
    <form action="{url controller='note' action='add' ordernumber=$sArticle.ordernumber}" method="post" class="action--form">
        <button type="submit"
           class="action--link link--notepad"
           title="{"{s name='DetailLinkNotepad'}{/s}"|escape}"
           data-ajaxUrl="{url controller='note' action='ajaxAdd' ordernumber=$sArticle.ordernumber}"
           data-text="{s name="DetailNotepadMarked"}{/s}">
           <img src='{media path="media/image/wishlist_icon.png"}'></img><span class="action--text">{s name="DetailLinkNotepadShortWav"}Add to my Wishlist{/s}</span>
        </button>
    </form>
{/block}
