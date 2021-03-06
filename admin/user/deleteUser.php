<?php
// Initialize the session
session_start();
// If session variable is not set it will redirect to login page
if (!isset($_SESSION["username"]) || empty($_SESSION["username"])) {
    header("location: ../login.php");
    exit;
}
// Include config file
include "../../dbconfig.php";

$userID = "";
$userID_err = "";

$sql = "SELECT UserID FROM Clients";
$result = mysqli_query($link, $sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if UserID is empty
    if (empty(trim($_POST["userID"]))) {
        $userID_err = "There are no users available to delete.";
    } else {
        $userID = trim($_POST["userID"]);
    }

    if (empty($userID_err)){
        $sqlDelete = "DELETE FROM Clients WHERE UserID = '$userID'";

        if (mysqli_query($link, $sqlDelete)) {
            echo "<script>alert('$userID was successfully deleted!');window.location.href='deleteUser.php';</script>";
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
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
                <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                    <div class="form-group <?php echo (!empty($userID_err)) ? "has-error" : ""; ?>">
                        <label>UserID</label>
                        <select id="userID" name="userID" class="form-control">
                            <?php
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<option value='" . $row['UserID'] . "'>" . $row['UserID'] . "</option>";
                            }
                            ?>
                        </select>
                        <span class="help-block" style="color:red;">
						    <?php echo $userID_err; ?>
						</span>
                    </div>
                    <input type="submit" value="Delete" class="btn btn-primary"/>
                    <input type="reset" class="btn btn-default"/>
                    <a href="../index.php" class="btn btn-danger">Cancel</a>
                </form>
            </div>
            <div class="col-sm-4"></div>
        </div>
    </div>
</body>

</html>