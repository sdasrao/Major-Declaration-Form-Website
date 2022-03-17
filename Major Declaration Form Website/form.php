<?PHP
require_once('config.php');
?>

<?php
session_start();
if ($_SESSION['authenticated'] == false) {
  header("Location: login.php");
}

$isFaculty = false;
$role = $_SESSION["role"];

// Create form when user is student or User login as a student role
if (isset($_POST['create'])) {
  $declaring_major   = $_POST['declaring_major'];
  // $Concentration   = $_POST['declaring_major'];
  //$SeysSig   = $_POST['declaring_major'];
  $declaring_minor   = $_POST['declaring_minor'];
  //$DeptSignature   = $_POST['faculty_signiture'];
  $major_change_from   = $_POST['major_change_from'];
  $major_change_to   = $_POST['major_change_to'];
  $minor_change_from  = $_POST['minor_change_from'];
  $minor_change_to   = $_POST['minor_change_to'];
  $drop_major   = $_POST['drop_major'];
  $drop_minor   = $_POST['drop_minor'];
  $adding_major   = $_POST['adding_major'];
  $adding_minor   = $_POST['adding_minor'];

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $formId = uniqid();

  $sql =  "insert into form (form_id, declaring_major, declaring_minor, major_change_from, major_change_to, minor_change_from, minor_change_to, drop_major, drop_minor, adding_major, adding_minor)
                VALUES ('$formId', '$declaring_major', '$declaring_minor', '$major_change_from', '$major_change_to', '$minor_change_from', '$minor_change_to', '$drop_major', '$drop_minor', '$adding_major','$adding_minor' )";

  if ($conn->query($sql)  === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }


  $current_user = $_SESSION["email"];
  $sql2 = "update student set form_id='$formId', form_status='pending' where email='$current_user'";
  if ($conn->query($sql2)  === TRUE) {
    echo "New record updated successfully";
    header("Location: student_portal.php");
  } else {
    echo "Error: " . $sql2 . "<br>" . $conn->error;
  }

  $conn->close();
}
// End


if (isset($_POST["accepted"])) {
  $studentID = $_POST["sid"];
  $formID = $_POST["fid"];
  $facultySignature = $_POST["DeptarmentSignature"];
  $updateStdTable = "update student set form_status='accepted' where student_id='$studentID'";
  $updateFormTable = "update form set faculty_signature='$facultySignature' where form_id='$formID'";

  $e1 = $conn->query($updateFormTable);
  $e2 = $conn->query($updateStdTable);
  if ($e1 && $e2) {
    header("Location: faculty_portal.php");
  } else {
    echo "Failed to update form";
  }
}

if (isset($_POST["delete"])) {
  $fid = $_POST["fid"];
  $updateStudentTable = "update student set form_status='rejected', form_id='' where form_id='$fid'";
  $res1 = $conn->query($updateStudentTable);
  if ($res1) {
    echo "sucess";
  } else {
    echo "Student Failed Operation";
  }

  $deleteForm = "delete from form where form_id='$fid'";
  if ($res2 = $conn->query($deleteForm)) {
    header("Location: faculty_portal.php");
  } else {
    echo "Form Failed Operation";
  }
}

// Showing form details when faculty memeber click on the view button
if ($role == "faculty") {
  $formID = $_GET["fid"];
  $isFaculty = true;
  $formData = "select * from form where form_id='$formID'";
  $result = mysqli_query($conn, $formData);
}
// End
?>
<!DOCTYPE html>
<html>

