<?php
// Initialize the session
session_start();
// If session variable is not set it will redirect to login page
if (!isset($_SESSION["username"]) || empty($_SESSION["username"])) {
    header("location: login.php");
    exit;
}
include '../../dbconfig.php';

if (isset($_POST['room_ID'])){
	$roomID = $_POST['room_ID'];
	$sql = "SELECT Room, Capacity FROM rooms WHERE RoomID = '$roomID'";
	$result = mysqli_query($link, $sql);
	$row = mysqli_fetch_array($result);
	$roomName = $row['Room'];
	$capacity = $row['Capacity'];
}
else if ($_POST['room_name'] && $_POST['capacity']){
	$roomID = $_POST['roomID'];
	$roomName=$_POST['room_name'];
	$capacity= $_POST['capacity'];
	$sql = "UPDATE rooms SET Room = '$roomName', Capacity = '$capacity' WHERE RoomID='$roomID'";
	mysqli_query($link, $sql);
}
else{
	header("location: modifyRoom.php");
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
                        <label>Room Name</label>
                        <input type="text" id="room_name" name="room_name" class="form-control" value="<?php echo $roomName ?>" />
                    </div>
                    <div class="form-group">
                        <label>Capacity</label>
                        <input type="number" id="capacity" name="capacity" min="0" class="form-control" value="<?php echo $capacity ?>" />
                    </div>
					<input type="hidden" id="room_ID" name="roomID" value="<?php echo $roomID ?>" />
                    <input type="submit" value="Modify" class="btn btn-primary" />
                    <br />
                    <br />
                    <input type="reset" class="btn btn-default" />
                </form>
                <br />
                <a href="../index.php" class="btn btn-danger">Cancel</a>
            </div>
            <div class="col-sm-4"></div>
        </div>
    </div>
</body>

</html>
