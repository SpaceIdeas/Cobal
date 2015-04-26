<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">{$post->getTitle()}</h3>
    </div>
    <div class="panel-body">
        <p>Oprettet {$post->getTimeCreated()} av {$post->getAuthorName($db)}</p>
        <p>{$post->getShortText()}</p>
    </div>
    <div class="panel-footer">
        <a href="post.php?id={$post->getID()}" class="btn btn-default" role="button" aria-label="Left Align">
            <span class="glyphicon glyphicon-align-left" aria-hidden="true"></span>
        </a>
        {if $post->getCommentCount($db) gt 0}
            {if $post->getCommentCount($db) gt 1}
                {if $post->getCommentCount($db) lte 12}
                {NumberConverter::Convert($post->getCommentCount($db))} kommentarer
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