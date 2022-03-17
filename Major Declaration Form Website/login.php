<?PHP
require_once('config.php');

?>

<!DOCTYPE html>
<html>

<head>
    <?php include "head.php" ?>
    <title>Login Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>


<body>

    <div>
        <?php
        session_start();
        $_SESSION["authenticated"] = false;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $inputemail   = $_POST['email'];
            $inputpassword   = $_POST['password'];


            $sql_0 = "SELECT admin_id, first_name, last_name, email, role_id FROM admin WHERE email='$inputemail' and password='$inputpassword'";
            if ($result_0 = mysqli_query($conn, $sql_0)) {
                if (mysqli_num_rows($result_0)) {
                    // Person is an admin | Admin portal
                    storeInfoOfAuthUser($result_0);
                    header("Location: admin_portal.php");
                }
            }

            $sql_1 = "SELECT student_id, first_name, last_name, email, role_id FROM student WHERE email='$inputemail' and password='$inputpassword'";
            if ($result_1 = mysqli_query($conn, $sql_1)) {
                if (mysqli_num_rows($result_1)) {
                    storeInfoOfAuthUser($result_1);
                    // Person is a student | Student portal
                    header("Location: student_portal.php");
                }
            }

            $sql_2 = "SELECT first_name, last_name, faculty_id, email, role_id FROM faculty WHERE email='$inputemail' and password='$inputpassword'";
            if ($result_2 = mysqli_query($conn, $sql_2)) {
                if (mysqli_num_rows($result_2)) {
                    storeInfoOfAuthUser($result_2);
                    // Person is in Faculty member | Faculty Portal
                    header("Location: faculty_portal.php");
                }
            }

            echo "
            <div class='mb-0 alert alert-danger alert-dismissible fade show' role='alert'>
            <i class='fa fa-exclamation-triangle'>
                Invalid Username and Password</i>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
            header("Locaiton: login.php");
        }
        function storeInfoOfAuthUser($result)
        {
            while ($r = mysqli_fetch_array($result)) {
                $_SESSION['authenticated'] = true;
                $_SESSION['email'] = $r["email"];
                $_SESSION["firstName"] = $r["first_name"];
                $_SESSION["lastName"] = $r["last_name"];
                if ($r['role_id'] == 2) {
                    $_SESSION["role"] = "faculty";
                    $_SESSION['id'] = $r['faculty_id'];
                    break;
                } else if ($r['role_id'] == 1) {
                    $_SESSION["role"] = "student";
                    $_SESSION['id'] = $r['student_id'];
                    break;
                } else if ($r['role_id'] == 3) {
                    $_SESSION["role"] = "admin";
                    $_SESSION['id'] = $r['admin_id'];
                    break;
                }
            }
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
                <img src="images/logo.png" width="100" height="100">
                <h2 class="text-center">Major/Minor Declaration Form</h2>
            </div>
        </div>

        <div class="login text-center">
            <p>Log in below using your QC Cams and Password to access the Major/Minor Declaration Form. </p>
        </div>

        <!-- Login form creation starts-->
        <div>
            <!-- row and justify-content-center class is used to place the form in center -->

            <section class="row justify-content-center">
                <section class="login-bg col-12 col-sm-6 col-md-4">

                    <form method="post" id="myForm" action='login.php' class="form-container">
                        <div class="form-group">
                            <h4 class="text-center font-weight-bold"> Login </h4>
                            <input name="email" type="email" class="form-control" id="email" aria-decribeby="emailHelp" placeholder="Enter email">
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                        </div>

                        <button type="submit" class="btn btn-bg btn-block">Submit</button><br>
                        <div class="form-footer">
                            <p> Don't have an account? <a href="registration.php">Sign Up</a></p>
                        </div>
                    </form>
                </section>
            </section>
            <!-- Login form creation ends -->
        </div>
        <?php include "footer.php" ?>
    </div>
</body>

</html>
<?php $conn->close(); ?>