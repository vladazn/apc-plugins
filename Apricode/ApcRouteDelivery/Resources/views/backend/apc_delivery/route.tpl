<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{link file="backend/_resources/css/bootstrap.min.css"}">
    <link rel="stylesheet" href="{link file="backend/_resources/css/bootstrap-theme.min.css"}">
    <link rel="stylesheet" href="{link file="backend/_resources/css/main.css"}">
</head>
<div class="container"  style="margin-top: 20px;">
	<a href="{url module=backend controller=ApcDelivery action=index}" class="btn btn-warning btn-xs">&lArr; Go back</a>
	<table id="route" class="table table-bordered">
		<thead>
			<tr>
				<th>Route name</th>
				<th>Delivery date</th>
				<th>New Date</th>
				<th>Details</th>
			</tr>
		</thead>
		<tbody>
			<form class="navbar-form navbar-left" method="post">
				<tr>
					<td>
						<div class="form-group" style="margin: 0;">
							<input type="text" class="form-control" value="{$route.name}" name="changes[name]">
						</div>
					</td>
					<td>{$route.old_date}</td>
					<td>
						<div class="form-group" style="margin: 0;">
                            <div class="form-group apc--dates">
                                <label>Date 1</label><input type="text" class="form-control" value="{$dates[0]}" name="changes[date][]">
                            </div>
                            <div class="form-group apc--dates">
                                <label>Date 2</label><input type="text" class="form-control" value="{$dates[1]}" name="changes[date][]">
                            </div>
                            <div class="form-group apc--dates">
                                <label>Date 3</label><input type="text" class="form-control" value="{$dates[2]}" name="changes[date][]">
                            </div>
                            <div class="form-group apc--dates">
                                <label>Date 4</label><input type="text" class="form-control" value="{$dates[3]}" name="changes[date][]">
                            </div>
                            <div class="form-group apc--dates">
                                <label>Date 5</label><input type="text" class="form-control" value="{$dates[4]}" name="changes[date][]">
                            </div>
                            <div class="form-group apc--dates">
                                <label>Date 6</label><input type="text" class="form-control" value="{$dates[5]}" name="changes[date][]">
                            </div>
						</div>
					</td>
					<td><button type="submit" class="btn btn-primary btn-block">Save changes</button></td>
				</tr>
			</form>
		</tbody>
	</table>
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
		<form method='post'>
			<button type="submit" class="btn btn-primary" style="margin-bottom: 20px;">Save route</button>
			{foreach $zip as $zipcode => $zipInfo}
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="heading{$zipcode}">
						<h4 class="panel-title">
							<input name="check" type="checkbox" id="check{$zipcode}" data-check="true">
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{$zipcode}" aria-expanded="true" aria-controls="collapse{$zipcode}">{$zipcode} &dArr;</a>
						</h4>
					</div>
					<div id="collapse{$zipcode}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{$zipcode}">
						<div class="panel-body">
								<table id="route" class="table table-bordered">
									<thead>
										<tr>
											<th>#</th>
											<th>ZIP</th>
											<th>Place</th>
											<th>State</th>
											<th>State Abbr</th>
											<th>City</th>
										</tr>
									</thead>
									<tbody>
										{foreach $zipInfo as $info}
											<tr data-all="true" class="check{$zipcode}">
												<td>
													<label class="checkbox-inline">
														<input type="checkbox" id="check{$info}" value="option{$info}" class="check{$zipcode}" {if $info.checked}checked="checked"{/if} name="zip[{$info.zip}]">
													</label>
												</td>
												<td>{$info.zip}</td>
												<td>{$info.place}</td>
												<td>{$info.state}</td>
												<td>{$info.state_abbr}</td>
												<td>{$info.city}</td>
											</tr>
										{/foreach}
									</tbody>
								</table>
						</div>
					</div>
				</div>
			{/foreach}
		</form>
	</div>
</div>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="{link file="backend/_resources/js/main.js"}"></script>
