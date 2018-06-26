<div class="apc--location">
    <h1 class="apc-hendline">{s name='ApcLiefertermine' namespace='frontned/custom/table'}Liefergebiet/Liefertermine{/s} </h1>
    <img src="{$imagePath}" alt="">
</div>
<h1 class="apc--delivery-dats custom-page--tab-headline">{s name='ApcDeliverydats' namespace='frontned/custom/table'}Delivery Dates{/s}</h1>
<table id="route" class="table table-bordered">
    <tbody>
        {foreach $deliveries as $delivery}
            <tr>
                <td>
                    {$weeks[$delivery.date|date_format:'%u']}
                </td>
                <td>{$delivery.date|date_format:'%d'}. {$months[$delivery.date|date_format:'%m'|intval]}</td>
                <td>{$delivery.name}</td>
                {*}
                <td>
                    <span class='btn btn-primary apc--showmap'>{s name='ApcMapButton' namespace='frontned/custom/table'}Show Map{/s}</span>
                </td>
                {*}
            </tr>
            {*}
            <tr class='is--hidden apcMap'>
                <td colspan="4">
                    <iframe
                        width="100%"
                        height="350px"
                        frameborder="0" style="border:0"
                        src="{$delivery.mapLink}">
                    </iframe>
                </td>
            </tr>
            {*}
        {/foreach}
    </tbody>
</table>
