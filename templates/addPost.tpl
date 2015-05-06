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
            image_class_list: [
                {title: 'Image Responsive', value: 'img-responsive'},
            ],
            toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code"
        });
    </script>
{/literal}
    <form method="POST" enctype="multipart/form-data" >
        <label for="txtTitle">Tittel</label>
        <input name="txtTitle" class="form-control" placeholder="Innleggstittel" value="{$post->getTitle()}" required autofocus id="txtTitle">
        <textarea name="txtPost" style="width:100%" rows="20" >{$post->getText()}</textarea>
        <input type="hidden" name="MAX_FILE_SIZE" value="100000000000000">
        <label for="userfile">Vedlegg</label>
        <input name="userfile" id="userfile" TYPE="file" >
        <input type="submit" class="btn btn-default" value="Post innlegget" name="btnAddPost">
    </form>
    {if $post->getText() != null}
        <span class="label label-info">Når du redigerer et innlegg vil du ikke kunne forandre på vedlegget</span>
    {/if}
{/if}
{include file='footer.tpl'}