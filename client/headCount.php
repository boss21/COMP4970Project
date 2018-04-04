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

// Define variables and initialize with empty values
$headCount = "";
$headCount_err = "";

if (empty($_SESSION["roomID"])) {
	header("location: index.php");
	exit;
}

$roomID = $_SESSION["roomID"];
$timeslotID = $_SESSION["timeslotID"];
$headCountType = $_SESSION["headCountType"];

$sqlRoom = "SELECT Capacity FROM Rooms WHERE RoomID = '$roomID'";
$resultRoom = mysqli_query($link, $sqlRoom);
$row = mysqli_fetch_array($resultRoom);
$capacity = $row["Capacity"];

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	// Check if HeadCount is empty
    if (trim($_POST["HeadCount"]) == "") {
        $headCount_err = "Please enter Headcount.";
    } else {
        $headCount = trim($_POST["HeadCount"]);
    }

    // Validate credentials
    if (empty($headCount_err)) {
        $_SESSION["headCount"] = $headCount;
		// Check for duplicates
		$sqlDuplicate = "SELECT * FROM Forms WHERE RoomID = '$roomID' AND TimeslotID = '$timeslotID' AND HeadcountType = '$headCountType'";
		$resultDuplicate = mysqli_query($link, $sqlDuplicate);
		if (mysqli_num_rows($resultDuplicate) != 0){
			echo "<script>if(confirm('This form already exists. Are you sure you want to override it?')){window.location = 'updateForm.php';}else{window.location = 'index.php';}</script>";
		}else{
			header("location: submitForm.php");
		}
    }

    // Close connection
    mysqli_close($link);
}
?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="utf-8" />
		<title>HeadCountApp</title>
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.css">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	</head>

	<body>
		<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-light border-bottom box-shadow">
			<h5 class="my-0 mr-md-auto font-weight-normal">Boston Code Camp</h5>
			<nav class="my-2 my-md-0 mr-md-3">
				<a class="p-2 text-dark">
					<?php echo htmlspecialchars($_SESSION["userID"]); ?>
				</a>
			</nav>
			<a class="btn btn-outline-primary" href="logout.php">Sign Out</a>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-sm-4"></div>
				<div class="col-sm-4 text-center">
					<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
						<div class="form-group <?php echo (!empty($headCount_err)) ? "has-error" : ""; ?>">
							<label>Headcount</label>
							<input type="number" id="HeadCount" name="HeadCount" min="0" max="<?php echo $capacity*1.1; ?>" pattern="[0-9]" class="form-control" />
							<span class="help-block" style="color:red;">
								<?php echo $headCount_err; ?>
							</span>
						</div>
						<input type="submit" class="btn btn-primary" value="Submit" />
						<input type="reset" class="btn btn-default" />
						<a href="index.php" class="btn btn-danger">Cancel</a>
					</form>
				</div>
				<div class="col-sm-4"></div>
			</div>
		</div>
	</body>

	</html>