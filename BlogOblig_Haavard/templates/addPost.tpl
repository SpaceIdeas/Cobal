{include file="header.tpl"}

<h1>Add Post</h1>

<form class="form-horizontal" method="post">
    <div class="form-group">
        <label for="title" class="col-sm-2 control-label">Title</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="title" name="title">
        </div>
    </div>
    <div class="form-group">
        <label for="blogText" class="col-sm-2 control-label">Blog Text</label>
        <div class="col-sm-10">
            <textarea class="form-control" rows="8" name="blogText"></textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-10 col-sm-offset-2">
            <input id="submit" name="newBlogPost" type="submit" value="Send" class="btn btn-primary">
        </div>
    </div>
</form>

{include file="footer.tpl"}