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
            <form class="navbar-form navbar-right" role="search" action="index.php" method="get">
                <div class="form-group">
                    <input name="searchWord" type="search" class="form-control" placeholder="Søk i bloggen">
                </div>
                <button type="submit" class="btn btn-default">Søk</button>
            </form>
            <ul class="nav navbar-nav navbar-right">
                {if isset($smarty.session.loggedin)}
                    <li><a>Velkommen {$smarty.session.user->getUsername()}</a></li>
                    <li><a href="logout.php?return="{$smarty.server.REQUEST_URI}>Logg ut</a></li>
                {else}
                    <li><a href="registrerUser.php">Registrer ny bruker</a></li>
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

