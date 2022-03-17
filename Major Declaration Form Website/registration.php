<?PHP
require_once('config.php');
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "head.php" ?>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div>
        <?php
        if (isset($_POST['create'])) {
            $firstname   = $_POST['firstname'];
            $lastname   = $_POST['lastname'];
            $email       = $_POST['email'];
            $phonenumber = $_POST['phonenumber'];
            $password     = $_POST['password'];
            $role_id = $_POST['role'];

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            if ($role_id == 0) {
                echo "
                <div class='mb-0 alert alert-danger alert-dismissible fade show' role='alert'>
                <i class='fa fa-exclamation-triangle'>
                    Error: Something went wrong. User Registration failed.</i>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
                ";
                header("Locaiton: registration.php");
            } else {
                if ($role_id == 1) {
                    $sql =  "insert into student (first_name, last_name, email, form_status, phone, password, form_id, role_id) VALUES ('$firstname', '$lastname', '$email', 'Not started yet', '$phonenumber', '$password', null, $role_id)";
                } else if ($role_id == 2) {
                    $sql =  "insert into faculty (first_name, last_name, email, phone, password, role_id) VALUES ('$firstname', '$lastname', '$email', '$phonenumber', '$password', $role_id)";
                }
                if ($conn->query($sql)  === TRUE) {
                    header("Location: login.php");
                } else {
                    echo "
                    <div class='mb-0 alert alert-danger alert-dismissible fade show' role='alert'>
                    <i class='fa fa-exclamation-triangle'>
                        Error: Something went wrong. User Registration failed.</i>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
                    ";
                    header("Locaiton: registration.php");
                }
            }

            $conn->close();
        }

        ?>

    </div>
    <nav class="navbar navbar-bg bg-light">
        <div class="container">
            <a class="navbar-brand" href="login.php">
                <img src="images/mainlogo.png" alt="" width="135" height="44">
            </a>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <img src="images/logo.png" width="100" height="100" class="logo-bg center">
            </div>
        </div>
        <section class="row">
            <div class="login-bg col-12 col-sm-6 offset-md-4 col-md-4 offset-lg-4 col-lg-4">
                <h5 class="text-center">Registration</h5>
                <form id="myRegForm" action="registration.php" method="post">
                    <input class="mt-2 form-control form-control-sm" placeholder="First Name" type="text" id="firstname" name="firstname">

                    <input class="mt-2 form-control form-control-sm" placeholder="Last Name" type="text" id="lastname" name="lastname">

                    <input class="mt-2 form-control form-control-sm" placeholder="Email" type="email" id="email" name="email">

                    <input class="mt-2 form-control form-control-sm" placeholder="Phone No." type="text" id="phone" name="phonenumber">

                    <input class="mt-2 form-control form-control-sm" placeholder="Password" type="password" id="password" name="password">
                    <hr class="mb-3">


                    <div class="row">
                        <div class="col col-md-6 col-lg-6">
                            <select class="form-select" id="role" name="role">
                                <option value="0">Select a role</option>
                                <option value="1">Student</option>
                                <option value="2">Faculty</option>
                            </select>
                        </div>
                        <div class="col col-md-6 col-lg-6">
                            <input class="btn-bg form-control btn btn-primary" type="submit" name="create" value="Sign Up">
                        </div>
                    </div><br>
                    <p> Already have an account? <a href="login.php">Log In</a></p>
                </form>
            </div>
        </section>
    </div>
    <?php include "footer.php" ?>

</body>

</html>