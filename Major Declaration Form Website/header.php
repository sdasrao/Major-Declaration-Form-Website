<nav class="navbar navbar-bg navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="login.php"><img src="images/mainlogo.png" width="135" height="44"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0 ms-auto">
                <?php if ($_SESSION["role"] == "admin") { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_portal.php">Admin Portal</a>
                    </li>
                <?php } ?>

                <?php if ($_SESSION["role"] == "student") { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="student_portal.php">Student Portal</a>
                    </li>
                <?php }  ?>


                <?php if ($_SESSION["role"] == "faculty") { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="faculty_portal.php">Faculty Portal</a>
                    </li>
                <?php }  ?>
                <?php if ($_SESSION['authenticated'] == null) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="registration.php">Sign up</a>
                    </li>
                <?php } ?>

                <?php if ($_SESSION['authenticated'] == null) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Sign in</a>
                    </li>
                <?php } ?>

                <?php if ($_SESSION['authenticated'] == true) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">log out</a>
                    </li>
                <?php } ?>
                <li class="nav-right">
                    <span class="nav-link text-white"><?php echo $_SESSION["firstName"] . ' ' . $_SESSION["lastName"] ?></span>
                </li>

            </ul>
        </div>
    </div>
</nav>