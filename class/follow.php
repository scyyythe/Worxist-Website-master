<?php
session_start();
include '../include/connection.php';
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log');

if (isset($_POST['action'], $_POST['followed_id']) && isset($_SESSION['u_id'])) {
    $follower_id = $_SESSION['u_id'];
    $followed_id = intval($_POST['followed_id']);
    $action = $_POST['action'];

    if ($action === 'follow') {

        $statement = $conn->prepare("INSERT INTO user_follows (follower_id, following_id) VALUES (?, ?)");
        $statement->bindValue(1, $follower_id, PDO::PARAM_INT);
        $statement->bindValue(2, $followed_id, PDO::PARAM_INT);
        $statement->execute();

        $message = "You have a new follower!";
        $notificationQuery = $conn->prepare("INSERT INTO notifications (u_id, message) VALUES (:followed_id, :message)");
        $notificationQuery->bindValue(':followed_id', $followed_id, PDO::PARAM_INT);
        $notificationQuery->bindValue(':message', $message, PDO::PARAM_STR);
        $notificationQuery->execute();

        echo json_encode(["success" => true, "message" => "Followed successfully and notification sent."]);
    } elseif ($action === 'unfollow') {
  
        $statement = $conn->prepare("DELETE FROM user_follows WHERE follower_id = ? AND following_id = ?");
        $statement->bindValue(1, $follower_id, PDO::PARAM_INT);
        $statement->bindValue(2, $followed_id, PDO::PARAM_INT);
        $statement->execute();
        
        echo json_encode(["success" => true, "message" => "Unfollowed successfully."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}

?>
