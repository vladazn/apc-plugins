<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{link file="backend/_resources/css/bootstrap.min.css"}">
    <link rel="stylesheet" href="{link file="backend/_resources/css/bootstrap-theme.min.css"}">
    <link rel="stylesheet" href="{link file="backend/_resources/css/main.css"}">
</head>
<div class="container">
    <div class='calendar--header'>
        <span><a href="{url module=backend controller=ApcCalendar action=index year=$year month=$month}" class="btn btn-warning btn-xs">&lArr; Go Back</a></span>
        <span><h4>{$date}</h4></span>
        <span></span>
    </div>
	<div class='day--events'>
        {foreach $events as $event}
            <div class='day--event'>
                <span>{$event.time}: {$event.title}</span>
                <form method='post'>
                    <input type='hidden' name="remove[id]" value="{$event.id}">
                    <button type='submit' class="btn btn-danger">X</button>
                </form>
            </div>
        {/foreach}
    </div>
    <form method="post">
        <div class='create--input'>
            <div class='create--title'>
                <label for='createTitle'>Title:</label>
                <input type='text' class='form-control' name='create[title]' id='createTitle'>
            </div>
            <div class='create--time'>
                <label for='createTime'>Time:</label>
                <input type='text' class='form-control' name='create[eventTime]' id='createTime'>
            </div>
        </div>
        <label for='createArticles'>Article:</label>
        <select name='create[articleId]' id='createArticles' class="form-control">
            {foreach $articles as $id => $article}
                <option value="{$id}">{$article}</option>
            {/foreach}
        </select>
        <input type='hidden' value="{$year}-{$month}-{$day}" name='create[eventDate]'>
        <button type='submit' class='btn btn-primary'>Add</button>
    </form>
</div>
