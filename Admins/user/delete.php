<?php

    require "../helpers/functions.php";
    require "../helpers/dbConnection.php";

    $id = sanitize($_GET['id'], 1);

    if (!validate($id, 2)){

        $message = "invalid Int";

    } else {
        $sql = "delete from admin where id=$id";
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