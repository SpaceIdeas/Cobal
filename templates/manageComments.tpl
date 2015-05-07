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
    </div>

</div>
{include file='footer.tpl'}