<?php /* Smarty version Smarty-3.1.21-dev, created on 2015-03-29 20:25:24
         compiled from ".\templates\header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:54745511af6729d054-91891711%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '57968da974f2cab6c380ca6c9b517a7f7fc5c619' => 
    array (
      0 => '.\\templates\\header.tpl',
      1 => 1427653516,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '54745511af6729d054-91891711',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5511af672b4753_35647467',
  'variables' => 
  array (
    'message' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5511af672b4753_35647467')) {function content_5511af672b4753_35647467($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
<head>
	<title>Space Blog</title>
	<link rel="icon" type="image/png" href="img/Spaceslug.png">
	<meta charset="utf-8"> 
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<?php echo '<script'; ?>
 src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"><?php echo '</script'; ?>
>
</head>
<body>
<div class="container">
	<div class="jumbotron">
    <h1>Space Blog</h1>      
    <p>when your blog needs more space</p>      
	</div>
	
	<nav class="navbar navbar-default">
		<div class="container-fluid">
 	 		<ul class="nav navbar-nav">
  			  	<li><a href="index.php">Blog</a></li>
  			  	<li><a href="addPost.php">Add Post</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
			<?php if (isset($_SESSION['loggedin'])) {?>
				<li><a>Hello Mr/Mrs <?php echo $_SESSION['user']->getFullName();?>
</a></li>
				<li><a href="logout.php?return="<?php echo $_SERVER['REQUEST_URI'];?>
>Logout</a></li>
			<?php } else { ?>
				<li><a href="login.php">Login</a></li>
			<?php }?>
 		 	</ul>
		</div>
	</nav>
	<?php if (isset($_smarty_tpl->tpl_vars['message']->value)) {?>
		<p><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</p>
	<?php }?>
</div>
<div class="container"><?php }} ?>
