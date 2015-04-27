{include file='header.tpl'}
{include file='alert.tpl'}
{foreach from=$posts item=post}
    {include file = 'postPreview.tpl'}
{/foreach}
{include file='footer.tpl'}