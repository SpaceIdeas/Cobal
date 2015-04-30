<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h3 class="panel-title pull-left">{$post->getTitle()}</h3>
        {if isset($smarty.session.user) and $smarty.session.user->isAdmin()}
            <button class="btn btn-primary btn-sm pull-right" href="editPost.php?id={$post->getId()}">Rediger</button>
            <button class="btn btn-danger btn-sm pull-right" href="deletePost.php?id={$post->getId()}">Slett</button>
        {/if}
    </div>
    <div class="panel-body">
        <p>Oprettet {$post->getTimeCreated()} av {$post->getAuthorName($db)} <span class="label label-info">Treff: {$post->getHits()}</span></p>
        <p>{$post->getShortText()}</p>
    </div>
    <div class="panel-footer">
        <a href="post.php?id={$post->getID()}" class="btn btn-default" role="button" aria-label="Left Align">
            <span class="glyphicon glyphicon-align-left" aria-hidden="true"></span>
        </a>
        {if $post->getCommentCount($db) gt 0}
            {if $post->getCommentCount($db) gt 1}
                {if $post->getCommentCount($db) lte 12}
                {$post->getCommentCountAsString($db)} kommentarer
                {else}
                $post->getCommentCount($db) kommentarer
                 {/if}
            {else}
            En kommentar
            {/if}
        {else}
            Ingen kommentarer
        {/if}
    </div>
</div>