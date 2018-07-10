{$dayDate = $day - $startWeekday + 1}
{if $dayDate < 1}
{$dayDate = $daysInPrevMonth + $dayDate}
{$old=1}
{/if}
<td class='calendar--cell {if $old eq 1}is--prev-month{else} is--current-month{/if}' {if $old neq 1} data-url={/if}>
    {if $old neq 1}
    <a class='calendar--day' href='{url module=backend controller=ApcCalendar action=day year=$year month=$month day=$dayDate}'>
        <div class='cell--container'>

        {if $cellEvents}
            {if $cellEvents|@count > 3}
                {foreach $cellEvents as $key => $event}
                    <p class='event--title'>{$event.time}: {$event.title|truncate:15:"..."}</p>
                    {if $key eq 2} {break} {/if}
                {/foreach}
                <p class='more--events'>+{$cellEvents|@count-3} More</p>
            {else}
                {foreach $cellEvents as $event}
                    <p class='event--title'>{$event.time}: {$event.title|truncate:15:"..."}</p>
                {/foreach}
            {/if}
        {/if}

        <span class='date--day'>{$dayDate}</span>
    </div>
    </a>
    {else}
    <span class='date--day'>{$dayDate}</span>
    {/if}
</td>
