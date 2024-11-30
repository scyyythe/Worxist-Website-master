<?php
session_start();
include 'include/connection.php'; 
include 'class/accClass.php'; 

$accountManager = new AccountManager($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        $u_id = $_SESSION['u_id']; 

        if ($action == 'change_name' && isset($_POST['new_name']) && !empty($_POST['new_name'])) {
            $new_name = $_POST['new_name'];
            if ($accountManager->changeName($u_id, $new_name)) {
                $_SESSION['name'] = $new_name; 
                header("Location: dashboard.php");
                exit(); 
            } else {
                echo "Error updating name.";
            }

        } elseif ($action == 'change_password' && isset($_POST['new_password']) && !empty($_POST['new_password'])) {
            $new_password = $_POST['new_password'];
            if ($accountManager->changePassword($u_id, $new_password)) {
                header("Location: dashboard.php");
                exit();
            } else {
                echo "Error updating password.";
            }

        } elseif ($action == 'change_email' && isset($_POST['new_email']) && !empty($_POST['new_email'])) {
            $new_email = $_POST['new_email'];
            if ($accountManager->changeEmail($u_id, $new_email)) {
                $_SESSION['email'] = $new_email; 
                header("Location: dashboard.php");
                exit();
            } else {
                echo "Error updating email.";
            }

        } elseif ($action == 'change_username' && isset($_POST['new_username']) && !empty($_POST['new_username'])) {
            $new_username = $_POST['new_username'];
            if ($accountManager->changeUsername($u_id, $new_username)) {
                $_SESSION['username'] = $new_username; 
                header("Location: dashboard.php");
                exit();
            } else {
                echo "Error updating username.";
            }

        } elseif ($action == 'delete_account') {
            if ($accountManager->deleteAccount($u_id)) {
                echo "Account deleted successfully!";
                session_destroy();
                header("Location: index.php");
                exit();
            } else {
                echo "Error deleting account.";
            }
        }
    } else {
        echo "Invalid action!";
    }
} else {
    echo "Invalid request!";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dashboard.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="gallery/image/vags-logo.png" type="image/x-icon">
    <title>Account Details</title>
</head>
<body>

    <div class="update-container">
       
         <form action="change.php" method="POST">
            <h2>Update Account Information</h2><br>
            <input type="hidden" name="action" value="change_name">
            <div class="form-group">
                <label for="new_name">Your Name:</label><br>
                <input type="text" id="new_name" name="new_name" placeholder="Enter your new name" required>
            </div>
            <button type="submit">Change Name</button>
        </form>
        <br>
        <form action="change.php" method="POST">
            <input type="hidden" name="action" value="change_email">
            <div class="form-group">
                <label for="new_email">Enter New Email:</label><br>
                <input type="email" id="new_email" name="new_email" placeholder="Enter your new email" required>
            </div>
            <button type="submit">Change Email</button>
        </form>
        <br>
        <form action="change.php" method="POST">
            <input type="hidden" name="action" value="change_password">
            <div class="form-group">
                <label for="new_password">Enter New Password:</label><br>
                <input type="password" id="new_password" name="new_password" placeholder="Enter your new password" required>
            </div>
            <button type="submit">Change Password</button>
        </form>
        <br>
        <form action="change.php" method="POST">
            <input type="hidden" name="action" value="delete_account">
            <div class="form-group">
                <h3>Delete Account</h3>
                <p>Are you sure you want to delete your account? This action cannot be undone.</p>
            </div>
            <button type="submit" id="delete-acc">Delete My Account</button>
        </form>
    </div>
        
       

   
</body>
</html>
