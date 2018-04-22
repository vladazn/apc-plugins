<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{link file="backend/_resources/css/bootstrap.min.css"}">
    <link rel="stylesheet" href="{link file="backend/_resources/css/bootstrap-theme.min.css"}">
    <link rel="stylesheet" href="{link file="backend/_resources/css/main.css"}">
</head>
<div class="container">
	<table id="routes" class="table table-hover table-striped table-bordered" style="margin-bottom: 20px;">
		<thead>
			<tr>
				<th colspan="4" class="text-center success"><h4>Active routes</h4></th>
			</tr>
			<tr>
				<th scope="row">Active</th>
				<th>Last Delivery</th>
				<th>Next Delivery</th>
				<th>Details</th>
			</tr>
		</thead>
		{if $activeRoutes}
			<tbody>
				{foreach $activeRoutes as $active}
					<tr>
						<td scope="row">{$active.name}</td>
						<td>{$active.old_date}</td>
						<td>{$active.new_date}</td>
						<td>
							<a class="btn btn-default btn-xs" href='{url module=backend controller=ApcDelivery action=route routeId={$active.id}}'>View</a>
							<a class="btn btn-default btn-xs btn-danger" href='{url module=backend controller=ApcDelivery action=index deactivate={$active.id}}'>Deactivate</a>
							<a class="btn btn-default btn-xs btn-info" href='{url module=backend controller=ApcDelivery action=orders routeId={$active.id}}'>See orders</a>
						</td>
					</tr>
				{/foreach}
			</tbody>
		{/if}
		<thead>
			<tr>
				<th colspan="4" class="text-center danger"><h4>Inactive routes</h4></th>
			</tr>
			<tr>
				<th scope="row">Deactive</th>
				<th>Old Date</th>
				<th>New Date</th>
				<th>Details / Activate</th>
			</tr>
		</thead>
		<tbody>
			{if $inactiveRoutes}
				{foreach $inactiveRoutes as $inactive}
					<tr>
						<td scope="row">{$inactive.name}</td>
						<td>{$inactive.old_date}</td>
						<td>{$inactive.new_date}</td>
						<td>
							<a class="btn btn-default btn-xs" href='{url module=backend controller=ApcDelivery action=route routeId={$inactive.id}}'>View</a>
							<a class="btn btn-default btn-xs btn-success" href='{url module=backend controller=ApcDelivery action=index activate={$inactive.id}}'>Activate</a>
						</td>
					</tr>
				{/foreach}
			{/if}
			<tr>
				<td colspan="4" class="text-right"></td>
			</tr>
		</tbody>
	</table>
    <form method="post">
	<table id="addRoute" class="table table-bordered">
		<thead>
			<tr>
				<th colspan="4" class="text-center active"><h4>Add route</h4></th>
			</tr>
			<tr>
				<th>Route Name</th>
				<th>Delivery Date</th>
				<th>Save Route</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><input type="text" class="form-control" placeholder="Route Name" name="newroute[name]"></td>
				<td><input type="text" class="form-control" placeholder="Delivery Date" name="newroute[deliveryDate]"></td>
				<td><input type="submit" class="btn btn-default btn-success btn-block" value='Save'></td>
			</tr>
		</tbody>
	</table>
    </form>
</div>
