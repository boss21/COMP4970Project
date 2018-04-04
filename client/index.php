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
$roomID = "";
$timeslotID = "";
$headCountType = "";
$roomID_err = "";
$timeslotID_err = "";
$headCountType_err = "";

$_SESSION["roomID"] = "";
$_SESSION["timeslotID"] = "";
$_SESSION["headCountType"] = "";
$_SESSION["headCount"] = "";

$sqlRoom = "SELECT RoomID, Room FROM Rooms";
$resultRoom = mysqli_query($link, $sqlRoom);

$sqlTimeslot = "SELECT TimeslotID, Timeslot FROM Timeslots";
$resultTimeslot = mysqli_query($link, $sqlTimeslot);

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if RoomID is empty
    if (empty(trim($_POST["RoomID"]))) {
        $roomID_err = "Please select Room.";
    } else {
        $roomID = trim($_POST["RoomID"]);
	}
	
	// Check if TimeslotID is empty
    if (empty(trim($_POST["TimeslotID"]))) {
        $timeslotID_err = "Please select Timeslot.";
    } else {
        $timeslotID = trim($_POST["TimeslotID"]);
	}
	
	// Check if HeadCountType is empty
    if (empty(trim($_POST["HeadCountType"]))) {
        $headCountType_err = "Please select Headcount Type.";
    } else {
        $headCountType = trim($_POST["HeadCountType"]);
	}

    // Validate credentials
    if (empty($roomID_err) && empty($timeslotID_err) && empty($headCountType_err)) {
		$_SESSION["roomID"] = $roomID;
		$_SESSION["timeslotID"] = $timeslotID;
		$_SESSION["headCountType"] = $headCountType;
		header("location: headCount.php");
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
						<div class="form-group <?php echo (!empty($roomID_err)) ? "has-error" : ""; ?>">
							<label for="RoomID">Room</label>
							<select id="RoomID" name="RoomID" class="form-control">
							<?php
							while ($row = mysqli_fetch_array($resultRoom)) {
								echo "<option value='" . $row['RoomID'] . "'>" . $row['Room'] . "</option>";
							}
							?>
							</select>
							<span class="help-block" style="color:red;">
								<?php echo $roomID_err; ?>
							</span>
						</div>
						<div class="form-group <?php echo (!empty($timeslotID_err)) ? "has-error" : ""; ?>">
							<label for="TimeslotID">Timeslot</label>
							<select id="TimeslotID" name="TimeslotID" class="form-control">
							<?php
							while ($row = mysqli_fetch_array($resultTimeslot)) {
								echo "<option value='" . $row['TimeslotID'] . "'>" . $row['Timeslot'] . "</option>";
							}
							?>
							</select>
							<span class="help-block" style="color:red;">
								<?php echo $timeslotID_err; ?>
							</span>
						</div>
						<div class="form-group <?php echo (!empty($headCountType_err)) ? "has-error" : ""; ?>">
							<label for="HeadCountType">Headcount Type</label>
							<div class="radio-inline">
								<input type="radio" name="HeadCountType" id="HeadCountType" value="Beginning"> Beginning
								<input type="radio" name="HeadCountType" id="HeadCountType" value="Middle"> Middle
								<input type="radio" name="HeadCountType" id="HeadCountType" value="End"> End
							</div>
							<span class="help-block" style="color:red;">
								<?php echo $headCountType_err; ?>
							</span>
						</div>
						<input type="submit" class="btn btn-primary" value="Continue" />
						<input type="reset" class="btn btn-default" />
					</form>
				</div>
				<div class="col-sm-4"></div>
			</div>
		</div>
	</body>

	</html>