<div class="apc--location">
    <h1 class="apc-hendline">{s name='ApcLiefertermine' namespace='Rescources/views/frontned/cpstom/table'}Liefergebiet/Liefertermine{/s} </h1>
    <img src="{$imagePath}" alt="">
</div>
<h1 class="apc--delivery-dats custom-page--tab-headline">{s name='ApcDeliverydats' namespace='Rescources/views/frontned/cpstom/table'}Delivery Dates{/s}</h1>
<table id="route" class="table table-bordered">
    <tbody>
        {foreach $deliveries as $delivery}
            <tr>
                <td>
                    {$weeks[$delivery.date|date_format:'%u']}
                </td>
                <td>{$delivery.date|date_format:'%d'}. {$months[$delivery.date|date_format:'%l']}</td>
                <td>{$delivery.name}</td>
            </tr>
        {/foreach}
    </tbody>
</table>
