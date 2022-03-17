<?PHP
require_once('config.php');
session_start();
if ($_SESSION['authenticated'] == false || $_SESSION["role"] != "admin") {
    header("Location: login.php");
}

if (isset($_POST["deleteFaculty"])) {
    $facultyID = $_POST["facultyID"];
    $delFacultyQuery = "delete from faculty where faculty_id='$facultyID'";
    $res = mysqli_query($conn, $delFacultyQuery);
}
if (isset($_POST["deleteStudent"])) {
    $studentID = $_POST["studentID"];
    $formID = $_POST["formID"];
    $delStudentQuery = "delete from student where student_id='$studentID'";
    $delFormQuery = "delete from form where form_id='$formID'";

    $res1 = mysqli_query($conn, $delStudentQuery);
    $res2 = mysqli_query($conn, $delFormQuery);
}

$getAllStudentsQuery = "select * from student";
$getAllFacultyMembersQuery = "select * from faculty";
$getAdminInfoQuery = "select * from admin";

$getSutdnetInfo = mysqli_query($conn, $getAllStudentsQuery);
$getAllFacultyMembersInfo = mysqli_query($conn, $getAllFacultyMembersQuery);
$getAdminInfo = mysqli_query($conn, $getAdminInfoQuery);

if (!mysqli_num_rows($getSutdnetInfo)) {
    echo "<div class='mb-0 alert alert-info pt-1 pb-1' role='alert'>There is no student info in the database</div>";
}
if (!mysqli_num_rows($getAllFacultyMembersInfo)) {
    echo "<div class='mb-0 alert alert-info pt-1 pb-1' role='alert'>There is no faculty member info in the database</div>";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "head.php" ?>
    <style>
        .hide {
            display: none;
        }

        .show {
            display: block;
        }
    </style>
</head>


<body>
    <?php include "header.php" ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col col-md-3 col-lg-3">
                <div class="d-flex flex-column p-3 text-black bg-dark" style="width: 280px; border-top: 1px solid white ">
                    <a href="admin_portal.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <svg class="bi me-2" width="40" height="32">
                            <use xlink:href="#bootstrap"></use>
                        </svg>
                        <span class="fs-4">Dashboard</span>
                    </a>
                    <hr>
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="#" id="said" onclick="onClickHideFacultyInfo()" class="nav-link text-white" aria-current="page">
                                <svg class="bi me-2" width="16" height="16">
                                    <use xlink:href="#home"></use>
                                </svg>
                                Students
                            </a>
                        </li>
                        <li>
                            <a href="#" id="faid" onClick="onClickHideStudentInfo()" class="nav-link text-white">
                                <svg class="bi me-2" width="16" height="16">
                                    <use xlink:href="#speedometer2"></use>
                                </svg>
                                faculty Members
                            </a>
                        </li>
                        <li>
                            <a href="personinfo.php" class="nav-link text-white">
                                <svg class="bi me-2" width="16" height="16">
                                    <use xlink:href="#table"></use>
                                </svg>
                                Profile
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col col-md-9 col-lg-9"><br>
                <div id="student-table">
                    <h2 class="text-center">Student Info</h2>
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th scope="col">Studnet ID</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone Number</th>
                                <th scope="col">Form ID</th>
                                <th scope="col">Form Status</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_array($getSutdnetInfo)) { ?>

                                <tr>
                                    <td><?php echo $row["student_id"] ?></td>
                                    <td><?php echo $row["first_name"] ?></td>
                                    <td><?php echo $row["last_name"] ?></td>
                                    <td><?php echo $row["email"] ?></td>
                                    <td><?php echo $row["phone"] ?></td>
                                    <td><?php echo $row["form_id"] ?></td>
                                    <td><?php echo $row["form_status"] ?></td>
                                    <td>
                                        <form method="post" action="admin_portal.php">
                                            <input name="studentID" type="hidden" value="<?php echo $row["student_id"] ?>" />
                                            <input name="formID" type="hidden" value="<?php echo $row["form_id"] ?>" />
                                            <button name="deleteStudent" type="submit" class="text-danger btn-link btn">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
                <div id="faculty-table">
                    <h2 class="text-center">Faculty Member Info</h2>
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th scope="col">Faulty ID</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone Number</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_array($getAllFacultyMembersInfo)) { ?>
                                <tr>
                                    <td><?php echo $row["faculty_id"] ?></td>
                                    <td><?php echo $row["first_name"] ?></td>
                                    <td><?php echo $row["last_name"] ?></td>
                                    <td><?php echo $row["email"] ?></td>
                                    <td><?php echo $row["phone"] ?></td>
                                    <td>
                                        <form method="post" action="admin_portal.php">
                                            <input name="facultyID" type="hidden" value="<?php echo $row["faculty_id"] ?>" />
                                            <button name="deleteFaculty" type="submit" class="text-danger btn-link btn">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        let facultyTable = document.getElementById("faculty-table");
        let studentTable = document.getElementById("student-table");
        let said = document.getElementById("said");
        let faid = document.getElementById("faid");

        function onClickHideStudentInfo() {
            said.setAttribute("class", "nav-link text-white");
            faid.setAttribute("class", "nav-link active");
            facultyTable.setAttribute("class", "show");
            studentTable.setAttribute("class", "hide");
        }

        function onClickHideFacultyInfo() {
            said.setAttribute("class", "nav-link active");
            faid.setAttribute("class", "nav-link text-white");
            facultyTable.setAttribute("class", "hide");
            studentTable.setAttribute("class", "show");
        }
    </script>
</body>
<?php include "footer.php" ?>

</html>