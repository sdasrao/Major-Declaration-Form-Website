<?php

unset($_SESSION['email']);
unset($_SESSION['role']);

$_SESSION["authenticated"] = false;
header("Location: login.php");
