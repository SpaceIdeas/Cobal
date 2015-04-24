<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<head>
    <div class="container">
    <div class="page-header">
        <h1>Cobal<small>Ideas about space</small></h1>
    </div>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Hjem</a></li>
                <li><a href="addPost.php">Legg til innlegg</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                {if isset($smarty.session.loggedin)}
                    <li><a>Hello Mr/Mrs {$smarty.session.user->getName()}</a></li>
                    <li><a href="logout.php?return="{$smarty.server.REQUEST_URI}>Logg ut</a></li>
                {else}
                    <li><a href="login.php">Logg inn</a></li>
                {/if}
            </ul>
        </div>
    </nav>
    {if isset($message)}
        <p>{$message}</p>
    {/if}
        <div>
</head>
<body>
<div class="container">
