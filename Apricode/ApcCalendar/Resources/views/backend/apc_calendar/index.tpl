<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{link file="backend/_resources/css/bootstrap.min.css"}">
    <link rel="stylesheet" href="{link file="backend/_resources/css/bootstrap-theme.min.css"}">
    <link rel="stylesheet" href="{link file="backend/_resources/css/main.css"}">
</head>
<div class="container">
    <div class='calendar--header'>
        <span><a href="{url module=backend controller=ApcCalendar action=index year=$prev.link.year month=$prev.link.month}" class="btn btn-warning btn-xs">&lArr; {$prev.text}</a></span>
        <span><h3>{$currentMonth}</h3></span>
        <span><a href="{url module=backend controller=ApcCalendar action=index year=$next.link.year month=$next.link.month}" class="btn btn-warning btn-xs"> {$next.text} &rArr;</a></span>
    </div>
	<table id="routes" class="table table-striped table-bordered" style="margin-bottom: 20px;">
		<thead>
			<tr>
				<th class="text-center">Mon</th>
				<th class="text-center">Tue</th>
				<th class="text-center">Wed</th>
				<th class="text-center">Thu</th>
				<th class="text-center">Fri</th>
				<th class="text-center">Sat</th>
				<th class="text-center">Sun</th>
			</tr>
		</thead>
		<tbody>
            <tr>
            {$max = $daysInMonth + $startWeekday - 1}
            {for $day = 1 to $max}
                {include file="backend/apc_calendar/components/cell.tpl" cellEvents=$events[$day-$startWeekday+1]}
                {if $day%7 == 0}
                    </tr><tr>
                {/if}
			{/for}
            </tr>
		</tbody>
    </table>
    <form method="post" action="{url module=backend controller=ApcCalendar action=quickAdd}">


        <table class='table add--form'>
            <thead>
                <tr>
                    <th colspan="4">
                        <h3>Quick Add</h3>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <label for='year'>Year:</label>
                        <select name='create[year]' id='year' class="form-control">
                            <option value="2017" {if $year eq 2017} selected {/if}>2017</option>
                            <option value="2018" {if $year eq 2018} selected {/if}>2018</option>
                            <option value="2019" {if $year eq 2019} selected {/if}>2019</option>
                            <option value="2020" {if $year eq 2020} selected {/if}>2020</option>
                            <option value="2021" {if $year eq 2021} selected {/if}>2021</option>
                            <option value="2022" {if $year eq 2022} selected {/if}>2022</option>
                            <option value="2023" {if $year eq 2023} selected {/if}>2023</option>
                            <option value="2024" {if $year eq 2024} selected {/if}>2024</option>
                        </select>
                    </td>
                    <td>
                        <label for='month'>Month:</label>
                        <select name='create[month]' id='month' class="form-control">
                            <option value="01" {if $month eq 1} selected {/if}>01</option>
                            <option value="02" {if $month eq 2} selected {/if}>02</option>
                            <option value="03" {if $month eq 3} selected {/if}>03</option>
                            <option value="04" {if $month eq 4} selected {/if}>04</option>
                            <option value="05" {if $month eq 5} selected {/if}>05</option>
                            <option value="06" {if $month eq 6} selected {/if}>06</option>
                            <option value="07" {if $month eq 7} selected {/if}>07</option>
                            <option value="08" {if $month eq 8} selected {/if}>08</option>
                            <option value="09" {if $month eq 9} selected {/if}>09</option>
                            <option value="10" {if $month eq 10} selected {/if}>10</option>
                            <option value="11" {if $month eq 11} selected {/if}>11</option>
                            <option value="12" {if $month eq 12} selected {/if}>12</option>
                        </select>
                    </td>
                    <td>
                        <label for='month'>Day:</label>
                        <select name='create[day]' id='month' class="form-control">
                            <option value="01" >01</option>
                            <option value="02" >02</option>
                            <option value="03" >03</option>
                            <option value="04" >04</option>
                            <option value="05" >05</option>
                            <option value="06" >06</option>
                            <option value="07" >07</option>
                            <option value="08" >08</option>
                            <option value="09" >09</option>
                            <option value="10" >10</option>
                            <option value="11" >11</option>
                            <option value="12" >12</option>
                            <option value="13" >13</option>
                            <option value="14" >14</option>
                            <option value="15" >15</option>
                            <option value="16" >16</option>
                            <option value="17" >17</option>
                            <option value="18" >18</option>
                            <option value="19" >19</option>
                            <option value="20" >20</option>
                            <option value="21" >21</option>
                            <option value="22" >22</option>
                            <option value="23" >23</option>
                            <option value="24" >24</option>
                            <option value="25" >25</option>
                            <option value="26" >26</option>
                            <option value="27" >27</option>
                            <option value="28" >28</option>
                            <option value="29" >29</option>
                            <option value="30" >30</option>
                            <option value="31" >31</option>
                        </select>
                    </td>
                    <td style='width:15%'>
                        <label for='createTime'>Time:</label>
                        <input type='text' class='form-control' name='create[time]' id='createTime'>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label for='createTitle'>Title:</label>
                        <input type='text' class='form-control' name='create[title]' id='createTitle'>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <label for='createArticles'>Article:</label>
                        <select name='create[articleId]' id='createArticles' class="form-control">
                            {foreach $articles as $id => $article}
                                <option value="{$id}">{$article}</option>
                            {/foreach}
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <button type='submit' class='btn btn-primary'>Add</button>
                    </td>
                </tr>
            </tbody>
        </table>

    </form>
</div>
