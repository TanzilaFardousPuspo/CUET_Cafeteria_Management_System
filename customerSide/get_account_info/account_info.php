<?php
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','restaurantdb');

//Create Connection
$link = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

//Check COnnection
if($link->connect_error){ //if not Connection
die('Connection Failed'.$link->connect_error);//kills the Connection OR terminate execution
}
// Get the user_id from the URL parameter
$user_id = $_GET['user_id'];

// Prepare SQL query to retrieve user information
$sql = "SELECT * FROM users WHERE user_id = $user_id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        // Display user information in the HTML interface
        echo "<h1>User Information</h1>";
        echo "<p>User ID: " . $row['user_id'] . "</p>";
        echo "<p>Name: " . $row['name'] . "</p>";
        echo "<p>Email: " . $row['email'] . "</p>";
        // Add more fields as needed
    }
} else {
    echo "No user found with the provided ID";
}

$conn->close();
?>
