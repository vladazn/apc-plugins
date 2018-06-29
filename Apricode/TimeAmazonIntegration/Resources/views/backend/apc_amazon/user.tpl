<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{link file="backend/_resources/css/bootstrap.min.css"}">
    <link rel="stylesheet" href="{link file="backend/_resources/css/bootstrap-theme.min.css"}">
    <link rel="stylesheet" href="{link file="backend/_resources/css/main.css"}">
</head>
<div class="container"  style="margin-top: 20px;">
	<a href="{url module=backend controller=ApcAmazon action=index}" class="btn btn-warning btn-xs">&lArr; Go back</a>
    <form method="post">
    	<table id="addRoute" class="table table-bordered">
    		<thead>
    			<tr>
    				<th>Title</th><td><input type="text" class="form-control" required value="{$user.title}" name="update[title]"></td>
    			</tr>
                <tr>
                    <th>aws key</th><td><input type="text" class="form-control" required value="{$user.aws_key}" name="update[aws_key]"></td>
                </tr>
                <tr>
                    <th>secret key</th><td><input type="text" class="form-control" required value="{$user.secret_key}" name="update[secret_key]"></td>
                </tr>
                <tr>
                    <th>MWSAuthToken</th><td><input type="text" class="form-control" required value="{$user.mws_auth_token}" name="update[mws_auth_token]"></td>
                </tr>
                <tr>
                    <th>seller ID</th><td><input type="text" class="form-control" required value="{$user.seller_id}" name="update[seller_id]"></td>
                </tr>
                <tr>
                    <th>tax Rate</th><td><input type="text" class="form-control" required value="{$user.tax_rate}" name="update[tax_rate]"></td>
                </tr>
                <tr>
                    <th>Marketplaces (America) </th>
                    <td>
                        <div class='marketplaces'>
                            <div class='marketplace--single'>
                                <input type="checkbox" value="A2EUQ1WTGCTBG2" {if 'A2EUQ1WTGCTBG2'|in_array:$user.marketpalce_na}checked{/if} id="A2EUQ1WTGCTBG2" name="update[marketpalce_na][]"><label for="A2EUQ1WTGCTBG2"> CA </label>
                            </div>
                            <div class='marketplace--single'>
                                <input type="checkbox" value="ATVPDKIKX0DER" {if 'ATVPDKIKX0DER'|in_array:$user.marketpalce_na}checked{/if} id="ATVPDKIKX0DER" name="update[marketpalce_na][]"><label for="ATVPDKIKX0DER"> US </label>
                            </div>
                            <div class='marketplace--single'>
                                <input type="checkbox" value="A1AM78C64UM0Y8" {if 'A1AM78C64UM0Y8'|in_array:$user.marketpalce_na}checked{/if} id="A1AM78C64UM0Y8" name="update[marketpalce_na][]"><label for="A1AM78C64UM0Y8"> MX </label>
                            </div>
                            <div class='marketplace--single'>
                                <input type="checkbox" value="A2Q3Y263D00KWC" {if 'A2Q3Y263D00KWC'|in_array:$user.marketpalce_na}checked{/if} id="A2Q3Y263D00KWC" name="update[marketpalce_na][]"><label for="A2Q3Y263D00KWC"> BR </label>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Marketplaces (Europe) </th>
                    <td>
                        <div class='marketplaces'>
                            <div class='marketplace--single'>
                                <input type="checkbox" value="A1RKKUPIHCS9HS" {if 'A1RKKUPIHCS9HS'|in_array:$user.marketpalce_eu}checked{/if} id="A1RKKUPIHCS9HS" name="update[marketpalce_eu][]"><label for="A1RKKUPIHCS9HS"> ES </label>
                            </div>
                            <div class='marketplace--single'>
                                <input type="checkbox" value="A1F83G8C2ARO7P" {if 'A1F83G8C2ARO7P'|in_array:$user.marketpalce_eu}checked{/if} id="A1F83G8C2ARO7P" name="update[marketpalce_eu][]"><label for="A1F83G8C2ARO7P"> UK </label>
                            </div>
                            <div class='marketplace--single'>
                                <input type="checkbox" value="A13V1IB3VIYZZH" {if 'A13V1IB3VIYZZH'|in_array:$user.marketpalce_eu}checked{/if} id="A13V1IB3VIYZZH" name="update[marketpalce_eu][]"><label for="A13V1IB3VIYZZH"> FR </label>
                            </div>
                            <div class='marketplace--single'>
                                <input type="checkbox" value="A1PA6795UKMFR9" {if 'A1PA6795UKMFR9'|in_array:$user.marketpalce_eu}checked{/if} id="A1PA6795UKMFR9" name="update[marketpalce_eu][]"><label for="A1PA6795UKMFR9"> DE </label>
                            </div>
                            <div class='marketplace--single'>
                                <input type="checkbox" value="APJ6JRA9NG5V4" {if 'APJ6JRA9NG5V4'|in_array:$user.marketpalce_eu}checked{/if} id="APJ6JRA9NG5V4" name="update[marketpalce_eu][]"><label for="APJ6JRA9NG5V4"> IT </label>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Marketplaces (India) </th>
                    <td>
                        <div class='marketplaces'>
                            <div class='marketplace--single'>
                                <input type="checkbox" value="A21TJRUUN4KGV" {if 'A21TJRUUN4KGV'|in_array:$user.marketpalce_in}checked{/if} id="A21TJRUUN4KGV" name="update[marketpalce_in][]"><label for="A21TJRUUN4KGV"> IN </label>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Marketplaces (China) </th>
                    <td>
                        <div class='marketplaces'>
                            <div class='marketplace--single'>
                                <input type="checkbox" value="AAHKV2X7AFYLW" {if 'AAHKV2X7AFYLW'|in_array:$user.marketpalce_cn}checked{/if} id="AAHKV2X7AFYLW" name="update[marketpalce_cn][]"><label for="AAHKV2X7AFYLW"> CN </label>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Marketplaces (Japan) </th>
                    <td>
                        <div class='marketplaces'>
                            <div class='marketplace--single'>
                                <input type="checkbox" value="A1VC38T7YXB528" {if 'A1VC38T7YXB528'|in_array:$user.marketpalce_jp}checked{/if} id="A1VC38T7YXB528" name="update[marketpalce_jp][]"><label for="A1VC38T7YXB528"> JP </label>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Marketplaces (Australia) </th>
                    <td>
                        <div class='marketplaces'>
                            <div class='marketplace--single'>
                                <input type="checkbox" value="A39IBJ37TRP1C6" {if 'A39IBJ37TRP1C6'|in_array:$user.marketpalce_au}checked{/if} id="A39IBJ37TRP1C6" name="update[marketpalce_au][]"><label for="A39IBJ37TRP1C6"> AU </label>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Shop</th>
                    <td>
                        <select class="form-control" name="update[shop_id]">
                            {foreach $shops as $shop}
                                <option value="{$shop.id}" {if $shop.id eq $user.shop_id}selected{/if}>{$shop.name}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Default Shipping method</th>
                    <td>
                        <select class="form-control" name="update[custom_shipping]">
                            {foreach $shippings as $shipping}
                                <option value="{$shipping.id}" {if $shipping.id eq $user.custom_shipping}selected{/if}>{$shipping.name}</option>
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
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
