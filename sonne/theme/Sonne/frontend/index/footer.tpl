{extends file="parent:frontend/index/footer.tpl"}

{block name='frontend_index_footer_copyright'}
<div class="footer--bottom">
    <div class='footer--copyright-text'>{s name='wavFooterCopyrightText'}* Alle Preise inkl. gesetzl. Mehrwertsteuer zzgl. Versandkosten und ggf. Nachnahmegebühren, wenn nicht anders beschrieben.{/s}</div>
    <div class='footer--payment-methods'>
        <div class='payment--method'>
            <img src="{media path='media/image/5ae314430d748015a813fd07_card1.jpg'}">
        </div>
        <div class='payment--method'>
            <img src="{media path='media/image/5ae314430d74809c9e13fd08_card2.jpg'}">
        </div>
        <div class='payment--method'>
            <img src="{media path='media/image/5ae314438cb753e37010ead1_card3.jpg'}">
        </div>
        <div class='payment--method'>
            <img src="{media path='media/image/5ae314438cb753650110ead2_card4.jpg'}">
        </div>
        <div class='payment--method'>
            <img src="{media path='media/image/5ae314468cb7537a4b10ead3_card5.jpg'}">
        </div>
    </div>
</div>
{/block}
