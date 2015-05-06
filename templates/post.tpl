{include file='header.tpl'}
<div class="blog-main"> <!--blog-->
    <div class="blog-post">
        <h1 class="blog-post-title">{$post->getTitle($db)}</h1>
        {if isset($smarty.session.user) and $smarty.session.user->isAdmin()}
            <a class="btn btn-danger btn-sm pull-right" role="button" href="deletePost.php?id={$post->getID()}&return={$smarty.server.PHP_SELF}" onclick="javascript:return confirm('Er du sikker på at du vil slette dette innlegget?')">Slett</a>
            <a class="btn btn-primary btn-sm pull-right" role="button" href="addPost.php?id={$post->getID()}">Rediger</a>
        {/if}
        <div class="row">
            <div class="col-md-10">
                <p class="blog-post-meta"><b>Opprettet {$post->getTimeCreated($db)} av {$post->getAuthorName($db)} </b>
                    {include file="span/hitSpan.tpl"}
                    {if isset($smarty.session.user) and $post->getAuthorEmail() eq $smarty.session.user->getEmail()}
                        {include file='span/youSpan.tpl'}
                    {/if}
                </p>

                <p>{$post->getText()}</p>
                {if isset($attachment)}
                <form class="form-inline" role="form" method="POST">
                    <div class="form-group">
                        <button class="btn btn-default" aria-label="Left Align" name="btnShowAttachment">Vis vedlegg</button>
                    </div>
                </form>
            </div>
            <div class="col-md-2">
                <img src="img/DefaultProfilePic.jpg" class="pull-right" style="padding-top: 10px; padding-bottom: 10px;">
            </div>
        </div>
        {/if}
    </div>
</div>
{if isset($smarty.session.user)}

    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <h3 class="panel-title pull-left">{$smarty.session.user->getUsername()} kommenterte:</h3>
        </div>
        <div class="panel-body">
            <form class="form-group" role="form" method="POST">

                <label for="comment">Din kommentar:</label>
                <textarea class="form-control" rows="5" id="comment" name="txtComment"></textarea>

            <div class="panel-footer">
                <button class="btn btn-default" role="button" aria-label="Left Align" name="btnComment">
                    <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>Kommenter
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
