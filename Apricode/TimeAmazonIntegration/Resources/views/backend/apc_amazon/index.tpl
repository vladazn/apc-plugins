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
				<th scope="row">ID</th>
				<th>Title</th>
				<th>Actions</th>
			</tr>
		</thead>
			<tbody>
				{foreach $users as $user}
					<tr>
						<td scope="row">{$user.id}</td>
						<td>{$user.title}</td>
						<td>
							<a class="btn btn-default btn-xs" href='{url module=backend controller=ApcAmazon action=user id={$user.id}}'>View</a>
							<a class="btn btn-default btn-xs btn-danger" href='{url module=backend controller=ApcAmazon action=index remove={$user.id}}'>Remove</a>
						</td>
					</tr>
				{/foreach}
			</tbody>
	</table>
    <form method="post">
	<table id="addRoute" class="table table-bordered">
		<thead>
			<tr>
				<th colspan="4" class="text-center active"><h4>Add user</h4></th>
			</tr>
			<tr>
				<th>Title</th><td><input type="text" class="form-control" required name="create[title]"></td>
			</tr>
            <tr>
                <th>aws key</th><td><input type="text" class="form-control" required name="create[aws_key]"></td>
            </tr>
            <tr>
                <th>secret key</th><td><input type="text" class="form-control" required name="create[secret_key]"></td>
            </tr>
            <tr>
                <th>MWSAuthToken</th><td><input type="text" class="form-control" required name="create[mws_auth_token]"></td>
            </tr>
            <tr>
                <th>seller ID</th><td><input type="text" class="form-control" required name="create[seller_id]"></td>
            </tr>
            <tr>
                <th>tax Rate</th><td><input type="text" class="form-control" required name="create[tax_rate]"></td>
            </tr>
            <tr>
                <th>Marketplaces (America) </th>
                <td>
                    <div class='marketplaces'>
                        <div class='marketplace--single'>
                            <input type="checkbox" value="A2EUQ1WTGCTBG2" id="A2EUQ1WTGCTBG2" name="create[marketpalce_na][]"><label for="A2EUQ1WTGCTBG2"> CA </label>
                        </div>
                        <div class='marketplace--single'>
                            <input type="checkbox" value="ATVPDKIKX0DER" id="ATVPDKIKX0DER" name="create[marketpalce_na][]"><label for="ATVPDKIKX0DER"> US </label>
                        </div>
                        <div class='marketplace--single'>
                            <input type="checkbox" value="A1AM78C64UM0Y8" id="A1AM78C64UM0Y8" name="create[marketpalce_na][]"><label for="A1AM78C64UM0Y8"> MX </label>
                        </div>
                        <div class='marketplace--single'>
                            <input type="checkbox" value="A2Q3Y263D00KWC" id="A2Q3Y263D00KWC" name="create[marketpalce_na][]"><label for="A2Q3Y263D00KWC"> BR </label>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th>Marketplaces (Europe) </th>
                <td>
                    <div class='marketplaces'>
                        <div class='marketplace--single'>
                            <input type="checkbox" value="A1RKKUPIHCS9HS" id="A1RKKUPIHCS9HS" name="create[marketpalce_eu][]"><label for="A1RKKUPIHCS9HS"> ES </label>
                        </div>
                        <div class='marketplace--single'>
                            <input type="checkbox" value="A1F83G8C2ARO7P" id="A1F83G8C2ARO7P" name="create[marketpalce_eu][]"><label for="A1F83G8C2ARO7P"> UK </label>
                        </div>
                        <div class='marketplace--single'>
                            <input type="checkbox" value="A13V1IB3VIYZZH" id="A13V1IB3VIYZZH" name="create[marketpalce_eu][]"><label for="A13V1IB3VIYZZH"> FR </label>
                        </div>
                        <div class='marketplace--single'>
                            <input type="checkbox" value="A1PA6795UKMFR9" id="A1PA6795UKMFR9" name="create[marketpalce_eu][]"><label for="A1PA6795UKMFR9"> DE </label>
                        </div>
                        <div class='marketplace--single'>
                            <input type="checkbox" value="APJ6JRA9NG5V4" id="APJ6JRA9NG5V4" name="create[marketpalce_eu][]"><label for="APJ6JRA9NG5V4"> IT </label>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th>Marketplaces (India) </th>
                <td>
                    <div class='marketplaces'>
                        <div class='marketplace--single'>
                            <input type="checkbox" value="A21TJRUUN4KGV" id="A21TJRUUN4KGV" name="create[marketpalce_in][]"><label for="A21TJRUUN4KGV"> IN </label>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th>Marketplaces (China) </th>
                <td>
                    <div class='marketplaces'>
                        <div class='marketplace--single'>
                            <input type="checkbox" value="AAHKV2X7AFYLW" id="AAHKV2X7AFYLW" name="create[marketpalce_cn][]"><label for="AAHKV2X7AFYLW"> CN </label>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th>Marketplaces (Japan) </th>
                <td>
                    <div class='marketplaces'>
                        <div class='marketplace--single'>
                            <input type="checkbox" value="A1VC38T7YXB528" id="A1VC38T7YXB528" name="create[marketpalce_jp][]"><label for="A1VC38T7YXB528"> JP </label>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th>Marketplaces (Australia) </th>
                <td>
                    <div class='marketplaces'>
                        <div class='marketplace--single'>
                            <input type="checkbox" value="A39IBJ37TRP1C6" id="A39IBJ37TRP1C6" name="create[marketpalce_au][]"><label for="A39IBJ37TRP1C6"> AU </label>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th>Shop</th>
                <td>
                    <select class="form-control" name="create[shop_id]">
                        {foreach $shops as $shop}
                        <option value="{$shop.id}">{$shop.name}</option>
                        {/foreach}
                    </select>
                </td>
            </tr>
            <tr>
                <th>Default Shipping method</th>
                <td>
                    <select class="form-control" name="create[custom_shipping]">
                        {foreach $shippings as $shipping}
                            <option value="{$shipping.id}">{$shipping.name}</option>
                        {/foreach}
                    </select>
                </td>
            </tr>
		</thead>
		<tbody>
			<tr>
				<td></td>
				<td><input type="submit" class="btn btn-default btn-success btn-block" value='Save'></td>
			</tr>
		</tbody>
	</table>
    </form>
</div>
