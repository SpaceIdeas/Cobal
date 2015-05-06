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
                <a class="btn btn-danger btn-sm pull-right" role="button" href="deleteComment.php?id={$comment->getID()}&return={$smarty.server.PHP_SELF}" onclick="javascript:return confirm('Er du sikker på at du vil slette denne kommentaren?')">Slett</a>
            {/if}
        {/if}
        <a class="btn btn-primary btn-sm pull-right" role="button" href="post.php?id={$comment->getPostID()}&reply={$comment->getID()}#commentBox">Svar</a>
        <p class="pull-right elbow-room">#{$comment->getID()} </p>
    </div>
    <div class="panel-body">
        <img src="profileImage.php?commentID={$comment->getID()}" width="100px" height="100px" class="personal-space">
        {$comment->getText()}
    </div>
</div>