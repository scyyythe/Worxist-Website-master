<?php
class AccountManager
{
    private $conn;
    
    public function __construct($db_conn)
    {
        $this->conn = $db_conn;
      
    }

    public function login($username, $password)
    {
        $statement = $this->conn->prepare("SELECT u_id, u_name, username, email, password, u_type, u_status FROM accounts WHERE username = :username");
        $statement->bindValue(':username', $username);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);
    
        
        if ($user) {
            if ($user['u_status'] === 'Archived') {
                return "Your account is archived. Please contact support.";
            }

            if (password_verify($password, $user['password'])) {
    
                $_SESSION['u_id'] = $user['u_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['name'] = $user['u_name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['u_type'] = $user['u_type'];
    
                $_SESSION['loggedin'] = true;
    
                
                if ($user['u_type'] === 'Admin') {
                    header("Location: admin/admin.php");
                } elseif ($user['u_type'] === 'User') {
                    header("Location: dashboard.php");
                } elseif ($user['u_type'] === 'Organizer') {
                    header("Location: organizer/org.php");
                }
                die;
            } else {
                return "Incorrect password.";
            }
        }
    
        return "Incorrect username or password.";
    }
    

    public function register($name, $email, $username, $password)
    {
        $accType = 'User';
        $accStatus = 'Active';
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
        $statement = $this->conn->prepare("INSERT INTO accounts (u_name, email, username, password, u_type, u_status) 
                                           VALUES (:name, :email, :username, :hashed_password, :accType, :accStatus)");
        $statement->bindValue(':name', $name);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':hashed_password', $hashed_password);
        $statement->bindValue(':accType', $accType);
        $statement->bindValue(':accStatus', $accStatus);
    
        if ($statement->execute()) {
            $_SESSION['username'] = $username;
            $_SESSION['name'] = $name;
            $_SESSION['hashed_password'] = $hashed_password;
            $_SESSION['email'] = $email;
            $_SESSION['accType'] = $accType;
            $_SESSION['accStatus'] = $accStatus;
            
          
            return "Registration Complete.";
        }
    
        return "Registration failed. Please try again.";
    }
    

    public function getUsers() {
        try {
            $query = "SELECT u_id, profile, u_name, username, email, u_status FROM accounts 
                      WHERE u_type = 'User' AND u_status IN ('Active', 'Banned', 'Inactive')";
            $statement = $this->conn->prepare($query);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error fetching users: ' . $e->getMessage());
            return []; 
        }
    }
    
    

