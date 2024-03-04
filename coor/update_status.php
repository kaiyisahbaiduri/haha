<?php
// update_status.php

$servername = "localhost";
$username = "";
$password = "";
$dbname = "mydatabase";

// Create connection
$conn = new mysqli($localhost, $username, $password, $mydatabase);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recordId = $_POST['id'];
    $action = $_POST['action'];

    // Validate the action (approve or reject)
    if ($action === 'approve' || $action === 'reject') {
        // Update the status in the database
        $newStatus = ($action === 'approve') ? 'approve' : 'reject';
        $sql = "UPDATE your_table_name SET status = '$newStatus' WHERE id = $recordId";

        if ($conn->query($sql) === TRUE) {
            echo 'success';
        } else {
            echo 'error';
        }
    } else {
        echo 'invalid_action';
    }
}

// Close the database connection
$conn->close();
?>
