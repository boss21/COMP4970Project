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
                        <label>Room</label>
                        <select id="room_ID" name="room_ID" class="form-control"></select>
                    </div>
                    <div class="form-group">
                        <label>Timeslot</label>
                        <select id="time_slot_ID" name="time_slot_ID" class="form-control"></select>
                    </div>
                    <div class="form-group">
                        <label>Headcount Type</label>
                        <select id="head_count_type" name="head_count_type" class="form-control"></select>
                    </div>
                    <div class="form-group">
                        <label>Headcount</label>
                        <input type="number" id="head_count" name="head_count" min="0" class="form-control" />
                    </div>
                    <input type="submit" value="Add" class="btn btn-primary" />
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