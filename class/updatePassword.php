<?php
session_start();
header('Content-Type: application/json');  // Ensure correct content-type

// Make sure the user is logged in (check session)
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];

    include("include/connection.php");

    $userId = $_SESSION['u_id'];

    $stmt = $conn->prepare("SELECT password FROM accounts WHERE u_id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($currentPassword, $user['password'])) {
       
        $newPasswordHashed = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateStmt = $conn->prepare("UPDATE accounts SET password = ? WHERE u_id = ?");
        $updateStmt->execute([$newPasswordHashed, $userId]);

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Current password is incorrect']);
    }
    exit;
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}
?>
