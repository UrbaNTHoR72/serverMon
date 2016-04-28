<?php

    session_start();
    
    $message = "no session";

    if (isset($_SESSION['perm'])){
        if ($_SESSION['perm'] <= 2){
            $message = "the perm is \"" . $_SESSION['perm'] . "\" so congrats";
        }else{
            $message = "foobar";
        }
        
    }else {
        header('location: index.php');
    }
?>

<!doctype html>
<html>
    <head>
        <title>Control Panel</title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php
                echo "<p>" . $message . "<p>";
        ?>
    </body>
</html>
        