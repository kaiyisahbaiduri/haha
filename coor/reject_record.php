<?php
include_once('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $recordId = $_POST['id'];

    // Update the status to "Rejected" (assuming 'status' is the column in your database)
    $updateSql = "UPDATE members SET status = 2 WHERE id = $recordId";
    $conn->query($updateSql);
}
?>
