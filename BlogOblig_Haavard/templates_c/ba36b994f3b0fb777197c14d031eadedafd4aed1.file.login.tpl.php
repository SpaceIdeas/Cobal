<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-03-27 19:04:14
         compiled from ".\templates\login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:118965512bb9a307170-15508089%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ba36b994f3b0fb777197c14d031eadedafd4aed1' => 
    array (
      0 => '.\\templates\\login.tpl',
      1 => 1427479444,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '118965512bb9a307170-15508089',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5512bb9a3af127_37885835',
  'variables' => 
  array (
    'loginSucsess' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5512bb9a3af127_37885835')) {function content_5512bb9a3af127_37885835($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<?php if (isset($_smarty_tpl->tpl_vars['loginSucsess']->value)&&$_smarty_tpl->tpl_vars['loginSucsess']->value==false) {?>
<div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">Error:</span>
  Login failed
</div>
<?php }?>
<div class="row">
	<div class="col-sm-3 col-md-6 col-lg-4">
		<form class="form-signin" method="post">
			<h2 class="form-signin-heading">Please log in</h2>
   	   		<label for="inputEmail" class="sr-only">Email address</label>
   	   		<input type="email" name="inputEmail" class="form-control" placeholder="Email address" required autofocus>
   	   		<label for="inputPassword" class="sr-only">Password</label>
   	   		<input type="password" name="inputPassword" class="form-control" placeholder="Password" required>
   	   		<input class="btn btn-lg btn-primary btn-block" type="submit" name="action"  value="login" />
    	</form>
	</div>
</div>


  
 <p>Logg inn med email: "admin@adminhaven.edu" & password: "adminpassord"</p>
 <?php echo $_smarty_tpl->getSubTemplate ("footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


 <?php }} ?>
