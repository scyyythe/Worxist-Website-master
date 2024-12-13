<?php
require_once '../include/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['exbt_id']) && !empty($_POST['exbt_id']) && isset($_POST['status']) && !empty($_POST['status'])) {
        $exbt_id = $_POST['exbt_id'];
        $status = $_POST['status'];

        if ($status === 'Pending') {
            try {
                global $conn;

                $query = "UPDATE exhibit_tbl SET exbt_status = :status WHERE exbt_id = :exbt_id";
                $stmt = $conn->prepare($query);
                $stmt->bindValue(':status', $status, PDO::PARAM_STR);
                $stmt->bindValue(':exbt_id', $exbt_id, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    echo "Exhibit status updated to Pending successfully!";
                } else {
                    echo "Failed to update the exhibit status.";
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Invalid status.";
        }
    } else {
        echo "exbt_id and status are required.";
    }
}
?>