<head>
  <?php include "head.php" ?>
  <style>
    .mr-40 {
      margin-right: "40px";
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-bg bg-light">
    <div class="container">
      <a class="navbar-brand" href="login.php">
        <img src="images/mainlogo.png" alt="" width="135" height="44">
      </a>
    </div>
  </nav>
  <!-- Empty Form -->
  <?php if ($_GET['fid'] == "" && $_SESSION["role"] == "student") { ?>
    <div class="container">
      <div class="row">
        <div class="col">
          <img src="https://d3hk6w1rfu80ox.cloudfront.net/media/uploads/listings/city-university-of-new-york-queens/exPLDV0u6QGB.jpg" width="220" height="100" class="rounded mx-auto d-block">
          <h5 class="text-center"> DECLARATION OF MAJOR/MINOR FORM </h5>
        </div>
      </div>
      <form method="post" id="myForm2">
        <div class="row">
          <div class="col col-md-6 col-lg-6">
            <div class="FormType">
              <br>
              <h6>DECLARING A MAJOR</h6>
            </div>
            <label for="declaring_major" class="form-label">Major Department:</label>
            <input type="text" id="declaring" class="form-control form-control-sm" name="declaring_major" placeholder="Name of the department of your intended major...." />

            <div class="FormType">
              <br>
              <h6>ADDING A MAJOR </h6>
            </div>
            <label class="form-label" for="adding_major">Major Department:</label>
            <input type="text" id="adding_major" class="form-control form-control-sm" name="adding_major" placeholder="Name of the department of your intended major...." />

            <div class="FormType">
              <br>
              <h6>CHANGING A MAJOR</h6>
            </div>
            <label class="form-label" for="major_change_from">From Major Department:</label>
            <input type="text" id="changing_major_form" class="form-control form-control-sm" name="major_change_from" placeholder="Name of the department of your current major...." />

            <br><label class="form-label" for="major_change_to">To Minor Department:</label>
            <input type="text" id="major_change_to" class="form-control form-control-sm" name="major_change_to" placeholder="Name of department of your new minor...." />

            <div class="FormType">
              <br>
              <h6>DROPPING A SECOND MAJOR</h6>
            </div>
            <label class="form-label" for="drop_major">Major Department:</label>
            <input type="text" id="drop_major" class="form-control form-control-sm" name="drop_major" placeholder="Major you want to drop...." />
          </div>

          <div class="col col-md-6 col-lg-6">
            <div class="FormType">
              <br>
              <h6>DECLARING A MINOR</h6>
            </div>
            <label for="declaring_minor" class="form-label">Minor Department:</label>
            <input type="text" id="declaring_minor" class="form-control form-control-sm" name="declaring_minor" placeholder="Name of the department of your intended minor...." />

            <div class="FormType">
              <br>
              <h6>ADDING A MINOR </h6>
            </div>
            <label class="form-label" for="adding_minor">Minor Department:</label>
            <input type="text" id="adding_minor" class="form-control form-control-sm" name="adding_minor" placeholder="Name of the department of your intended minor...." />

            <div class="FormType">
              <br>
              <h6>CHANGING A MINOR </h6>
            </div>
            <label class="form-label" for="minor_change_from">From Minor Department:</label>
            <input type="text" id="changing_minor_from" class="form-control form-control-sm" name="minor_change_from" placeholder="Name of the department of your current minor...." />

            <br><label class="form-label" for="minor_change_to">To Minor Department:</label>
            <input type="text" id="changing_minor_to" class="form-control form-control-sm" name="minor_change_to" placeholder="Name of department of your new minor...." />

            <div class="FormType">
              <br>
              <h6>DROPPING A MINOR</h6>
            </div>
            <label class="form-label" for="drop_minor">Minor Department:</label>
            <input type="text" id="drop_minor" class="form-control form-control-sm" name="drop_minor" placeholder="Minor you want to drop...." />
          </div>
        </div>
        <div class="row">
          <div class="col col-md-6 col-lg-6">
            <br> <label class="form-label " for="DeptSignature">Department Signature:</label>
            <input type="text" class="form-control form-control-sm" name="DeptarmentSignature" placeholder="For office use only....." disabled><br>
          </div>
          <?php if (strcmp($role, "student") == 0) { ?>
            <div class="col col-md-3 col-lg-3 mt-4"><br>
              <input class="form-control btn btn-form btn-lg" name="create" type="submit" value="Submit" />
            </div>
            <div class="col col-md-3 col-lg-3 mt-4">
              <br>
              <a class="form-control btn btn-exit btn-lg" href="student_portal.php">Cancel</a>
            </div>
          <?php } ?>
        </div>
      </form>
    </div>
  <?php } ?>
  <!-- ########### -->





  <?php if ($_GET['fid'] != "" && $_SESSION["role"] == "faculty") { ?>
    <div class="container mb-5">
      <div class="row">
        <div class="col">
          <img src="https://d3hk6w1rfu80ox.cloudfront.net/media/uploads/listings/city-university-of-new-york-queens/exPLDV0u6QGB.jpg" width="220" height="100" class="rounded mx-auto d-block">
          <h5 class="text-center"> DECLARATION OF MAJOR/MINOR FORM </h5>
        </div>
      </div>
      <?php while ($row = mysqli_fetch_array($result)) { ?>
        <div class="row">
          <div class="col col-md-6 col-lg-6">
            <div class="FormType">
              <br>
              <h6>DECLARING A MAJOR</h6>
            </div>
            <form action="form.php" method="post">
              <label for="declaring_major" class="form-label">Major Department:</label>
              <input value="<?php echo $row["declaring_major"] ?>" type="text" class="form-control form-control-sm" name="declaring_major" placeholder="Name of the department of your intended major...." <?php echo $isFaculty ? "disabled" : "" ?> />

              <div class="FormType">
                <br>
                <h6>ADDING A MAJOR </h6>
              </div>
              <form action="/action_page.php">
                <label class="form-label" for="adding_major">Major Department:</label>
                <input value="<?php echo $row["adding_major"] ?>" type="text" class="form-control form-control-sm" name="adding_major" placeholder="Name of the department of your intended major...." <?php echo $isFaculty ? "disabled" : "" ?> />

                <div class="FormType">
                  <br>
                  <h6>CHANGING A MAJOR</h6>
                </div>
                <form action="/action_page.php">
                  <label class="form-label" for="major_change_from">From Major Department:</label>
                  <input value="<?php echo $row["major_change_from"] ?>" type="text" class="form-control form-control-sm" name="major_change_from" placeholder="Name of the department of your current major...." <?php echo $isFaculty ? "disabled" : "" ?> />

                  <br><label class="form-label" for="major_change_to">To Minor Department:</label>
                  <input value="<?php echo $row["major_change_to"] ?>" type="text" class="form-control form-control-sm" name="major_change_to" placeholder="Name of department of your new minor...." <?php echo $isFaculty ? "disabled" : "" ?> />

                  <div class="FormType">
                    <br>
                    <h6>DROPPING A SECOND MAJOR</h6>
                  </div>
                  <form action="/action_page.php">
                    <label class="form-label" for="drop_major">Major Department:</label>
                    <input value="<?php echo $row["drop_major"] ?>" type="text" class="form-control form-control-sm" name="drop_major" placeholder="Major you want to drop...." <?php echo $isFaculty ? "disabled" : "" ?> />
          </div>

          <div class="col col-md-6 col-lg-6">
            <div class="FormType">
              <br>
              <h6>DECLARING A MINOR</h6>
            </div>
            <form action="/action_page.php">
              <label for="declaring_minor" class="form-label">Minor Department:</label>
              <input value="<?php echo $row["declaring_minor"] ?>" type="text" class="form-control form-control-sm" name="declaring_minor" placeholder="Name of the department of your intended minor...." <?php echo $isFaculty ? "disabled" : "" ?> />

              <div class="FormType">
                <br>
                <h6>ADDING A MINOR </h6>
              </div>
              <form action="/action_page.php">
                <label class="form-label" for="adding_minor">Minor Department:</label>
                <input value="<?php echo $row["adding_minor"] ?>" type="text" class="form-control form-control-sm" name="adding_minor" placeholder="Name of the department of your intended minor...." <?php echo $isFaculty ? "disabled" : "" ?> />

                <div class="FormType">
                  <br>
                  <h6>CHANGING A MINOR </h6>
                </div>
                <form action="/action_page.php">
                  <label class="form-label" for="minor_change_from">From Minor Department:</label>
                  <input value="<?php echo $row["minor_change_from"] ?>" type="text" class="form-control form-control-sm" name="minor_change_from" placeholder="Name of the department of your current minor...." <?php echo $isFaculty ? "disabled" : "" ?> />

                  <br><label class="form-label" for="minor_change_to">To Minor Department:</label>
                  <input value="<?php echo $row["minor_change_to"] ?>" type="text" class="form-control form-control-sm" name="minor_change_to" placeholder="Name of department of your new minor...." <?php echo $isFaculty ? "disabled" : "" ?> />

                  <div class="FormType">
                    <br>
                    <h6>DROPPING A MINOR</h6>
                  </div>
                  <form action="/action_page.php">
                    <label class="form-label" for="drop_minor">Minor Department:</label>
                    <input value="<?php echo $row["drop_minor"] ?>" type="text" class="form-control form-control-sm" name="drop_minor" placeholder="Minor you want to drop...." <?php echo $isFaculty ? "disabled" : "" ?> />
          </div>
        </div>
        <div class="row">
          <div class="col col-md-6 col-lg-6">
            <br> <label class="form-label " for="DeptSignature">Department Signature:</label>
            <input type="text" class="form-control form-control-sm" name="DeptarmentSignature" placeholder="For office use only....." <?php echo !$isFaculty ? "disabled" : "" ?> />
          </div>
        <?php } ?>
        <div class="col col-md-2 col-lg-2 mt-2"><br>
          <form method="post" action="faculty_portal.php">
            <input name="sid" value="<?php echo $_GET['sid'] ?>" type="hidden" />
            <input name="fid" value="<?php echo $_GET['fid'] ?>" type="hidden" />
            <input value="Accepted" type="submit" name="accepted" class="btn-form mt-3 form-control btn" />
          </form>
        </div>
        <div class="col col-md-2 col-lg-2 mt-2">
          <form method="post"><br>
            <input value="Rejected" type="submit" name="delete" class="mt-3 form-control btn btn-warn text-white" />
            <input name="fid" value="<?php echo $_GET['fid'] ?>" type="hidden" />
          </form>
        </div>
        <div class="col col-md-2 col-lg-2 mt-2"><br>
          <a class="mt-3 form-control btn btn-exit" href="faculty_portal.php">Close</a>
        </div>
        </form>
        </div>
    </div>
  <?php } ?>
  <div class="mb-5"></div><br>
</body>
<?php include "footer.php" ?>

</html>