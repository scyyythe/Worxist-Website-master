<?php
session_start();
include '../include/connection.php'; 
include 'accClass.php'; 
include 'interactClass.php'; 

$class = new artInteraction($conn);
header('Content-Type: application/json'); 

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

error_log("Raw input: " . $rawData);
$response = ['success' => false]; 

if (isset($data['action']) && isset($data['a_id'])) {
    $action = $data['action'];
    $a_id = $data['a_id'];

    if (isset($_SESSION['u_id'])) {
        switch ($action) {
            case 'addToFavorites':
                $response['success'] = $class->addToFavorites($a_id);
                $response['message'] = 'Arwork fav/unfav';
                break;
            case 'likeArtwork':
                $response['success'] = $class->likeArtwork($a_id);
                $response['message'] = 'Artwork liked/unliked'; 
                break;
            case 'saveArtwork':
                $response['success'] = $class->saveArtwork($a_id);
                $response['message'] = 'Artwork saved/unsaved'; 
                break;
            default:
                $response['message'] = 'Invalid action'; 
                break;
        }
    } else {
        $response['message'] = 'User not logged in'; 
    }
} else {
    $response['message'] = 'Invalid data'; 
}


echo json_encode($response);
?>
