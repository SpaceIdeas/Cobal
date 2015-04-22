<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-03-29 20:09:32
         compiled from ".\templates\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8327551191dd667b17-38440278%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7a35232ac1a78d0c8ecc694ffa5f3ea448ed1c79' => 
    array (
      0 => '.\\templates\\index.tpl',
      1 => 1427652531,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8327551191dd667b17-38440278',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_551191dd88a992_81311002',
  'variables' => 
  array (
    'blogPosts' => 0,
    'blogPost' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_551191dd88a992_81311002')) {function content_551191dd88a992_81311002($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php  $_smarty_tpl->tpl_vars['blogPost'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['blogPost']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['blogPosts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['blogPost']->key => $_smarty_tpl->tpl_vars['blogPost']->value) {
$_smarty_tpl->tpl_vars['blogPost']->_loop = true;
?>
<div class="row">
	<div class="col-sm-8 blog-main"> <!--blog   -->
    	<div class="blog-post">
        	<h2 class="blog-post-title"><?php echo $_smarty_tpl->tpl_vars['blogPost']->value->getTitle();?>
</h2>
            <p class="blog-post-meta"><?php echo $_smarty_tpl->tpl_vars['blogPost']->value->getDate();?>
 by <?php echo $_smarty_tpl->tpl_vars['blogPost']->value->getAuthorName();?>
</p>
            <?php echo $_smarty_tpl->tpl_vars['blogPost']->value->getText();?>

        </div>
    </div>
</div>
<?php } ?>

<?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
