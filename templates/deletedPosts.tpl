{include file='header.tpl'}
<div class="row">
    <div class="col-sm-12 col-md-12">
        {foreach from=$deletedPosts item=post}
            {include file = 'deletedPostPreview.tpl'}
        {/foreach}
        {if isset($showPager)}
            <nav>
                <ul class="pager">
                    {if isset($smarty.get.page) and $smarty.get.page neq 0}
                        <li class="previous"><a href="deletedPosts.php?page={$smarty.get.page - 1}"><span aria-hidden="true">&larr;</span> Nyere</a></li>
                    {/if}
                    {if count($deletedPosts) eq 10}
                        <li class="next"><a href="deletedPosts.php?page={$smarty.get.page|default:0 + 1}">Eldre <span aria-hidden="true">&rarr;</span></a></li>
                    {/if}
                </ul>
            </nav>
        {/if}
    </div>


</div>
{include file='footer.tpl'}