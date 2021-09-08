<?php

    if (!isset($_SESSION['user-data'])){
        header("Location: http://localhost/PHP_Dashboard/Admins/login.php");
    }

?>