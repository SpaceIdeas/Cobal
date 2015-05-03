{include file='header.tpl'}
<div class="row">
    <div class="col-sm-12 col-md-9">
        {foreach from=$posts item=post}
            {include file = 'postPreview.tpl'}
        {/foreach}
    </div>
    <div class="col-sm-12 col-md-3">
        {include file='postList.tpl'}
    </div>

</div>
{include file='footer.tpl'}