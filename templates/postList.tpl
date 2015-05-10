<div class="panel panel-default">
    <div class="panel-heading">Innlegg</div>
    <div class="panel-body">
        <a href="index.php?mostPopular=true">Fem mest populære</a>
        <ul>
            {foreach from=$postList item=postYear}
                <li>
                    {$postYear->getYear()}
                    <ul>
                        {foreach from=$postYear->getMonths() item=amount key=month}
                            <li><a href="index.php?year={$postYear->getYear()}&month={$month}">{$month} ({$amount})</a></li>
                        {/foreach}
                    </ul>
                </li>
            {/foreach}
        </ul>
    </div>
</div>