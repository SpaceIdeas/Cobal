{include file='header.tpl'}
<h1>{$post->getTitle()}</h1>
<p><b>Oprettet {$post->getTimeCreated($db)} av {$post->getAuthorName($db)}</b></p>
<p>{$post->getText()}</p>
{foreach from=$comments item=comment}
    {include file = 'comment.tpl'}
{/foreach}
<nav>
    <ul class="pager">
        {if ($post->hasPreviousPostID($db))}
        <li class="previous"><a href="post.php?id={$post->getPreviousPostID($db)}"><span aria-hidden="true">&larr;</span> Forrige</a></li>
        {else}
            <li class="previous disabled"><a href="post.php?id={$post->getPreviousPostID($db)}"><span aria-hidden="true">&larr;</span> Forrige</a></li>
        {/if}
        {if ($post->hasNextPostID($db))}
            <li class="next"><a href="post.php?id={$post->getNextPostID($db)}"> Neste <span aria-hidden="true">&rarr;</span></a></li>
        {else}
            <li class="next disabled"><a href="post.php?id={$post->getNextPostID($db)}"><span aria-hidden="true">&larr;</span> Neste</a></li>
        {/if}

    </ul>
</nav>
{include file='footer.tpl'}
