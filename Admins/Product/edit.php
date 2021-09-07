<?php

    require "../helpers/functions.php";
    require "../helpers/dbConnection.php";

    $id = sanitize($_GET['id'], 1);

    if (!validate($id, 2)){
        $errors['name'] = "Invalid Int";
    }

    //Get Admins
    $adminSql = "select * from admin";
    $adminOp = mysqli_query($con, $adminSql);

    //Get Categories
    $categorySql = "select * from category";
    $categoryOp = mysqli_query($con, $categorySql);

    //Get Products
    $productSql = "select * from product where id=$id";
    $productOp = mysqli_query($con, $productSql);
    $productData = mysqli_fetch_assoc($productOp);

    $currentImage = $productData['image'];

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
            move_uploaded_file($tmp, $finalImageName);
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

            if (empty($imageName)){
                $finalImageName = $currentImage;
            } else {
                unlink($currentImage);
            }

            $updateSql = "update product set name='$name', image='$finalImageName', added_by=$admin, cat_id=$cat where id=$id";
            $updateOp = mysqli_query($con, $updateSql);

            if ($updateOp){
                header("Location: index.php");
            } else {
                echo "Try Again";
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
                        <h1 class="mt-4">Edit Role</h1>
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
                                <h2>Role Name</h2>
                                <form method="POST" action="edit.php?id=<?php echo $productData['id']; ?>" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" value="<?php echo $productData['name']?>" class="form-control" id="name" name="name" require>
                                    </div>
                                    <div class="mb-3">
                                    <img width="50" height="50" src="<?php echo $productData['image'] ;?>" alt="">
                                        <label for="image" class="form-label">Choose New Image</label>
                                        <input type="file" class="form-control" id="image" name="image" require>
                                    </div>
                                    <div class="mb-3">
                                        <label for="admin" class="form-label">Added By</label>
                                        <select class="form-select" aria-label="Default select example" id="admin" name="admin">
                                            <option selected>Open this select menu</option>
                                            <?php while ($adminData = mysqli_fetch_assoc($adminOp)){ ?>
                                                <option <?php if ($productData['added_by'] == $adminData['id']){echo 'selected';}?> value="<?php echo $adminData['id'];?>"><?php echo $adminData['name'];?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="cat" class="form-label">Category</label>
                                        <select class="form-select" aria-label="Default select example" id="cat" name="cat">
                                            <option selected>Open this select menu</option>
                                            <?php while ($categoryData = mysqli_fetch_assoc($categoryOp)){ ?>
                                                <option <?php if ($productData['cat_id'] == $categoryData['id']){echo 'selected';}?> value="<?php echo $categoryData['id'];?>"><?php echo $categoryData['name'];?></option>
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