<?php
session_start(); // Ensure session is started
?>
<!DOCTYPE html>
<html>
<head>
    <title>Check Staff Member Reservation Validity</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Add custom CSS for background */
        body {
            background-image: url('b.jpg'); /* Add your background image URL here */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #ffffff; /* Set text color to white for better contrast */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Check Member Reservation Validity</h2>
        <form action="" method="post">
            
            <div class="form-group">
                <label for="memberId">Member ID:</label>
                <input type="text" id="memberId" name="memberId" class="form-control">
            </div>
            <div class="form-group">
                <label for="memberId">Member Name:</label>
                <input type="text" id="memberName" name="memberName" class="form-control">
            </div>
            <div class="form-group">
                <label for="reservationId">Reservation ID:</label>
                <input type="text" id="reservationId" name="reservationId" class="form-control">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-dark" style="background-color: #008000">Check Validity</button>
                <a class="btn btn-danger" href="javascript:window.history.back();">Cancel</a>
                <a class="btn btn-link" href="posTable.php">Tables Page</a>
            </div>
        </form>
    </div>

<div class="container mt-3">
    <?php
    // Include your database connection configuration
    require_once('../config.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $staffId = $_POST['staffId']=1;
        $memberId = !empty($_POST['memberId']) ? $_POST['memberId'] : 1;
       // eikhane ppppp
       $memberName=!empty($_POST['memberName']) ? $_POST['memberName'] : 1;
        $reservationId = !empty($_POST['reservationId']) ? $_POST['reservationId'] : 1111111;
       
        $bill_id = $_GET['bill_id'];

        // Check if the staff ID exists in the database
        $query = "SELECT * FROM Staffs WHERE staff_id = '$staffId'";
        $result = mysqli_query($link, $query);

        if (!$result) {
            echo "Error: " . mysqli_error($link);
        } else {
            $staffExists = mysqli_num_rows($result) > 0;

            $memberExists = true; // Assume member is valid if ID is not provided
            if (!empty($memberId)) {
                //Eikhane
                 $query = "SELECT * FROM Memberships WHERE member_id = '$memberId'";
                //$query = "SELECT * FROM accounts WHERE account_id = '$memberId'";
                $result = mysqli_query($link, $query);
                if (!$result) {
                    echo "Error: " . mysqli_error($link);
                } else {
                    $memberExists = mysqli_num_rows($result) > 0;
                }
            }

            $reservationExists = true; // Assume reservation is valid if ID is not provided
            if (!empty($reservationId)) {
                $query = "SELECT * FROM Reservations WHERE reservation_id = '$reservationId'";
                $result = mysqli_query($link, $query);
                if (!$result) {
                    echo "Error: " . mysqli_error($link);
                } else {
                    $reservationExists = mysqli_num_rows($result) > 0;
                }
            }

            if ($staffExists && $memberExists && $reservationExists) {
                echo '<div class="alert alert-success" role="alert">';
                echo "Member ID and Reservation ID are valid.";
                echo '</div>';
                echo '<div class="mt-3">';
                //Eikhane
                echo '<a href="posCashPayment.php?bill_id=' . $bill_id . '&staff_id=' . $staffId . '&member_id=' . $memberId . '&member_name=' .$memberName . '&reservation_id=' . $reservationId . '" class="btn btn-success">Cash</a>';
                echo '<a href="posCardPayment.php?bill_id=' . $bill_id . '&staff_id=' . $staffId . '&member_id=' . $memberId . '&member_name=' .$memberName . '&reservation_id=' . $reservationId . '" class="btn btn-primary ml-2">Credit Card</a>';
                echo '</div>';
            } else {
                echo "Invalid Member ID or Reservation ID";
            }
        }
    }
    ?>
</div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
