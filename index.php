<?php
session_start();
$error = false;
require_once "dbConfig.php";
if (isset($error_message)) {
    echo $error_message;
    unset($error_message);
}
if (isset($_SESSION['user_id']) != "") {
    header("Location: profile.php");
}
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error_msg = "Please Enter Valid Email ID";
        $error = true;
    }
    if (strlen($password) < 6) {
        $password_error_msg = "Password must be minimum of 6 characters";
        $error = true;
    }
    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '" . $email . "' and password = '" . $password . "'");
    if (!$error && !empty($result)) {
        if ($row = mysqli_fetch_array($result)) {
            $_SESSION['user_id'] = $row['uid'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_mobile'] = $row['mobile'];
            header("Location: profile.php");
        }
        else {
            $error_msg = "Incorrect Email or Password!!!";
        }
    } 
    else {
        $error_msg = "Incorrect Email or Password!!!";
    }

    // if(!$error && !empty($errors)) {
    //     $sql = "INSERT INTO student_details(`name`,`phone`,`email`,`dob`,`address`,`zip`,`city`,`state`,`country`,`image`) VALUES ('$name','$phone','$email','$dob','$address','$zip','$city','$state','$country','$image')";
    //     if (mysqli_query($dbCon, $sql)) {
    //         echo "<h3>data stored in a database successfully."
    //             . " Please browse your localhost php my admin"
    //             . " to view the updated data</h3>";
    //         echo nl2br("\n$name\n $phone\n "
    //             . "$email\n $dob\n $address \n $zip\n $city\n $state \n$country \n$image");
    //     }
    //     else {
    //         echo "ERROR: Hush! Sorry $sql. "
    //             . mysqli_error($dbCon);
    //     }
    //     echo "Success";
    // }
    // else {
    //     if(isset($dob_error_msg)) {
    //         $_SESSION['dob_error_msg'] = $dob_error_msg;
    //     }
    //     if(isset($password_error_msg)) {
    //         $_SESSION['password_error_msg'] = $password_error_msg;
    //     }
    //     // header('location:addStudent.php');
    // }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Simple Login Form in PHP with Validation</title>
    <!-- FontAwesome 5 -->
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
                            <h4>Login Form with Validation</h4>
                        </div>
                        <p>Please fill all fields in the form</p>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group ">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="" maxlength="30" required="">
                                <span class="text-danger"><?php if (isset($email_error_msg)) echo $email_error_msg; ?></span>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <div class="input-group">
                                    <input type="password" id="password" name="password" class="form-control" value="" maxlength="8" required="">
                                    <button id="showPassword" class="btn btn-outline-secondary" type="button"><i class="fa fa-key" aria-hidden="true"></i></button>
                                </div>
                                <span class="text-danger"><?php if (isset($password_error_msg)) echo $password_error_msg; ?></span>
                            </div>

                            <input type="submit" class="btn btn-primary my-3" name="login" value="submit">
                            <span class="text-danger fs-6"><?php if (isset($error_msg)) echo $error_msg; ?></span>
                            <hr>
                            <div class="text-center">
                                <br> You don't have account?<a href="registration.php" class="m-3">Signup</a>
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
            $('#showPassword').on('click', function() {
                var passInput = $("#password");
                if (passInput.attr('type') === 'password') {
                    passInput.attr('type', 'text');
                    setTimeout(function() {
                        passInput.attr('type', 'password');
                    }, 3000);
                } else {
                    passInput.attr('type', 'password');
                    setTimeout(function() {
                        passInput.attr('type', 'text');
                    }, 3000);
                }
            })
        })
    </script>
</body>

</html>