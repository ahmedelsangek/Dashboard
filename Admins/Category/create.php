<?php

    require "../helpers/functions.php";
    require "../helpers/dbConnection.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $category = cleanInputs($_POST['category']);

        if (!validate($category, 1)){
            $message = "field required";
        } else {

            $sql = "insert into category (name) values ('$category')";
            $op = mysqli_query($con, $sql);

            if ($op){
                header("Location: index.php");
            } else {
                $message = 'try again';
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
                                <h2>Add Category</h2>
                                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <div class="mb-3">
                                        <input type="text" class="form-control" id="category" name="category" require>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Create</button>
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
