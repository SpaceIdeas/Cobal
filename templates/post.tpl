{include file='header.tpl'}
<h1>{$post->getTitle()}</h1>
<p><b>Oprettet {$post->getTimeCreated($db)} av {$post->getAuthorName($db)}</b></p>
<p>{$post->getText()}</p>
{foreach from=$comments item=comment}
    {include file = 'comment.tpl'}
{/foreach}
{include file='footer.tpl'}
