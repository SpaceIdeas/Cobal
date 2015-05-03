{include file='header.tpl'}
<h1>Slettede kommentarer</h1>
<div class="row">
    <div class="col-xs-12 col-md-9">
        {foreach from=$deletedComments item=$deletedComment}
            {include file = 'deletedComment.tpl'}
        {/foreach}
    </div>

</div>
{include file='footer.tpl'}