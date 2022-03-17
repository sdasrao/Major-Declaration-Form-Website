<?PHP
require_once('config.php');
?>

<?php
session_start();
if ($_SESSION['authenticated'] == false) {
  header("Location: login.php");
}

$current_user = $_SESSION["email"];
$isFaculty = false;
$sql = "";

if ($_SESSION["role"] == "admin") {
  $sql = "select first_name, last_name, email, phone from admin";
} else {
  if ($_GET["id"] !== "" && $_SESSION["role"] == "faculty") {
    $isFaculty = true;
    $sql = "select student_id, first_name, last_name, email, form_status, phone from student where student_id=" . $_GET['id'];
  } else if ($_SESSION["role"] == "student") {
    $sql = "select student_id, first_name, last_name, email, form_status, phone from student where email='$current_user'";
  } else if ($_SESSION["role"] == "faculty") {
    $sql = "select faculty_id, first_name, last_name, email, phone from faculty where email='$current_user'";
  }
}

// $sql2 = "select student_id, first_name, last_name, email, form_status, phone from student where student_id='" . $_GET["id"] . "'";
$result = $conn->query($sql);

//update date database
//$sql = "UPDATE 'stusent' SET  "

if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql2 = "";
  if ($_SESSION["role"] == "student") {
    $sql2 =  "update student set email = '$email', phone = '$phone' where email='$current_user'";
  } else if ($_SESSION["role"] == "faculty") {
    $sql2 =  "update faculty set email = '$email', phone = '$phone' where email='$current_user'";
  }


  if ($conn->query($sql2) === TRUE && $_SESSION["role"] == "student") {
    header("Location: student_portal.php");
  } else if ($conn->query($sql2) === TRUE && $_SESSION["role"] == "faculty") {
    header("Location: faculty_portal.php");
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $_SESSION["email"] = $email;
}

?>

<!DOCTYPE html>

<html lang="en" dir="ltr">
<html lang="en">

<head>
  <?php include "head.php" ?>
</head>

<body>
  <nav class="navbar navbar-bg bg-light">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="images/mainlogo.png" alt="" width="135" height="44">
      </a>
    </div>
  </nav>
  <div class="container"><br>
    <div class="row">
      <div class="col text-center">
        <h3 class="title">Profile Information</h3><br>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12 col-md-4 offset-md-4 col-lg-4 offset-lg-4">
        <?php while ($row = mysqli_fetch_array($result)) { ?>
          <form action="personinfo.php" method="POST">
            <label class="form-label">Last Name</label>
            <input type="text" class="form-control form-control-sm" placeholder="Enter your Last name" value="<?php echo $row["last_name"] ?>" disabled>
            <label class="form-label">First Name</label>
            <input type="text" class="form-control form-control-sm" placeholder="Enter your First name" value="<?php echo $row["first_name"] ?>" disabled>
            <label class="form-label">CUNY EMPLOYD ID</label>
            <input type="text" class="form-control form-control-sm" placeholder="Enter your ID" value="<?php echo $_SESSION["id"] ?>" disabled>
            <label class="form-label">Email</label>
            <input name="email" class="form-control form-control-sm" type="text" placeholder="Enter your email" value="<?php echo $row["email"] ?>" required <?php echo $isFaculty ? "disabled" : "" ?> />
            <label class="form-label">Phone Number</label>
            <input name="phone" class="form-control form-control-sm" type="text" placeholder="Enter your number" value="<?php echo $row["phone"] ?>" required <?php echo $isFaculty ? "disabled" : "" ?> />

            <br>
            <div class="row">

              <?php if (!$isFaculty) { ?>
                <div class="col col-md-6 col-lg-6">
                  <input name="submit" class="btn btn-form form-control form-control-sm" type="submit" value="Update" />
                </div>
              <?php } ?>

              <div class="col col-md-6 col-lg-6">
                <?php if ($_SESSION["role"] == "student") { ?>
                  <a class="btn btn-exit form-control form-control-sm" href="student_portal.php">Cancel</a>
                <?php } ?>

                <?php if ($_SESSION["role"] == "faculty") { ?>
                  <a class="btn btn-exit form-control form-control-sm" href="faculty_portal.php">Close</a>
                <?php } ?>
                <?php if ($_SESSION["role"] == "admin") { ?>
                  <a class="btn btn-exit form-control form-control-sm" href="admin_portal.php">Close</a>
                <?php } ?>
              </div>
            </div>
          </form>
        <?php } ?>
      </div>
    </div>
  </div>
  <?php include "footer.php" ?>
</body>

</html>

<?php $conn->close(); ?>