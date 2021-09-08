<?php

    require "../helpers/functions.php";
    require "../helpers/dbConnection.php";
    require "../checkSuperAdmin.php";

    $id = sanitize($_GET['id'], 1);

    if (!validate($id, 2)){

        $message = "invalid Int";

    } else {
        $sql = "delete from category where id=$id";
        $op = mysqli_query($con, $sql);

        if ($op){
            $message = "Item Deleted";
        } else {
            $message = mysqli_error($con);
        }
    }

    $_SESSION['message'] = [$message];
    header("Location: index.php");

    mysqli_close($con);
?>