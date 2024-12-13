<?php
require_once '../include/connection.php';
header('Content-Type: application/json');

try {
    $query = "SELECT * FROM exhibit_tbl WHERE exbt_status = :status";
    $stmt = $conn->prepare($query);

    $status = 'Declined';
    $stmt->bindValue(':status', $status, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch all the declined exhibits
    $exhibits = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($exhibits) {
        echo json_encode($exhibits);
    } else {
        // Return an empty array if no declined exhibits found
        echo json_encode([]);
    }

} catch (PDOException $e) {
    // Return an error message in case of failure
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
    error_log($e->getMessage()); // Log the error for further investigation
}
exit();
?>
