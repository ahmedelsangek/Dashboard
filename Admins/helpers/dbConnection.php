<?php
    $server = "localhost";
    $dbName = "php-dashboard";
    $name = "root";
    $password = "";

    $con = mysqli_connect($server, $name, $password, $dbName);

    if (!$con){
        die("Error: " . mysqli_error());
    }
?>