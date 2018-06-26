<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/custom/plugins/ApcRouteDelivery/Resources/views/backend/_resources/css/bootstrap.min.css">
    <link rel="stylesheet" href="/custom/plugins/ApcRouteDelivery/Resources/views/backend/_resources/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/custom/plugins/ApcRouteDelivery/Resources/views/backend/_resources/css/main.css">
</head>
<div class="container"  style="margin-top: 20px;">
    <div id='printContent'>
        <h3>{$route.date}: {$route.name}</h3>
    	<table id="route" class="table table-bordered">
    		<thead>
    			<tr>
    				<th>Nr.</th>
                    <th>Lieferadresse</th>
                    <th>Kunde</th>
                    <th>Bezahlung</th>
    			</tr>
    		</thead>
    		<tbody>
                {foreach $finalOrders as $orders}
        			{foreach $orders as $order}
                        {if $lstOrdernumber neq $order.ordernumber}
                        <tr>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td>{$order.street}, {$order.zipcode}, {$order.city}</td>
                            <td>{$order.firstname}{$order.lastname}</td>
                            <td>{$order.payment}</td>
                        </tr>
                        {/if}
                        {$lstOrdernumber = $order.ordernumber}
        			{/foreach}
                {/foreach}
    		</tbody>
    	</table>
        <pagebreak />
        <span class='page--break'></span>
    	<table id="total" class="table table-bordered">
    		<thead>
    			<tr>
    				<th>Produkt</th>
    				<th>Anzahl</th>
    			</tr>
    		</thead>
    		<tbody>
    			{foreach $totals as $product => $quantity}
    				<tr>
    					<td>{$product}</td>
    					<td>{$quantity}</td>
    				</tr>
    			{/foreach}
    		</tbody>
    	</table>
    </div>
</div>
