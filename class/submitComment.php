<?php
session_start();
include '../include/connection.php';
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log'); 


header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$comment = $data['comment'];
$a_id = $data['artworkId'];
$u_id = isset($_SESSION['u_id']) ? $_SESSION['u_id'] : null;

if (!$u_id) {
    echo json_encode(['success' => false, 'message' => 'Session not found.']);
    exit;
}

if (!empty($comment) && !empty($a_id) && !empty($u_id)) {
    try {
        $query = "INSERT INTO comment (u_id, a_id, content) VALUES (:u_id, :a_id, :content)";
        $statement = $conn->prepare($query);
        $statement->bindValue(':u_id', $u_id, PDO::PARAM_INT);
        $statement->bindValue(':a_id', $a_id, PDO::PARAM_INT);
        $statement->bindValue(':content', $comment, PDO::PARAM_STR);

        if ($statement->execute()) {
            echo json_encode([
                'success' => true,
                'userImage' => $_SESSION['profile'],
                'username' => $_SESSION['username'],
                'content' => htmlspecialchars($comment, ENT_QUOTES),
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add comment.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
}
exit;
?>
