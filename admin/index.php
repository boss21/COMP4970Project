<?php
// Initialize the session
session_start();
// If session variable is not set it will redirect to login page
if (!isset($_SESSION["username"]) || empty($_SESSION["username"])) {
    header("location: login.php");
    exit;
}
// Include config file
include "../dbconfig.php";
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>HeadCountApp</title>
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.css">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.1/umd/popper.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.js"></script>
    </head>

    <body>
        <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-light border-bottom box-shadow">
            <h5 class="my-0 mr-md-auto font-weight-normal">Boston Code Camp</h5>
            <nav class="my-2 my-md-0 mr-md-3">
                <a class="p-2 text-dark">
                    <?php echo htmlspecialchars($_SESSION["username"]); ?>
                </a>
            </nav>
            <a class="btn btn-outline-primary" href="logout.php">Sign Out</a>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <br/>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Users
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="user/viewUser.php">View Users</a>
                            <a class="dropdown-item" href="user/addUser.php">Add Users</a>
                            <a class="dropdown-item" href="user/modifyUser.php">Modify Users</a>
                            <a class="dropdown-item" href="user/deleteUser.php">Delete Users</a>
                        </div>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Rooms
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="room/viewRoom.php">View Rooms</a>
                            <a class="dropdown-item" href="room/addRoom.php">Add Rooms</a>
                            <a class="dropdown-item" href="room/modifyRoom.php">Modify Rooms</a>
                            <a class="dropdown-item" href="room/deleteRoom.php">Delete Rooms</a>
                        </div>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Timeslots
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="timeslot/viewTimeslot.php">View Timeslots</a>
                            <a class="dropdown-item" href="timeslot/addTimeslot.php">Add Timeslots</a>
                            <a class="dropdown-item" href="timeslot/modifyTimeslot.php">Modify Timeslots</a>
                            <a class="dropdown-item" href="timeslot/deleteTimeslot.php">Delete Timeslots</a>
                        </div>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Forms
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="form/addForm.php">Add Forms</a>
                            <a class="dropdown-item" href="form/modifyForm.php">Modify Forms</a>
                            <a class="dropdown-item" href="form/deleteForm.php">Delete Forms</a>
                            <a class="dropdown-item" href="index.php">View Forms</a>
                        </div>
                    </div>
                    <br/>
                    <br/>
                    <div>
                        <h2>Room Headcounts</h2>
                        <br/>
                        <table class="table table-bordered">
                            <?php
                                $sql = "
                                SELECT Rooms.RoomID, Rooms.Room, Timeslots.Timeslot, Forms.HeadcountType, Forms.HeadcountCount, Forms.UserID, Forms.Timestamp FROM Forms LEFT JOIN Rooms ON Forms.RoomID = Rooms.RoomID LEFT JOIN Timeslots ON Forms.TimeslotID = Timeslots.TimeslotID 
                                ORDER BY RoomID, HeadcountType='End', HeadcountType='Middle', HeadcountType='Beginning'
                                ";

                                $result = mysqli_query($link, $sql);

                                echo
                                    "<thead>" .
                                    "<th>Room</th>" .
                                    "<th>Timeslot</th>" .
                                    "<th>Headcount Type</th>" .
                                    "<th>Headcount Count</th>" .
                                    "<th>UserID</th>" .
                                    "<th>Timestamp</th>" .
                                    "</thead>";

                                while ($row = mysqli_fetch_array($result)) {
                                    $room = $row["Room"];
                                    $timeslot = $row["Timeslot"];
                                    $headcounttype = $row["HeadcountType"];
                                    $headcount = $row["HeadcountCount"];
                                    $userid = $row["UserID"];
                                    $tstamp = $row["Timestamp"];

                                    echo "<tr>" .
                                        "<td>" . $room . "</td>" . // RoomID
                                        "<td>" . $timeslot . "</td>" . // TimeslotID
                                        "<td>" . $headcounttype . "</td>" . // Headcountype
                                        "<td>" . $headcount . "</td>" . // HeadcountCount
                                        "<td>" . $userid . "</td>" . // UserID
                                        "<td>" . $tstamp . "</td>" . // Timestamp
                                        "</tr>";
                                }
                                // Close connection
                                mysqli_close($link);
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>