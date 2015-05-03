{include file='header.tpl'}
{if isset($smarty.session.user)}
{literal}
    <script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: "textarea",
            menubar:false,
            statusbar: false,
            plugins: [
                "advlist lists link image charmap",
                "visualblocks",
                "table paste code"
            ],
            toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code"
        });
    </script>
{/literal}
    <form method="POST" enctype="multipart/form-data" >
        <label for="txtTitle">Tittel</label>
        <input name="txtTitle" class="form-control" placeholder="Inleggstittel" required autofocus id="txtTitle">
        <textarea name="txtPost" style="width:100%"></textarea>
        <input type="hidden" name="MAX_FILE_SIZE" value="100000000000000">
        <label for="userfile">Vedlegg</label>
        <input name="userfile" id="userfile" TYPE="file" >
        <input type="submit" class="btn btn-default" value="Post innlegget" name="btnAddPost">
    </form>
{/if}
{include file='footer.tpl'}