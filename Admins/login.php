<?php

    require "../Admins/helpers/functions.php";
    require "../Admins/helpers/dbConnection.php";

    $errors = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $email = cleanInputs($_POST['email']);
        $password = cleanInputs($_POST['password']);

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

            $sql = "select * from admin where email='$email' and password='$password'";
            $op = mysqli_query($con, $sql);

            if (mysqli_num_rows($op) > 0){
                $data = mysqli_fetch_assoc($op);
                $_SESSION['user-data'] = $data;
                header("Location: index.php");
            } else {
                echo "Invalid Email Or Password";
            }
        }
    }

    mysqli_close($con);


?>

<!DOCTYPE html>
<html lang="en">
    <?php require "./head.php"; ?>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" name="email" type="email" placeholder="Enter Your Email" />
                                                <label for="inputEmail">Email address</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Password" />
                                                <label for="inputPassword">Password</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button type="submit" class="btn btn-primary btn-block">Create</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="../Admins/user/create.php">Need an account? Sign up!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <?php require "./footer.php"; ?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
