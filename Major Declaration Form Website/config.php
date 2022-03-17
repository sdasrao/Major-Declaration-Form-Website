<?php
$servername = "mars.cs.qc.cuny.edu";
$username = "dasw7804";
$password = "14117804";
$dbname = "dasw7804";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
