{include file='header.tpl'}
<div class="blog-main"> <!--blog-->
    <div class="blog-post">
        <h1 class="blog-post-title">{$post->getTitle($db)}</h1>
        {if isset($smarty.session.user) and $smarty.session.user->isAdmin()}
            <a class="btn btn-primary btn-sm pull-right" role="button" href="editPost.php?id={$post->getId()}">Rediger</a>
            <a class="btn btn-danger btn-sm pull-right" role="button" href="deletePost.php?id={$post->getId()}">Slett</a>
        {/if}
        <p class="blog-post-meta"><b>Opprettet {$post->getTimeCreated($db)} av {$post->getAuthorName($db)} <span class="label label-info">Treff: {$hits}</span></b></p>

        <p>{$post->getText()}</p>
    </div>
</div>
{if isset($smarty.session.user)}
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left">{$smarty.session.user->getUsername()} kommenterte:</h3>
        </div>
        <div class="panel-body">
            <form class="form-inline" role="form" method="POST">
            <div class="form-group">
                <label for="comment">Din kommentar:</label>
                <textarea class="form-control" rows="5" id="comment" name="txtComment"></textarea>
            </div>
            <div class="panel-footer">
                <button class="btn btn-default" role="button" aria-label="Left Align" name="btnComment">
                    <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
                </button>
            </div>
                </form>
        </div>
    </div>
    {/if}

{foreach from=$comments item=comment}
    {include file = 'comment.tpl'}
{/foreach}
<nav>
    <ul class="pager">
        {if ($post->hasPreviousPostID($db))}
        <li class="previous"><a href="post.php?id={$post->getPreviousPostID($db)}"><span aria-hidden="true">&larr;</span> Forrige</a></li>
        {else}
            <li class="previous disabled"><a href="#"><span aria-hidden="true">&larr;</span> Forrige</a></li>
        {/if}
        {if ($post->hasNextPostID($db))}
            <li class="next"><a href="post.php?id={$post->getNextPostID($db)}"> Neste <span aria-hidden="true">&rarr;</span></a></li>
        {else}
            <li class="next disabled"><a href="#"><span aria-hidden="true">&rarr;</span> Neste</a></li>
        {/if}

    </ul>
</nav>
{include file='footer.tpl'}
