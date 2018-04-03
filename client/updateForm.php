<?php
// Initialize the session
session_start();
// If session variable is not set it will redirect to login page
if (!isset($_SESSION["userID"]) || empty($_SESSION["userID"])) {
	header("location: login.php");
	exit;
}
// Include config file
include "../dbconfig.php";

if (empty($_SESSION["roomID"])) {
	header("location: index.php");
	exit;
}

$roomID = $_SESSION["roomID"];
$timeslotID = $_SESSION["timeslotID"];
$headCountType = $_SESSION["headCountType"];

// Prepare a select statement
$sql = "UPDATE Forms SET RoomID = ?, TimeslotID = ?, HeadcountType = ?, HeadcountCount = ?, UserID = ? WHERE RoomID = '$roomID' AND TimeslotID = '$timeslotID' AND HeadcountType = '$headCountType'";

if ($stmt = mysqli_prepare($link, $sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "sssss", $param_roomID, $param_timeslotID, $param_headCountType, $param_headCount, $param_userID);
    
    // Set parameters
    $param_roomID = $_SESSION["roomID"];
    $param_timeslotID = $_SESSION["timeslotID"];
    $param_headCountType = $_SESSION["headCountType"];
    $param_headCount = $_SESSION["headCount"];
    $param_userID = $_SESSION["userID"];

    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Form successfully updated!');window.location = 'index.php';</script>";
    } else {
        echo "<script>alert('Oops! Something went wrong. Please try again later.');window.location = 'index.php';</script>";
    }
}

$_SESSION["roomID"] = "";
$_SESSION["timeslotID"] = "";
$_SESSION["headCountType"] = "";
$_SESSION["headCount"] = "";

// Close statement
mysqli_stmt_close($stmt);
?>