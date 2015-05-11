<!DOCTYPE html>
<html lang="en" >
<head>
    <title>Cobal</title>
    <link rel="icon" type="image/png" href="img/Spaceslug.png">
    <meta charset="utf-8">
    <meta name="author" content="Laget av Øystein Danielsen og Håvard Stien">
    <link rel="stylesheet" href="bootstrap-3.3.4-dist/css/bootstrap.css">
    <!-- Optional theme -->
    <!--link rel="stylesheet" href="bootstrap-3.3.4-dist/css/bootstrap-theme.css"-->
    <!-- Latest compiled and minified JavaScript -->
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="bootstrap-3.3.4-dist/js/bootstrap.js"></script>
</head>
<body>
    <div class="container">
    <div class="page-header">
        <h1>Cobal<small> Ideas about space</small></h1>
    </div>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Hjem</a></li>
                {if isset($smarty.session.user) && $smarty.session.user->isAdmin()}
                    <li><a href="addPost.php">Legg til innlegg</a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-expanded="false">Søppelboks <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="manageComments.php">Slettede kommentarer</a></li>
                            <li><a href="deletedPosts.php">Slettede innlegg</a></li>
                        </ul>
                    </li>

                {/if}
            </ul>
            <form class="navbar-form navbar-right" role="search" action="index.php" method="get">
                <div class="form-group">
                    <input name="searchWord" type="search" class="form-control" placeholder="Søk i bloggen">
                </div>
                <button type="submit" class="btn btn-default">Søk</button>
            </form>
            <ul class="nav navbar-nav navbar-right">
                {if isset($smarty.session.user)}
                    <li><a href="manageAccount.php">Velkommen {$smarty.session.user->getUsername()}</a></li>
                    <li><a href="logout.php?returnToPage="{$smarty.server.REQUEST_URI}>Logg ut</a></li>
                {else}
                    <li><a href="registrerUser.php">Registrer ny bruker</a></li>
                    <li><a href="login.php">Logg inn</a></li>
                {/if}
            </ul>
        </div>
    </nav>
        <div>

{include file='alert.tpl'}

