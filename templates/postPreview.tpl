<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h3 class="panel-title pull-left">{$post->getTitle()}</h3>
        {if isset($smarty.session.user) and $smarty.session.user->isAdmin()}
            <a class="btn btn-danger btn-sm pull-right" role="button" href="deletePost.php?id={$post->getID()}&amp;return={$smarty.server.PHP_SELF}" onclick="javascript:return confirm('Er du sikker på at du vil slette dette innlegget?')">Slett</a>
            <a class="btn btn-primary btn-sm pull-right" role="button" href="addPost.php?id={$post->getID()}">Rediger</a>
        {/if}
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-10">
                <p>Opprettet {$post->getTimeCreated()} av {$post->getAuthorName($db)}
                    {include file="span/hitSpan.tpl"}
                    {if isset($smarty.session.user) and $post->getAuthorEmail() eq $smarty.session.user->getEmail()}
                        {include file='span/youSpan.tpl'}
                    {/if}
                </p>
                {$post->getText()}
            </div>
            <div class="col-xs-2">
                <img src="profileImage.php?postID={$post->getID()}" alt="Profilbilde her" height="100" width="100">
            </div>
        </div>
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