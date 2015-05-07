<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h3 class="panel-title pull-left">{$deletedPost->getTitle()}</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-10">
                <p>Opprettet {$deletedPost->getTimeCreated()} av {$deletedPost->getAuthorName($db)} - Slettet {$deletedPost->getTimeDeleted()}
                    {include file="span/hitSpan.tpl"}
                    {if isset($smarty.session.user) and $deletedPost->getAuthorEmail() eq $smarty.session.user->getEmail()}
                        {include file='span/youSpan.tpl'}
                    {/if}
                </p>
                <p class="text-justify">{$deletedPost->getShortText()}</p>
            </div>
            <div class="col-xs-2">
                <img src="profileImage.php?postID={$deletedPost->getID()}" height="100px" width="100px">
            </div>
        </div>
    </div>
</div>