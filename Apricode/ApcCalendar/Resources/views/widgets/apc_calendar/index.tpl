
<div class="calendar--container">
    <div class='calendar--header'>
        <span><h3>{s name='apcWebinarSidebar'}WEBINARE IM {/s}{$currentMonth}</h3></span>
    </div>
	<table class="table table-striped table-bordered" style="margin-bottom: 20px;">
		<tbody>
            {foreach $events as $event}
                <tr class='calendar--date'>
                    <td><a href='{$event.article.linkDetailsRewrited}'> <i class="icon--arrow-right"></i>{$event.title}</a></td>
                </tr>
                <tr class='calendar--event'>
                    <td>{$event.date} at {$event.time}</td>
                </tr>
                <tr class='calendar--event'>
                    <td class='event--price'><b>{$event.article.price|currency}</b></td>
                </tr>
            {/foreach}
		</tbody>
    </table>
</div>
