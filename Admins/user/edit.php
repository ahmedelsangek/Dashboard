<?php

    require "../helpers/functions.php";
    require "../helpers/dbConnection.php";

    $id = sanitize($_GET['id'], 1);

    if (!validate($id, 2)){
        $errors['name'] = "Invalid Int";
    }

    //Get All Admins
    $sql = "select * from admin where id=$id";
    $op = mysqli_query($con, $sql);
    $data = mysqli_fetch_assoc($op);


    //Get All roles
    $rolesSql = "select * from roles";
    $rolesOp = mysqli_query($con, $rolesSql);

    $errors = [];


    if ($_SERVER['REQUEST_METHOD'] == 'POST'){

        $name = cleanInputs($_POST['name']);
        $email = cleanInputs($_POST['email']);
        $password = cleanInputs($_POST['password']);
        $role = cleanInputs($_POST['role']);

        if (!validate($name, 1)){
            $errors['name'] = "Name field required";
        } elseif (!validate($name, 3)){
            $errors['name'] = "Invalid Name";
        }


        if (!validate($email, 1)){
            $errors['email'] = "Email field required";
        } else if (!validate($email, 4)){
            $errors['email'] = "Invalid Email";
        } 

        if (!validate($password, 1)){
            $errors['password'] = "Password field required";
        } else if (!validate($password, 5)){
            $errors['password'] = "Password shoud at last 6 character";
        }



        if (count($errors) > 0){
            $_SESSION['message'] = $errors;
        } else {
            $updateSql = "update admin set name='$name', email='$email', password='password', role=$role where id=$id";
            $updateOp = mysqli_query($con, $updateSql);

            if ($updateOp){
                header("Location: index.php");
            } else {
                echo "Try Again";
            }
        }


    }

    // $_SESSION['message'] = [$message];

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
                                <form method="POST" action="edit.php?id=<?php echo $data['id']; ?>">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" value="<?php echo $data['name']; ?>" class="form-control" id="name" name="name" require>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text" value="<?php echo $data['email']; ?>" class="form-control" id="email" name="email" require>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" value="<?php echo $data['password']; ?>" class="form-control" id="password" name="password" require>
                                    </div>
                                    <div class="mb-3">
                                        <label for="role" class="form-label">Role</label>
                                        <select class="form-select" aria-label="Default select example" id="role" name="role">
                                            <?php while ($rolesData = mysqli_fetch_assoc($rolesOp)){ ?>
                                                <option value="<?php echo $rolesData['id'];?>" <?php if($data['role'] == $rolesData['id']){echo 'selected';} ;?>><?php echo $rolesData['name'];?></option>
                                            <?php } ?>
                                        </select>
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