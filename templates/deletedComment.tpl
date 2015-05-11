<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h4 class="panel-title pull-left">Klokken {$deletedComment->getTimeCreated()} kommenterte {$deletedComment->getAuthorUsername()} ({$deletedComment->getAuthorEmail()}) <br />
            Slettet: {$deletedComment->getTimeDeleted()}
            {if isset($smarty.session.user) and $deletedComment->getAuthorEmail() eq $smarty.session.user->getEmail()}
                {include file='span/youSpan.tpl'}
            {/if}
        </h4>
        <a class="btn btn-primary btn-sm pull-right" role="button" href="restoreComment.php?id={$deletedComment->getID()}&amp;return={$smarty.server.PHP_SELF}" onclick="javascript:return confirm('Er du sikker på at du vil gjennopprette denne kommentaren?')">Gjennopprett</a>

    </div>
    <div class="panel-body text-wrap">{$deletedComment->getText()}</div>
</div>