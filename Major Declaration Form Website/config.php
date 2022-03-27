<?php
$servername = "     ";
$username = "     ";
$password = "     ";
$dbname = "     ";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
