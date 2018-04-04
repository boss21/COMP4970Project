<?php
// Initialize the session
session_start();
// If session variable is not set it will redirect to login page
if (!isset($_SESSION["username"]) || empty($_SESSION["username"])) {
    header("location: login.php");
    exit;
}
// Include config file
include '../dbconfig.php';

$sql = "DELETE * FROM Forms";

echo "fuck";

if (mysqli_query($link, $sql){
    header("location: index.php");
} else {
    echo "Oops! Something went wrong. Please try again later.";
}

mysqli_close($link);
?>