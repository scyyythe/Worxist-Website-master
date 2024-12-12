<?php
session_start();
include '../include/connection.php';

if (isset($_POST['uploadProfilePic'])) {
    // Check if file is uploaded
    if (isset($_FILES['profilePic']) && $_FILES['profilePic']['error'] == UPLOAD_ERR_OK) {
        $file = $_FILES['profilePic'];

        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            echo "Invalid file type.";
            exit;
        }

        // Validate file size (max 10MB)
        if ($file['size'] > 10 * 1024 * 1024) {
            echo "File is too large. Max file size is 10MB.";
            exit;
        }

        // Get user ID from session
        if (!isset($_SESSION['u_id'])) {
            echo "You must be logged in to upload a profile picture.";
            exit;
        }
        $userId = $_SESSION['u_id'];

        // Set the folder for profile pictures
        $userFolder = 'profile_pics/' . $userId;
        if (!is_dir($userFolder)) {
            mkdir($userFolder, 0755, true);
        }

        // Generate a unique file name
        $fileName = time() . '_' . basename($file['name']);
        $filePath = $userFolder . '/' . $fileName;

        // Move the uploaded file to the user's folder
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            // Save the relative file path in the database
            $relativeFilePath = $userId . '/' . $fileName;
            $statement = $conn->prepare("UPDATE accounts SET profile = :filePath WHERE u_id = :u_id");
            $statement->bindValue(':filePath', $relativeFilePath);
            $statement->bindValue(':u_id', $userId);

            // Check if the query executed successfully
            if ($statement->execute()) {
                // Update session with the new profile picture path
                $_SESSION['profile'] = $relativeFilePath;
                echo "Profile picture uploaded successfully!";
                header("Location: dashboard.php"); // Redirect to dashboard
                exit;
            } else {
                echo "Error updating profile in the database: " . $statement->errorInfo()[2]; // Error in database query
            }
        } else {
            echo "Error moving file.";
        }
    } else {
        echo "Error uploading file. Error code: " . $_FILES['profilePic']['error'];
    }
} else {
    echo "No file selected.";
}
?>
