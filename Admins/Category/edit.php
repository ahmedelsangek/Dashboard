<?php

    require "../helpers/functions.php";
    require "../helpers/dbConnection.php";
    require "../checkSuperAdmin.php";

    $id = sanitize($_GET['id'], 1);

    if (!validate($id, 2)){
        $message = "Invalid Int";
    }

    $sql = "select * from category where id=$id";
    $op = mysqli_query($con, $sql);
    $data = mysqli_fetch_assoc($op);


    if ($_SERVER['REQUEST_METHOD'] == 'POST'){

        $category = cleanInputs($_POST['category']);

        if (!validate($category, 1)){

            $message = "field required";

        } else {
            
            $updateSql = "update category set name='$category' where id=$id";
            $updateOp = mysqli_query($con, $updateSql);

            if ($updateOp){
                header("Location: index.php");
            } else {
                $message = mysqli_error($updateOp);
            }
        }
    }

    $_SESSION['message'] = [$message];

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
                        <h1 class="mt-4">Edit</h1>
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
                        <div class="mb-4">
                            <div class="container">
                                <h2>Category Name</h2>
                                <form method="POST" action="edit.php?id=<?php echo $data['id']; ?>">
                                    <div class="mb-3">
                                        <input value="<?php echo $data['name'] ;?>" type="text" class="form-control" id="category" name="category" require>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
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