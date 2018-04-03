<?php
// Initialize the session
session_start();
// If session variable is not set it will redirect to login page
if (!isset($_SESSION["username"]) || empty($_SESSION["username"])) {
    header("location: login.php");
    exit;
}

include '../../dbconfig.php';

$sql1 = "SELECT Room FROM rooms";
$result = mysqli_query($link,$sql1);
$currentRooms = array();

while ($row = mysqli_fetch_array($result)) {
	$currentRooms[]=$row['Room'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
   $room = $_POST["room_name"];
	for ($i=0;$i<count($currentRooms);$i++){
		if ($currentRooms[$i] === $room){
			echo "<script type='text/javascript'>alert('$room is a name already in the database.');window.location.href='addRoom.php';</script>";
			return false;
		}
	}
   $capacity = $_POST["capacity"];
   $sql2 = "INSERT INTO Rooms (Room, Capacity) VALUES ('$room', '$capacity')";
   if (mysqli_query($link, $sql2)){
       echo "<script type='text/javascript'>alert('$room successfully added with a capacity of $capacity.');</script>";
   }else{
       echo "<script type='text/javascript'>alert('Oops. Try Again Later.');</script>";
   }
}
mysqli_close($link);
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
                        <input type="text" id="room_name" name="room_name" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Capacity</label>
                        <input type="number" id="capacity" name="capacity" min="0" class="form-control" />
                    </div>
                    <input type="submit" name="submit" value="Add" class="btn btn-primary" />
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
