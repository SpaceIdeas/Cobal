{include file='header.tpl'}
<h1>Yolo</h1>
{foreach from=$posts item=post}
{include file = 'postPreview.tpl'}
{/foreach}
{include file='footer.tpl'}