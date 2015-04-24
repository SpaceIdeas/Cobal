{include file='header.tpl'}
{$post->getText()}
{foreach from=$comments item=comment}
    {include file = 'comment.tpl'}
{/foreach}
{include file='footer.tpl'}
