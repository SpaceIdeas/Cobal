{include file='header.tpl'}
<div class="row">
    <div class="col-sm-12 col-md-12">
        {foreach from=$posts item=post}
            {include file = 'deletedPostPreview.tpl'}
        {/foreach}
    </div>


</div>
{include file='footer.tpl'}