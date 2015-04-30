<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h4 class="panel-title pull-left">Klokken {$comment->getTimeCreated($db)} kommenterte {$comment->getAuthorName($db)}
            {if $comment->getAuthorEmail() eq $post->getAuthorEmail()}
                <span class="label label-primary">Forfatter</span>
            {/if}
            {if isset($smarty.session.user) and $comment->getAuthorEmail() eq $smarty.session.user->getEmail()}
                <span class="label label-warning">Deg</span>
            {/if}
        </h4>
        {if isset($smarty.session.user) and ($smarty.session.user->isAdmin() or $smarty.session.user->getEmail() eq $comment->getAuthorEmail())}
            <a class="btn btn-primary btn-sm pull-right" role="button" href="editComment.php?id={$comment->getId()}">Rediger</a>
            <a class="btn btn-danger btn-sm pull-right" role="button" href="deleteComment.php?id={$comment->getId()}">Slett</a>
        {/if}
    </div>
    <div class="panel-body">
        {$comment->getText()}
    </div>
</div>