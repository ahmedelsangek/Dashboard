<?php
    $server = "localhost";
    $dbName = "php-dashboard";
    $name = "root";
    $password = "";

    $con = mysqli_connect($server, $name, $password, $dbName);

    if ($con){
        echo "Connection done";
        $_SESSION['message'] = ['Connection done'];
    } else {
        die("Error: " . mysqli_error());
    }
?>