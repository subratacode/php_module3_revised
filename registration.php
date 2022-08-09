<?php
require_once "dbConfig.php";
$error = false;
if (isset($_SESSION['user_id']) != "") {
    header("Location: dashboard.php");
}
if (isset($_POST['signup'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // echo $password;

    if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
        $name_error = "Name must contain only alphabets and space";
        $error = true;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Please Enter Valid Email ID";
        $error = true;
    }
    else {
        // if email is already existing, then generate error respectively
    }

    if (!preg_match('/^(?=.*[!@#$%&])[0-9A-Za-z!@#$%&]{6,12}$/', $password)) {
        $password_error = "Password must be minimum of 6 characters and atleast one special character";
        $error = true;
    }

    if (strlen($mobile) < 10) {
        $mobile_error = "Mobile number must be minimum of 10 characters";
        $error = true;
    }
    else {
        // if mobile is already existing, then generate error respectively
    }

    if ($password != $cpassword) {
        $cpassword_error = "Password and Confirm Password doesn't match";
        $error = true;
    }

    if (!$error) {
        if (mysqli_query($conn, "INSERT INTO users(`name`, `email`, `mobile`, `password`) VALUES('" . $name . "', '" . $email . "', '" . $mobile . "', '" . $password . "')")) {
            // header("location: login.php");
            exit();
        } else {
            echo "Error: " . $sql . "" . mysqli_error($conn);
        }
    }
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Simple Registration Form in PHP with Validation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>

<body style="background-image: url('images/background.jpg');">
    <div class="d-flex align-items-center justify-content-center my-5">
        <div class="card my-5 shadow">
            <div class="card-header text-center text-light fw-bold bg-primary">
                Welcome to CodeArts
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="page-header">
                            <h4>Registration Form with Validation</h4>
                        </div>
                        <p>Please fill all fields in the form</p>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" value="" maxlength="50" required="">
                                <span class="text-danger"><?php if (isset($name_error)) echo $name_error; ?></span>
                            </div>
                            <div class="form-group ">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="" maxlength="30" required="">
                                <span class="text-danger"><?php if (isset($email_error)) echo $email_error; ?></span>
                            </div>
                            <div class="form-group">
                                <label>Mobile</label>
                                <input type="text" name="mobile" class="form-control" value="" maxlength="12" required="">
                                <span class="text-danger"><?php if (isset($mobile_error)) echo $mobile_error; ?></span>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <div class="input-group">
                                    <input type="password" id="password" name="password" class="form-control" value="" maxlength="8" required="">
                                    <button id="showPassword" class="btn btn-outline-secondary" type="button"><i class="fa fa-key" aria-hidden="true"></i></button>
                                </div>
                                <span class="text-danger"><?php if (isset($password_error_msg)) echo $password_error_msg; ?></span>
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <div class="input-group">
                                    <input type="password" id="cpassword2" name="cpassword" class="form-control" value="" maxlength="8" required="">
                                    <button id="showPassword2" class="btn btn-outline-secondary" type="button"><i class="fa fa-key" aria-hidden="true"></i></button>
                                </div>
                                <span class="text-danger"><?php if (isset($cpassword_error_msg)) echo $cpassword_error_msg; ?></span>
                            </div>
                            <input type="submit" class="btn btn-primary my-3" name="signup" value="submit">
                            <hr>
                            <div class="text-center">
                                <br> Already have a account?<a href="index.php" class="mx-3">Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#showPass').on('click', function() {
                var passInput = $("#password");
                if (passInput.attr('type') === 'password') {
                    passInput.attr('type', 'text');
                } else {
                    passInput.attr('type', 'password');
                }
            });
            $('#showPass2').on('click', function() {
                var passInput = $("#cpassword");
                if (passInput.attr('type') === 'password') {
                    passInput.attr('type', 'text');
                } else {
                    passInput.attr('type', 'password');
                }
            });
        })
    </script>
</body>

</html>