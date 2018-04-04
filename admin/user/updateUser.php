<?php
// Initialize the session
session_start();
// If session variable is not set it will redirect to login page
if (!isset($_SESSION["username"]) || empty($_SESSION["username"])) {
    header("location: login.php");
    exit;
}
// Include config file
include "../../dbconfig.php";

if (empty($_POST["userID"])) {
	header("location: index.php");
	exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["old_userID"])) {
    $oldUserID = $_POST["old_userID"];
    $userID = $_POST["userID"];
    $sqlUpdate = "UPDATE Clients SET UserID = '$userID' WHERE UserID = '$oldUserID'";

    if (mysqli_query($link, $sqlUpdate)) {
        echo "<script type='text/javascript'>alert('$oldUserID successfully updated to $userID!');</script>";
        header("location: modifyUser.php");
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
}

mysqli_close($link);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
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
                        <label>UserID</label>
                        <input type="text" id="userID" name="userID" value="<?php echo $_POST['userID']; ?>" class="form-control"/>
                        <input type="hidden" id="old_userID" name="old_userID" value="<?php echo $_POST['userID']; ?>" />
                    </div>
                    <input type="submit" value="Update" class="btn btn-primary"/>
                    <input type="reset" class="btn btn-default"/>
                    <a href="../index.php" class="btn btn-danger">Cancel</a>
                </form>
            </div>
            <div class="col-sm-4"></div>
        </div>
    </div>
</body>

</html>