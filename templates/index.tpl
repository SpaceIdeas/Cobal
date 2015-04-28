{include file='header.tpl'}
<div class="row">
    <div class="col-xs-12 col-md-10">
        {foreach from=$posts item=post}
            {include file = 'postPreview.tpl'}
        {/foreach}
    </div>
    <div class="col-xs-6 col-md-2">
        {include file='postList.tpl'}
    </div>

</div>
{include file='footer.tpl'}