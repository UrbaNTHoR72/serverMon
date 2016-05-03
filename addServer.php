<?php

    session_start();
    
    require_once('../../connect/connect.php');

    if(isset($_SESSION['perm'])){
        if($_SESSION['perm'] > 2){
            header('location: status.php');
        }
    } else{
        header('location: login.php');
    }
    
    //delete server
    if(isset($_POST['submit2'])){
        $sql = "DELETE FROM servers WHERE server_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $_POST['rem_server']);
        $stmt->execute() or die('failed to remove entry from table');
    }
    
    if(isset($_POST['submit'])){
        $sql = "INSERT INTO servers (server_ip,port,label,type,status,run_time) VALUES (:serip,:port,:label,:type,'off',0.0)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':serip', $_POST['server_ip']);
        $stmt->bindParam(':port', $_POST['port']);
        $stmt->bindParam(':label', $_POST['server_name']);
        $stmt->bindParam(':type', $_POST['type']);
        
        $stmt->execute() or die('failed to add new server');
    
    
    }
    
    
?>

<!doctype html>
<html>
    <head>
        <title>Add a Server</title>
        <meta charset = "utf-8"/>
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
                        if($_SESSION['perm'] <= 2){
                            echo "<li><a href=\"control.php\">Control</a></li>";
                        }
                    ?>
                    <li><a href="status.php">Status</a></li>
                    
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="logout.php">Logout</a></li>
                </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-xs-12">
                    <form method="POST" action="addServer.php">
                        <ul>
                            <li><label for="server_name">Server Name</label><input type="text" name="server_name"></li>
                            <li><label for="server_ip">Server IP</label><input type="text" name="server_ip"></li>
                            <li><label for="port">Port</label><input type="text" name="port"></li>
                            <li>
                                <label for="type">Server Type</label>
                                <select name="type">
                                    <option value="1">Website</option>
                                    <option value="2">Service</option>
                                </select>
                            </li>
                            <li><input type="submit" name="submit" value="Add Server"></li>
                        </ul>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <form method="POST" action="addSercer.php">
                        <input type="text" placeholder="Server id" name="rem_server"/>
                        <input type="submit" name="submit2" value="Delete"/>
                    </form>
                    <table>
                        <?php
                            $stat = "SELECT server_id,label,server_ip,status FROM servers";
                            $results = $conn->prepare($stat);
                            $results->execute() or die('failed to read servers from database');
                            echo "<ul>";
                            while($row = $results->fetch(PDO::FETCH_ASSOC)){
                                echo "<li>" . $row['server_id'] . "</li><li>";
                                echo "<ul><li>" . $row['label'] . "</li><li>" . $row['server_ip'] . "</li><li>" . $row['status'] . "</li></ul>";
                                echo "</li>";
                            }
                            echo "</ul>";
                        ?>
                    </table>
                </div>
                
            </div>
        </div>        
    </body>
</html>