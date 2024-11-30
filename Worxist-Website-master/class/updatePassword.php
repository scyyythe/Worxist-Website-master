<?php
// Assuming you're connected to the database
include("include/connection.php");

$data = json_decode(file_get_contents('php://input'), true);
$currentPassword = $data['currentPassword'];
$newPassword = $data['newPassword'];
$userId = $_SESSION['u_id']; 

$query = "SELECT password FROM accounts WHERE u_id = :userId";
$stmt = $conn->prepare($query);
$stmt->bindValue(':userId', $userId, PDO::PARAM_INT); // Use bindValue here
$stmt->execute();
$currentPasswordFromDb = $stmt->fetchColumn();

if (!password_verify($currentPassword, $currentPasswordFromDb)) {
    echo json_encode(['success' => false, 'error' => 'Current password is incorrect.']);
    exit();
}

$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

$updateQuery = "UPDATE accounts SET password = :newPassword WHERE u_id = :userId";
$stmt = $conn->prepare($updateQuery);
$stmt->bindValue(':newPassword', $hashedPassword, PDO::PARAM_STR); // Use bindValue here
$stmt->bindValue(':userId', $userId, PDO::PARAM_INT); // Use bindValue here

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to update password.']);
}
?>
