<?PHP
require_once('config.php');
?>
<?php
session_start();
if ($_SESSION['authenticated'] == false || $_SESSION["role"] != "student") {
    header("Location: login.php");
}


$id = $_SESSION["id"];
$current_user = $_SESSION["email"];
$sql = "select student_id, form_id, form_status from student where email='$current_user'";
$result = $conn->query($sql);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "head.php" ?>
</head>

<body>
    <?php include "header.php" ?>
    <div class="container"><br>
        <div class="row">
            <div class="col text-center">
                <h2>Student Portal<h2>
            </div>
        </div>
        <hr>
        <?php while ($row = mysqli_fetch_array($result)) { ?>

            <div class="row">
                <div class="col">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Form No.</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row"><?php echo ($row["form_id"] ? $row["form_id"] : "Form"); ?></th>
                                <th scope="col">
                                    <?php echo $row["form_status"] ?>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                    <a href="personinfo.php?id=<?php echo $row["student_id"] ?>" class="btn btn-lg btn-bg">
                        <i class="fa fa-edit"> Update your Info</i>
                    </a>
                    <a href="form.php?fid=&sid=" class="btn btn-lg btn-form
                    <?php echo ($row["form_status"] == "pending") ? "disabled" : "" ?>">
                        <i class="fa fa-file"> New form</i>
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>
    <?php include "footer.php" ?>
</body>

</html>

<?php $conn->close(); ?>