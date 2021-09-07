<?php

    require "../helpers/dbConnection.php";

    //Get All Roles
    $sql = "SELECT * FROM category";
    $op = mysqli_query($con, $sql);

    if (!$op){
        $error = mysqli_error($con);
        $_SESSION['message'] = [$error];
    }

    mysqli_close($con);
?>



<!DOCTYPE html>
<html lang="en">
    <?php require "../head.php"; ?>
    <body class="sb-nav-fixed">
        <?php require "../nav.php"; ?>
        <div id="layoutSidenav">
            <?php require "../sidenav.php"; ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Display Roles</h1>
                        <ol class="breadcrumb mb-4">
                            <?php
                                if (isset($_SESSION['message'])){
                                    foreach ($_SESSION['message'] as $value) {
                                        # code...
                                        echo '<li class="breadcrumb-item active">'. $value .'</li>';
                                    }
                                } else {
                                    echo '<li class="breadcrumb-item active">Dashboard</li>';
                                }
                            ?>
                        </ol>
                        <div class="row">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                DataTable Example
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Options</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Options</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php $i = 1; while($data = mysqli_fetch_assoc($op)){ ?>
                                            <tr>
                                                <th><?php echo $i++ ;?></th>
                                                <th><?php echo $data['name'] ;?></th>
                                                <th>
                                                    <a class="btn btn-primary" href="edit.php?id=<?php echo $data['id'] ;?>">Edit</a>
                                                    <a class="btn btn-danger" href="delete.php?id=<?php echo $data['id'];?>">Delete</a>
                                                </th>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <?php require "../footer.php"; ?>
            </div>
        </div>
        <?php require "../scripts.php"; ?>
    </body>
</html>
