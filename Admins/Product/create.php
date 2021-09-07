<?php

    require "../helpers/functions.php";
    require "../checkUser.php";
    require "../helpers/dbConnection.php";

    //Get Admins
    $adminSql = "select * from admin";
    $adminOp = mysqli_query($con, $adminSql);


    //Get Categories
    $categorySql = "select * from category";
    $categoryOp = mysqli_query($con, $categorySql);

    $errors = [];


    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name = cleanInputs($_POST['name']);
        $admin = sanitize($_POST['admin'], 1);
        $cat = sanitize($_POST['cat'], 1);

        $imageName = $_FILES['image']['name'];
        $imagetype = $_FILES['image']['type'];
        $tmp = $_FILES['image']['tmp_name'];

        $typeArray = explode("/", $imagetype);
        $excetion = end($typeArray);
        $newImageName = rand() . time() . "." . $excetion;


        $imageExcetionAllow = ["png", "jpg", "jpeg"];

        //Check If Excetion Exict
        if (in_array($excetion, $imageExcetionAllow)){
            $imageFolder = "../Design/assets/img/";
            $finalImageName = $imageFolder . $newImageName;

            //Transfer image from tmp folder to destination folder
            if (move_uploaded_file($tmp, $finalImageName)){
                echo "Image Uploaded Done" . "</br>";
            } else {
                echo "Error On Upload, Please Try Again Later";
            }
        } else {
            echo "invalid Image Excetion";
        }

        if (!validate($name, 1)){
            $errors['name'] = "Name Field Required";
        }

        if (!validate($admin, 2)){
            $errors['admin'] = "Invalid Role Id";
        }

        if (!validate($cat, 2)){
            $errors['cat'] = "Invalid Category Id";
        }


        if (count($errors) > 0){
            $_SESSION['message'] = $errors;
        } else {

            $sql = "insert into product (name, image, added_by, cat_id) values ('$name','$finalImageName', $admin, $cat)";
            $op = mysqli_query($con, $sql);
            if ($op){
                header("Location: index.php");
            } else {
                echo mysqli_error($con);
            }
        }
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
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <?php
                                if (isset($_SESSION['message'])){
                                    foreach ($_SESSION['message'] as $value) {
                                        # code...
                                        echo '<li class="breadcrumb-item active">'. $value .'</li>';
                                        unset($_SESSION['message']);
                                    }
                                } else {
                                    echo '<li class="breadcrumb-item active">Dashboard</li>';
                                }
                            ?>
                        </ol>
                        <div class="mb-4">
                            <div class="container">
                                <h2>Add Product</h2>
                                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" require>
                                    </div>
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Choose Image</label>
                                        <input type="file" class="form-control" id="image" name="image" require>
                                    </div>
                                    <div class="mb-3">
                                        <label for="admin" class="form-label">Added By</label>
                                        <select class="form-select" aria-label="Default select example" id="admin" name="admin">
                                            <option selected>Open this select menu</option>
                                            <?php while ($adminData = mysqli_fetch_assoc($adminOp)){ ?>
                                                <option value="<?php echo $adminData['id'];?>"><?php echo $adminData['name'];?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="cat" class="form-label">Category</label>
                                        <select class="form-select" aria-label="Default select example" id="cat" name="cat">
                                            <option selected>Open this select menu</option>
                                            <?php while ($categoryData = mysqli_fetch_assoc($categoryOp)){ ?>
                                                <option value="<?php echo $categoryData['id'];?>"><?php echo $categoryData['name'];?></option>
                                            <?php } ?>
                                        </select>
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
