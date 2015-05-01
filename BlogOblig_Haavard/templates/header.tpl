<!DOCTYPE html>
<html lang="en">
<head>
	<title>Space Blog</title>
	<link rel="icon" type="image/png" href="/BlogOblig_Haavard/img/Spaceslug.png">
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
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
  			  	<li><a href="BlogOblig_Haavard/index.php">Blog</a></li>
  			  	<li><a href="BlogOblig_Haavard/addPost.php">Add Post</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
			{if isset($smarty.session.loggedin)}
				<li><a>Hello Mr/Mrs {$smarty.session.user->getFullName()}</a></li>
				<li><a href="BlogOblig_Haavard/logout.php?return="{$smarty.server.REQUEST_URI}>Logout</a></li>
			{else}
				<li><a href="BlogOblig_Haavard/login.php">Login</a></li>
			{/if}
 		 	</ul>
		</div>
	</nav>
	{if isset($message)}
		<p>{$message}</p>
	{/if}
</div>
<div class="container">