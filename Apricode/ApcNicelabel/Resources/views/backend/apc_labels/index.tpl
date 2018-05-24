<head>
    <meta charset="utf-8">
    <meta name="nicelablel[viewport]" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{link file="backend/_resources/css/bootstrap.min.css"}">
    <link rel="stylesheet" href="{link file="backend/_resources/css/bootstrap-theme.min.css"}">
    <link rel="stylesheet" href="{link file="backend/_resources/css/jquery-ui.min.css"}">
    <link rel="stylesheet" href="{link file="backend/_resources/css/jnoty.css"}">
    <link rel="stylesheet" href="{link file="backend/_resources/css/main.css"}">
</head>

<div class="container" style="margin-top: 20px;">
    <h3>Nicelable manager</h3>
    <form action="{url module=backend controller=ApcLabels action=update}" class="navbar-form navbar-left" method="post" id='labelForm'>
        <table id="label_action" class="table">
            <tbody>
                <tr>
                    <th>Date From:</th>
                    <td>
                        <div class="form-group" style="margin: 0;">
                            <input type="text" class="form-control datepicker" name="nicelablel[date_from]">
                        </div>
                    </td>
                    <th>Date To:</th>
                    <td>
                        <div class="form-group" style="margin: 0;">
                            <input type="text" class="form-control datepicker" name="nicelablel[date_to]">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Order State:</th>
                    <td>
                        <div class="form-group" style="margin: 0;">
                            <select name="nicelablel[order_status]" class='form-control'>
                                <option value="-10">Select all</option>
                                {foreach $orderStatus as $status}
                                    <option value="{$status.id}">{$status.description}</option>
                                {/foreach}
                            </select>
                        </div>
                    </td>
                    <th>Payment State:</th>
                    <td>
                        <div class="form-group" style="margin: 0;">
                            <select name="nicelablel[payment_status]" class='form-control'>
                                <option value="-10">Select all</option>
                                {foreach $paymentStatus as $id => $status}
                                    <option value="{$status.id}">{$status.description}</option>
                                {/foreach}
                            </select>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <input type='submit' id='labelFormSubmit' class='btn btn-primary'>
    </form>
</div>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script src="{link file="backend/_resources/js/vendor/jquery-ui.min.js"}"></script>
<script src="{link file="backend/_resources/js/vendor/jnoty.js"}"></script>
<script src="{link file="backend/_resources/js/vendor/form.js"}"></script>

<script src="{link file="backend/_resources/js/main.js"}"></script>
