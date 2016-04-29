<?php

    session_start();
    
    if (isset($_SESSION['perm'])){
        if($_SESSION['perm'] > 2){
            header('location: status.php');
        }
    }else{
        header('location: login.php');
    }
    
    require_once('../../connect/connect.php');
    require_once('../../connect/password.php');
    $message = "";
    
    if(isset($_POST['submit'])){
        if($_POST['pass'] === $_POST['pass2']){
            $sql = "INSERT INTO users (user_name,password,permission) VALUES (:user,:pass,:perm)";
            $stmt = $conn->prepare($sql);
            $pass = password_hash($_POST['pass'],PASSWORD_BCRYPT);
            $stmt->bindParam(':user',$_POST['user']);
            $stmt->bindParam(':pass',$pass);
            $stmt->bindParam(':perm',$_POST['level']);
            $stmt->execute() or die('failed to insert data');
        }else{
            $message = "passwords do not match";
        }
    }

?>

<!doctype html>
<html>
    <head>
        <title>Create User</title>
        <meta charset="utf-8"/>
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
                    <?php
                        if($_SESSION['perm'] >= 2){
                            echo "<li><a href=\"control.php\">Control</a></li>";
                        }
                    ?>
                    <li><a href="logout.php">Logout</a></li>
                    
                </ul>
                <ul class="nav navbar-nav navbar-right">
                </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        
        
         <div class="container">
            <form class="form-signin" method="POST" action="createUser.php">
                <h2 class="form-signin-heading">Create a User</h2>
                <label for="inputUser" class="sr-only">Username</label>
                <input type="text" name="user" id="inputUser" class="form-control" placeholder="Username" required autofocus>
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" name="pass" id="inputPassword" class="form-control" placeholder="Password" required>
                <label for="inputPassword" class="sr-only">Confirm Password</label>
                <input type="password" name="pass2" id="inputPassword2" class="form-control" placeholder="Confirm" required>
                <select name="level">
                    <option value="3">User</option>
                    <option value="2">Admin</option>
                </select>
                <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Create User</button>
                <?php
                    if($message != ""){
                        echo "<p>" . $message . "</p>";
                    } 
                ?>
            </form>
        </div> <!-- /container -->
    </body>
</html>