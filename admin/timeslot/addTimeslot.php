<?php
// Initialize the session
session_start();
// If session variable is not set it will redirect to login page
if (!isset($_SESSION["username"]) || empty($_SESSION["username"])) {
    header("location: ../login.php");
    exit;
}
// Include config file
include '../../dbconfig.php';

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $timeslot = $_POST["time_slot"];
    $sql = "SELECT Timeslot FROM Timeslots WHERE Timeslot = '$timeslot'";
    $result = mysqli_query($link, $sql);
	if (mysqli_num_rows($result) != 0) {
		echo "<script>alert('$timeslot already exists.');window.location.href='addTimeslot.php';</script>";
	} else {
        $sqlAdd = "INSERT INTO Timeslots (Timeslot) VALUES ('$timeslot')";
        if (mysqli_query($link, $sqlAdd)){
            echo "<script>alert('$timeslot was successfully added!');</script>";
        }else{
            echo "Oops! Something went wrong. Please try again later.";
        }
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
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="form-group">
                        <label>Timeslot</label>
                        <input type="text" id="time_slot" name="time_slot" class="form-control" />
                    </div>
                    <input type="submit" name="submit" value="Add" class="btn btn-primary" />
                    <input type="reset" class="btn btn-default" />
                    <a href="../index.php" class="btn btn-danger">Cancel</a>
                </form>
            </div>
            <div class="col-sm-4"></div>
        </div>
    </div>
</body>

</html>