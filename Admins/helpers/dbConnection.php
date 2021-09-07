<?php
    $server = "localhost";
    $dbName = "php-dashboard";
    $name = "root";
    $password = "";

    $con = mysqli_connect($server, $name, $password, $dbName);

    if ($con){
        $_SESSION['message'] = ['Connection done'];
    } else {
        die("Error: " . mysqli_error());
    }
?>