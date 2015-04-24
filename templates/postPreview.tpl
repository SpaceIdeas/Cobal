<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">{$post->getTitle()}</h3>
    </div>
    <div class="panel-body">
        <p>Oprettet {$post->getTimeCreated()} av {$post->getAuthorName($db)}<(p>
        Panel content
        <a href="post.php?id={$post->getID()}">Les mer</a>
    </div>
</div>