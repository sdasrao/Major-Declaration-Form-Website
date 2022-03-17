<?PHP
require_once('config.php');
session_start();
if ($_SESSION['authenticated'] == false || $_SESSION["role"] != "faculty") {
    header("Location: login.php");
}

$id = $_SESSION["id"];

$sql = "select student_id, first_name, last_name, form_id, form_status from student where form_status='pending'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "head.php" ?>
    <style>
        a:link {
            text-decoration: none;
        }
    </style>
</head>

<body>
    <?php include "header.php" ?>
    <div class="container"><br>
        <div class="row">
            <div class="col text-center">
                <h2>Faculty Portal<h2>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Student Name</th>
                            <th scope="col">Status</th>
                            <th scope="col">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_array($result)) { ?>
                            <tr>
                                <th scope="row"><?php echo $row["student_id"] ?></th>
                                <th scope="col"><a class="link-info" href="personinfo.php?id=<?php echo $row["student_id"] ?>"><?php echo $row["first_name"] . ' ' . $row["last_name"] ?></a></th>
                                <th scope="col"><?php echo $row["form_status"] ?></th>
                                <th><a href="form.php?fid=<?php echo $row["form_id"] ?>&sid=<?php echo $row["student_id"] ?>" class="btn-sm btn btn-bg"><i class="fa fa-file"> form</i></a>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <a href="personinfo.php?id=" class="btn btn-lg btn-form text-white">
                    <i class="fa fa-edit"> Update your Info</i>
                </a>
            </div>
        </div>
    </div>
    <?php include "footer.php" ?>

</body>

</html>

<?php
$conn->close();
?>