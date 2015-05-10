{include file='header.tpl'}
<div class="row">
    <div class="col-sm-12 col-md-9">
        {foreach from=$posts item=post}
            {include file = 'postPreview.tpl'}
        {/foreach}
        {if isset($showPager)}
        <nav>
            <ul class="pager">
                {if isset($smarty.get.page)}
                    <li class="previous"><a href="index.php?page={$smarty.get.page - 1}"><span aria-hidden="true">&larr;</span> Nyere</a></li>
                {/if}
                {if count($posts) eq 10}
                    <li class="next"><a href="index.php?page={$smarty.get.page|default:0 + 1}">Eldre <span aria-hidden="true">&rarr;</span></a></li>
                {/if}
            </ul>
        </nav>
        {/if}
    </div>
    <div class="col-sm-12 col-md-3">
        {include file='postList.tpl'}
    </div>

</div>
{include file='footer.tpl'}