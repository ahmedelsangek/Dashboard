<?php

    require "../helpers/functions.php";
    require "../helpers/dbConnection.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $role = cleanInputs($_POST['role']);

        $errors = [];

        if (validate($role, 1)){
            $errors['name'] = "field required";
        }

        if (count($errors) > 0){
            $_SESSION['message'] = $errors;
        } else {
            $sql = "insert into roles (name) values ('$role')";
            $op = mysqli_query($con, $sql);

            if ($op){
                header("Location: index.php");
            } else {
                $_SESSION['message'] = ['try again'];
            }
        }
    }



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
                        <h1 class="mt-4">Dashboard</h1>
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
                                <h2>Add Role Name</h2>
                                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <div class="mb-3">
                                        <input type="text" class="form-control" id="role" name="role" require>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