    public function getAccountInfo($u_id)
    {
        $sql = "SELECT * FROM accounts WHERE u_id = :u_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':u_id', $u_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function changeName($u_id, $new_name)
    {
        $sql = "UPDATE accounts SET u_name = :new_name WHERE u_id = :u_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':new_name', $new_name, PDO::PARAM_STR);
        $stmt->bindValue(':u_id', $u_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

   
    public function changePassword($u_id, $new_password)
    {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE accounts SET password = :new_password WHERE u_id = :u_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':new_password', $hashed_password, PDO::PARAM_STR);
        $stmt->bindValue(':u_id', $u_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function changeEmail($u_id, $new_email)
    {
        $sql = "UPDATE accounts SET email = :new_email WHERE u_id = :u_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':new_email', $new_email, PDO::PARAM_STR);
        $stmt->bindValue(':u_id', $u_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function changeUsername($u_id, $new_username) {
        if (empty($new_username) || strlen($new_username) < 3) {
            throw new Exception('Username must be at least 3 characters.');
        }
    
        // Check if username exists
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM accounts WHERE username = :new_username");
        $stmt->bindValue(':new_username', $new_username, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->fetchColumn() > 0) {
            throw new Exception('Username already exists.');
        }
    
        // Update username
        $stmt = $this->conn->prepare("UPDATE accounts SET username = :new_username WHERE u_id = :u_id");
        $stmt->bindValue(':new_username', $new_username, PDO::PARAM_STR);
        $stmt->bindValue(':u_id', $u_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return true;
        }
    
        throw new Exception('Failed to update username.');
    }
    
    
    

    public function deleteAccount($u_id)
    {
        $sql = "DELETE FROM accounts WHERE u_id = :u_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':u_id', $u_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

  public function archiveUser($u_id) {
        $sql = "UPDATE accounts SET u_status = 'Archived' WHERE u_id = :u_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':u_id', $u_id, PDO::PARAM_INT);
        return $stmt->execute();  
    }
    
    

    
    public function uploadProfilePicture($file) {

        if ($file['error'] == 0) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($file['type'], $allowedTypes)) {
                echo "Invalid file type.";
                return;
            }
    
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $userId = $_SESSION['u_id'];
            $userFolder = 'profile_pics/' . $userId;
            if (!is_dir($userFolder)) {
                mkdir($userFolder, 0755, true); 
            }
            
            // Generate a unique file name based on current time
            $fileName = time() . '_' . basename($file['name']);
            $filePath = $userFolder . '/' . $fileName;
    
            // Move the uploaded file to the user's folder
            if (move_uploaded_file($file['tmp_name'], $filePath)) {
                // Save the relative file path in the database
                $relativeFilePath = $userId . '/' . $fileName;
                $statement = $this->conn->prepare("UPDATE accounts SET profile = :filePath WHERE u_id = :u_id");
                $statement->bindValue(':filePath', $relativeFilePath);
                $statement->bindValue(':u_id', $userId);
                $statement->execute();
    
                 $_SESSION['profile'] = $relativeFilePath;
                header("Location: dashboard.php");
                exit;
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "No file selected or error in file upload.";
        }
    }
    
    public function getProfilePicture() {
      
        $userId = $_SESSION['u_id']; 

        $statement = $this->conn->prepare("SELECT profile FROM accounts WHERE u_id = :u_id");
        $statement->bindValue(':u_id', $userId);
        $statement->execute();
        $userInfo = $statement->fetch(PDO::FETCH_ASSOC);

        $profilePic = isset($userInfo['profile']) ? $userInfo['profile'] : null;
        $imagePath = $profilePic ? 'profile_pics/' . $profilePic : 'gallery/girl.jpg'; 
        return $imagePath;
    }
        
    public function removeProfilePicture() {
        
        $statement = $this->conn->prepare("UPDATE accounts SET profile = NULL WHERE u_id = :u_id");
        $statement->bindValue(':u_id', $_SESSION['u_id']);
        $statement->execute();

     
        $filePath = 'profile_pics/' . $_SESSION['u_id'] . '_profile.jpg';
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        
        header("Location: dashboard.php");
        exit;
    }

    
}


//upload ug image
class ArtUploader {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    private function randomString($n) {
        $characters = '0123456789abcdefghijklmnopqrstunvwxyzABCDEFGHIJKLMNOPQRSTUNVWXYZ';
        $str = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $str .= $characters[$index];
        }

        return $str;
    }

    public function uploadArtwork($file, $title, $description, $category) {
        if (!is_dir('files')) {
            mkdir('files');
        }
    
        $a_status = 'Pending';
        $u_id = $_SESSION['u_id'];
        $date = date('Y-m-d');  
        $filePath = '';
    
        if ($file && $file['tmp_name']) {
            $filePath = 'files/' . $this->randomString(8) . '/' . $file['name'];
            mkdir(dirname($filePath));
            move_uploaded_file($file['tmp_name'], $filePath);
        }
    
        $statement = $this->conn->prepare("INSERT INTO art_info (u_id, title, description, category, file, date, a_status) VALUES (:u_id, :title, :description, :category, :file, :date, :a_status)");
    
       
        $statement->bindValue(':u_id', $u_id);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':category', $category);
        $statement->bindValue(':file', $filePath);
        $statement->bindValue(':date', $date);
        $statement->bindValue(':a_status', $a_status);
    
        $result = $statement->execute();
    
        if ($result) {
            $_SESSION['title'] = $title;
            $_SESSION['description'] = $description;
            $_SESSION['category'] = $category;
            $_SESSION['file'] = $filePath;
            $_SESSION['date'] = $date;
            $_SESSION['a_status'] = $a_status;
    
            header("Location: dashboard.php");
            exit;
        }
    }
    
}




?>
