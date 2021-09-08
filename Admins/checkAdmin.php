<?php

    if (isset($_SESSION['user-data'])){
        if ($_SESSION['user-data']['role_name'] != "Admin"){
            echo "<script type=\"text/javascript\">
            alert('You Should Login as Admin');
            window.location.href = 'http://localhost/PHP_Dashboard/Admins/index.php';
            </script>";
        }
    }

?>