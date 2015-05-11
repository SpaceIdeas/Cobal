{include file='header.tpl'}
<h1>Slettede kommentarer</h1>
<div class="row">
    <div class="col-sm-12 col-md-9">
        {if isset($deletedComments)}
        {foreach from=$deletedComments item=deletedComment}
            {include file = 'deletedComment.tpl'}
        {/foreach}
        {else}
            <h4>Ingen slettede kommentarer</h4>
        {/if}
        <nav>
            <ul class="pager">
                {if isset($smarty.get.page) and $smarty.get.page neq 0}
                    <li class="previous"><a href="manageComments.php?page={$smarty.get.page - 1}"><span aria-hidden="true">&larr;</span> Nyere</a></li>
                {/if}
                {if count($deletedComments) eq 10}
                    <li class="next"><a href="manageComments.php?page={$smarty.get.page|default:0 + 1}">Eldre <span aria-hidden="true">&rarr;</span></a></li>
                {/if}
            </ul>
        </nav>
    </div>

</div>
{include file='footer.tpl'}