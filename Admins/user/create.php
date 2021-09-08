<?php

    require "../helpers/functions.php";
    require "../checkSuperAdmin.php";
    require "../helpers/dbConnection.php";

    //Get All Roles
    $sql = "SELECT * FROM roles";
    $op = mysqli_query($con, $sql);

    if (!$op){
        echo "try again";
    }

    $errors = [];


    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name = cleanInputs($_POST['name']);
        $email = cleanInputs($_POST['email']);
        $password = sha1($_POST['password']);
        $role = $_POST['role'];

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
            $insertSql = "insert into admin (name, email, password, role) values ('$name', '$email', '$password', $role)";
            $insertOp = mysqli_query($con, $insertSql);

            if ($insertOp){
                header("Location: index.php");
            } else {
                echo 'try again';
            }
        }
    }

    if (isset($_SESSION['message'])){
        foreach ($_SESSION['message'] as $value) {
            echo $value . "</br>";
        }
        unset($_SESSION['message']);
    } else {
        echo "";
    }

    mysqli_close($con);
?>


<!DOCTYPE html>
<html lang="en">
    <?php require "../head.php";?>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Account</h3></div>
                                    <div class="card-body">
                                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input type="text" class="form-control" id="name" name="name" require>
                                                        <label for="name" class="form-label">Name</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" id="email" name="email" require>
                                                <label for="email" class="form-label">Email</label>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input type="password" class="form-control" id="password" name="password" require>
                                                        <label for="password" class="form-label">Password</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        
                                                        <select class="form-select" aria-label="Default select example" id="role" name="role">
                                                            <option selected></option>
                                                            <?php while ($data = mysqli_fetch_assoc($op)){ ?>
                                                                <option value="<?php echo $data['id'];?>"><?php echo $data['name'];?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <label for="role" class="form-label">Role</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 mb-0">
                                            <button type="submit" class="btn btn-primary btn-block">Create</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="login.php">Have an account? Go to login</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <?php require "../footer.php";?>
            </div>
        </div>
        <?php require "../scripts.php";?>
    </body>
</html>
