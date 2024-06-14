<?php
session_start(); // Ensure session is started
?>
<?php
include '../inc/dashHeader.php';
require_once '../config.php';
$query = "SELECT * FROM Kitchen WHERE time_ended IS NULL";
$result = mysqli_query($link, $query);
?>

    <link href="../css/pos.css" rel="stylesheet" />
    <meta http-equiv="refresh" content="5">

    <style>
    .wrapper {
        width: 80%;
        padding-left: 550px;
        padding-top: 20px;
    }

    body {
        background-color: #FF8629;
    }

    .table {
        border: 2px solid #000; /* Set the border color for the table */
    }

    .table thead th {
        background-color: #008000; /* Change this color to your desired background color */
        color: white; /* Change this color to your desired text color */
    }
    /* New styles for even rows */
    .table tbody tr:nth-child(even) {
        background-color: #f9f9f9; /* Change this color to your desired color for even rows */
    }
    /* Apply different background color for odd rows */
    .table tbody tr:nth-child(odd) {
        background-color: white; /* Change this color to your desired odd row background color */
    }
</style>

<body style="background-color: #FF8629">
    <div class="wrapper" style="width: 80%; padding-left: 550px; padding-top: 20px ;">
        <div class="container-fluid pt-5 pl-600 mt-5">
            <div class="">
                <div class="col" style="text-align: left; display: flex; justify-content: space-between;">
                    <h2 class="">Kitchen Orders</h2>
                    <a href="../posBackend/kitchenBackend/undo.php?UndoUnshow=true" class="btn btn-warning mb-2" style="background-color: white;color: black">Undo</a>
                </div>
            </div>

            <table class="table table-bordered ">
                <thead>
                    
                    <tr>
                        <th>Kitchen ID</th>
                        <th>Table ID</th>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Time Submitted</th>
                        <th>Time Ended</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $kitchen_id = $row['kitchen_id'];
                            $table_id = $row['table_id'];
                            $item_id = $row['item_id'];
                            $quantity = $row['quantity'];
                            $time_submitted = $row['time_submitted'];
                            $time_ended = $row['time_ended'];

                            // Get item name from Menu table
                            $itemQuery = "SELECT item_name FROM Menu WHERE item_id = '$item_id'";
                            $itemResult = mysqli_query($link, $itemQuery);
                            $itemRow = mysqli_fetch_assoc($itemResult);
                            $item_name = $itemRow['item_name']??"Deleted";

                            echo '<tr>';
                            echo '<td>' . $kitchen_id . '</td>';
                            echo '<td>' . $table_id . '</td>';
                            echo '<td>' . $item_name . '</td>';
                            echo '<td>' . $quantity . '</td>';
                            echo '<td>' . $time_submitted . '</td>';
                            echo '<td>' . ($time_ended ?: 'Not Ended') . '</td>';
                            echo '<td>';
                            if (!$time_ended) {
                                echo '<a style="background-color: blue" href="../posBackend/kitchenBackend/kitchen-panel-back.php?action=set_time_ended&kitchen_id=' . $kitchen_id . '" class="btn btn-danger">Done</a>';
                            }
                            
                            echo '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="7">No records in the Kitchen table.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
