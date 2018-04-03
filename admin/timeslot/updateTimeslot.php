<?php
include '../../dbconfig.php';

// Initialize the session
session_start();
// If session variable is not set it will redirect to login page
if (!isset($_SESSION["username"]) || empty($_SESSION["username"])) {
    header("location: login.php");
    exit;
}


if (isset($_POST['time_slot_ID'])){
	$timeslotID = $_POST['time_slot_ID'];
	$sql = "SELECT timeslot FROM timeslots WHERE TimeslotID = '$timeslotID'";
	$result = mysqli_query($link, $sql);
	$row = mysqli_fetch_array($result);
	$timeslot = $row['timeslot'];
}

else if ($_POST['timeslot']){
	$timeslot = $_POST['timeslot'];
	$timeslotID = $_POST['timeslot_ID'];
	$sql = "UPDATE timeslots SET Timeslot = '$timeslot' WHERE TimeslotID='$timeslotID'";
	if (mysqli_query($link, $sql)){
       echo "<script type='text/javascript'>alert('timeslot id: $timeslotID successfully modified.');</script>";
	   header("location: modifyTimeslot.php");
	}
	else{
       echo "<script type='text/javascript'>alert('Oops. Try Again Later.');</script>";
	}
}
else{
	header("location: modifyTimeslot.php");
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
                <?php echo htmlspecialchars($_SESSION["username"]); ?>
            </a>
        </nav>
        <a class="btn btn-outline-primary" href="../logout.php">Sign Out</a>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4 text-center">
                <br />
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="form-group">
                        <label>Timeslot ID</label>
                        <input type="text" id="timeslot_id" name="time_slot_id" class="form-control" value="<?php echo $timeslotID ?>" />
                    </div>
                    <div class="form-group">
                        <label>Timeslot</label>
                        <input type="number" id="timeslot" name="timeslot" min="0" class="form-control" value="<?php echo $timeslot ?>" />
                    </div>
					<input type="hidden" id="timeslot_ID" name="timeslot_ID" value="<?php echo $timeslotID ?>" />
                    <input type="submit" value="Modify" class="btn btn-primary" />
                    <br />
                    <br />
                    <input type="reset" class="btn btn-default" />
                </form>
                <br />
                <a href="../index.php" class="btn btn-danger">Cancel</a>
                <br />
            </div>
            <div class="col-sm-4"></div>
        </div>
    </div>
</body>

</html>
