<?php

    session_start();

    if (!isset($_SESSION['user-data'])){
        header("Location:login.php");
    }

?>