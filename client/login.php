<?php
// Initialize the session
session_start();
// If session variable is not set it will redirect to login page
if (isset($_SESSION["userID"]) || !empty($_SESSION["userID"])) {
    header("location: index.php");
    exit;
}
// Include config file
include "../dbconfig.php";

// Define variables and initialize with empty values
$userID = "";
$userID_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if userID is empty
    if (empty(trim($_POST["userID"]))) {
        $userID_err = "Please enter userID.";
    } else {
        $userID = trim($_POST["userID"]);
    }

    // Validate credentials
    if (empty($userID_err)) {
        // Prepare a select statement
        $sql = "SELECT userID FROM Clients WHERE userID = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_userID);

            // Set parameters
            $param_userID = trim($_POST["userID"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if userID exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    /* userID is correct, so start a new session and
                    save the userID to the session */
                    session_start();
                    $_SESSION["userID"] = $userID;
                    header("location: index.php");
                } else {
                    // Display an error message if userID doesn't exist
                    $userID_err = "No account found with that userID.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
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
	</div>
	<div class="container">
		<div class="row">
			<div class="col-sm-4"></div>
			<div class="col-sm-4 text-center">
				<h2>Volunteer Portal Login</h2>
				<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
					<div class="form-group <?php echo (!empty($userID_err)) ? "has-error" : ""; ?>">
						<label>UserID</label>
						<input type="text" class="form-control" name="userID" id="userID">
						<span class="help-block" style="color:red;">
							<?php echo $userID_err; ?>
						</span>
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-primary" value="Sign In">
						<input type="hidden" name="type" value="login" />
					</div>
				</form>
				<h5>Not a Volunteer?</h5>
				<a class="btn btn-outline-primary" href="../admin/login.php">Administrator Sign In</a>
			</div>
			<div class="col-sm-4"></div>
		</div>
	</div>
</body>

</html>