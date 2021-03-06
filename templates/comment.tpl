<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h4 class="panel-title pull-left">Klokken {$comment->getTimeCreated($db)} kommenterte {$comment->getAuthorName($db)}
            {if $comment->getAuthorEmail() eq $post->getAuthorEmail()}
                {include file='span/authorSpan.tpl'}
            {/if}
            {if isset($smarty.session.user) and $comment->getAuthorEmail() eq $smarty.session.user->getEmail()}
                {include file='span/youSpan.tpl'}
            {/if}
        </h4>
        {if isset($smarty.session.user) and ($smarty.session.user->isAdmin() or $smarty.session.user->getEmail() eq $comment->getAuthorEmail())}
            {if !$comment->isDeleted()}
                <a class="btn btn-danger btn-sm pull-right" role="button" href="deleteComment.php?id={$comment->getID()}&amp;return={$smarty.server.PHP_SELF}" onclick="javascript:return confirm('Er du sikker på at du vil slette denne kommentaren?')">Slett</a>
            {/if}
        {/if}
        {if isset($smarty.session.user)}
            <a class="btn btn-primary btn-sm pull-right" role="button" href="post.php?id={$comment->getPostID()}&amp;reply={$comment->getID()}#commentBox">Svar</a>
        {/if}
        <p class="pull-right elbow-room">#{$comment->getID()} </p>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-1 cuddle-pile">
                <img src="profileImage.php?commentID={$comment->getID()}" alt="Profilbilde her" width="100" height="100">
            </div>
            <div class="col-sm-11 text-wrap"><p>{$comment->getText()}</p></div>
        </div>

    </div>
</div>
