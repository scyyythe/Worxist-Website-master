<?php
// restore_exhibit.php

require_once '../include/connection.php';

if (isset($_POST['exbt_id'])) {
    $exbt_id = $_POST['exbt_id'];

    try {
        // Prepare the SQL query to restore the exhibit
        $query = "UPDATE exhibit_tbl SET exbt_status = 'Pending' WHERE exbt_id = :exbt_id";
        $stmt = $conn->prepare($query);

        // Bind the value using bindValue() method
        $stmt->bindValue(':exbt_id', $exbt_id, PDO::PARAM_INT);

        // Execute the statement
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to restore exhibit']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Exhibit ID not provided']);
}
?>
