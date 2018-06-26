<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{link file="backend/_resources/css/bootstrap.min.css"}">
    <link rel="stylesheet" href="{link file="backend/_resources/css/bootstrap-theme.min.css"}">
    <link rel="stylesheet" href="{link file="backend/_resources/css/main.css"}">
    <link rel="stylesheet" href="{link file="backend/_resources/js/vendor/jquery.print.js"}">
</head>
<div class="container"  style="margin-top: 20px;">
	<a href="{url module=backend controller=ApcDelivery action=index}" class="btn btn-warning btn-xs">&lArr; Go back</a>
	<button id='printButton' class="btn btn-primary btn-xs">Print</button>
    <div id='printContent'>
        <h3>{$route.date}: {$route.name}</h3>
    	<table id="route" class="table table-bordered">
            <thead>
    			<tr>
    				<th>Bestellnummer</th>
    				<th>Kunde</th>
                    <th>Lieferadresse</th>
                    <th>Bezahlung</th>
    				<th>Produkt</th>
    				<th>Anzahl</th>
    			</tr>
    		</thead>
    		<tbody>
                {foreach $finalOrders as $orders}
        			{foreach $orders as $order}
        				<tr>
        					<td>{if $lstOrdernumber neq $order.ordernumber}{$order.ordernumber}{/if}</td>
        					<td>{if $lstOrdernumber neq $order.ordernumber}{$order.firstname}{$order.lastname}{/if}</td>
                            <td>{if $lstOrdernumber neq $order.ordernumber}{$order.street}, {$order.zipcode}, {$order.city}{/if}</td>
                            <td>{if $lstOrdernumber neq $order.ordernumber}{$order.payment}{/if}</td>
        					<td>{$order.product}</td>
        					<td>{$order.quantity}</td>
        				</tr>
                        {$lstOrdernumber = $order.ordernumber}
        			{/foreach}
                {/foreach}
    		</tbody>
    	</table>
    	<table id="total" class="table table-bordered">
    		<thead>
    			<tr>
    				<th>{s name='apcProductName'}Product{/s}</th>
    				<th>{s name='apcProductQuantity'}Quantity{/s}</th>
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
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="{link file="backend/_resources/js/main.js"}"></script>
