<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-03-29 19:42:12
         compiled from ".\templates\addPost.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10532551804c06ae187-80863810%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ee2f6e255b443eb736ddd826fde09b8df193e46e' => 
    array (
      0 => '.\\templates\\addPost.tpl',
      1 => 1427650912,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10532551804c06ae187-80863810',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_551804c0821359_88392330',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_551804c0821359_88392330')) {function content_551804c0821359_88392330($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


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

<?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
