<?php

session_start();

if(isset($_SESSION['perm'])){
    header('location: status.php');
}

require_once('../../connect/connect.php');
require_once('../../connect/password.php');

$message = "";

if(isset($_POST['submit'])){
       if(!empty($_POST['user']) && !empty($_POST['pass'])){
           $sql = "SELECT ID,user_name,password,permission FROM users WHERE user_name = :user";
           $records = $conn->prepare($sql);
           $records->bindParam(':user', $_POST['user']);
           $records->execute() or die ('failed to fetch records from the database');
           $results = $records->fetch(PDO::FETCH_ASSOC);
           
           if(count($results) > 0 && password_verify($_POST['pass'], $results['password'])){
               $_SESSION['user'] = $results['user_name'];
               $_SESSION['perm'] = $results['permission'];
               if ($_SESSION['perm'] < 2){
                   header('location: control.php');
               }
               header('location: status.php');
           } else {
               $message = "Invalid login credentials";
           }
       }
}

?>

<!doctype html>
<html>
    <head>
        <title>Login</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand">AstroTech</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                  
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="logout.php">Logout</a></li>
                </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <div class="container">

            <form class="form-signin" method="POST" action="login.php">
                <h2 class="form-signin-heading">Please sign in</h2>
                <label for="inputUser" class="sr-only">Username</label>
                <input type="text" name="user" id="inputUser" class="form-control" placeholder="Username" required autofocus>
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" name="pass" id="inputPassword" class="form-control" placeholder="Password" required>
                <!--<div class="checkbox">
                <label>
                    <input type="checkbox" value="remember-me"> Remember me
                </label>
                </div>-->
                <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Sign in</button>
                <?php
                    if($message != ""){
                        echo "<p>" . $message . "</p>";
                    } 
                ?>
            </form>

        </div> <!-- /container -->

    </body>
</html>