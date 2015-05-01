{include file='header.tpl'}
{if isset($smarty.session.user)}
{literal}
    <script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
    <script>tinymce.init({selector:'textarea'});</script>
    <script type="text/javascript">
        tinymce.init({
            selector: "textarea",
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
        });
    </script>
{/literal}


    <form method="POST" ENCTYPE="multipart/form-data" >
        Tittle: <input name="txtTitle" class="form-control" placeholder="Inleggstittel" required autofocus >
        <textarea name="txtPost" style="width:100%"></textarea>
        <INPUT TYPE="hidden" name="MAX_FILE_SIZE" value="100000000000000">
        Send this file: <INPUT NAME="userfile" id="userfile" TYPE="file">
        <input type="submit" class="btn btn-default" name="btnAddPost">
    </form>
{/if}
{include file='footer.tpl'}