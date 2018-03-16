<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <style type="text/css">
        body {
            font-family: Arial, Verdana, Geneva, Helvetica, sans-serif;
        }

        .wrapper {
            padding:20px;
            border: 2px solid black;
        }

        .barcode {
            padding: 1.5mm;
            margin: 0;
            vertical-align: top;
            color: #000044;
        }
        .barcodecell {
            margin-top:15px;
            text-align: center;
            vertical-align: middle;
        }

        .col_50 {
            width: 50%;
            float:left;
        }

        .col_75 {
            width: 64%;
            float:left;
        }

        .col_25 {
            width: 45%;
            float:left;
        }

        .text-right {
            text-align: right;
        }

        .clear {
            clear: both;
        }
    </style>
</head>
<body>

    <div class="wrapper">
        <div class="col_50">
            <h2>{$ticket.article.name}</h2>
        </div>
        <div class="col_25">
           <p><img src="{media path=$ticket.article.image}" alt="service point" width="225" height="285"></p>
        </div>
       
        <div class="col_75">
            <div class="barcodecell">
                <barcode code="{$ticket.ticketCode}" size="1" type="QR" error="M" class="barcode" />
                <div class="barcodetext">{$ticket.ticketCode} </div>
            </div>
        </div>
        <div class="clear"></div>

        <hr>

        <div class="col_50">
            <b>Bestellnummer:</b> {$ticket.ordernumber}
        </div>
        <div class="col_50 text-right">
            {$ticket.price} EUR
        </div>
        <div class="clear"></div>

        <hr>
       
        <div class="description">
            {$ticket.article.descriptionLong}
        </div>

        <table cellpadding="5">
            <tr>
                <th align="right">Zeitraum:</th>
                <td>{$ticket.event.eventDatetime}</td>
            </tr>
            <tr>
                <th align="right">Ort:</th>
                <td>{$ticket.event.eventLocation}</td>
            </tr>
        </table>

        <hr>
       
        {$ticket.config.ticketfooter}
    </div>
</body>
</html>