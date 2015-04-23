
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
    <title>Insert title here</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <div class="jumbotron">
        <h1>Øysteins CMS</h1>
        <p>When Wordpress isn't enough</p>
    </div>
</div>
<div class="container">
    <form method="POST">
        <input type="text" name="inputName" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" name="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input name="inputPassword" type="password"  class="form-control" placeholder="Password" required>
        <input type="submit" name="btnRegisterUser" value="Register"/>
    </form>

</div> <!-- /container -->
<?php
if (isset($_POST['btnRegisterUser']))
{
    require_once ('db.php');
    User::registerUser($db, $_POST['inputEmail'], $_POST['inputPassword'], $_POST['inputName']);
}
?>
</body>
</html>