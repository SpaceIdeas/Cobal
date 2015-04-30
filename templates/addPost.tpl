{include file='header.tpl'}
{if isset($smarty.session.user)}
    <form ENCTYPE="multipart/form-data" METHOD=POST>
        <INPUT TYPE="hidden" name="MAX_FILE_SIZE" value="100000000000000">
        Send this file: <INPUT NAME="userfile" id="userfile" TYPE="file">
        <button type="submit" value="last opp" class="btn btn-default" name="btnUploadFile">
            Hello
    </form>
{literal}
    <script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '#my_editor',
            plugins: ["image"],
            file_browser_callback: function(field_name, url, type, win) {
                if(type=='image') $('#my_form input').click();
            }
        });
    </script>
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

    <form method="POST" >
        Tittle: <input name="txtTitle" class="form-control" placeholder="Inleggstittel" required autofocus >
        <textarea name="txtPost" style="width:100%"></textarea>
        <button type="submit" class="btn btn-default" name="btnAddPost">
    </form>
{/if}
{include file='footer.tpl'}