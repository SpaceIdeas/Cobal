<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">Klokken {$comment->getTimeCreated($db)} kommenterte: {$comment->getAuthorName($db)}</h4>
    </div>
    <div class="panel-body">
        {$comment->getText()}
    </div>
</div>