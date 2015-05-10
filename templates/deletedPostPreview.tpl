<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h3 class="panel-title pull-left">{$post->getTitle()}</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-10">
                <p>Opprettet {$post->getTimeCreated()} av {$post->getAuthorUsername()} ({$post->getAuthorEmail()}) - Slettet {$post->getTimeDeleted()}
                    {include file="span/hitSpan.tpl"}
                    {if isset($smarty.session.user) and $post->getAuthorEmail() eq $smarty.session.user->getEmail()}
                        {include file='span/youSpan.tpl'}
                    {/if}
                </p>
                <p class="text-justify">{$post->getText()}</p>
            </div>
            <div class="col-xs-2">
                <img src="profileImage.php?postID={$post->getPostID()}" height="100px" width="100px">
            </div>
        </div>
    </div>
</div>