<?php 
class artManager
{
    private $conn;
    private $u_id;

    public function __construct($db_conn)
    {
        $this->conn = $db_conn;
        $this->u_id = $_SESSION['u_id'];
    }

    public function updateArtwork($a_id, $title, $description, $category) {
        $statement = $this->conn->prepare("
            UPDATE art_info 
            SET title = :title, description = :description, category = :category 
            WHERE a_id = :a_id
        ");
        $statement->bindValue(':a_id', $a_id);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':category', $category);
        return $statement->execute();
    }


    public function deleteArtwork($a_id) {
        try {
            $statement = $this->conn->prepare("DELETE FROM art_info WHERE a_id = :a_id");
            $statement->bindValue(':a_id', $a_id);
    
            if ($statement->execute()) {
                return true;
            } else {
                
                echo "Error: Could not delete artwork. " . implode(", ", $statement->errorInfo());
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
    public function getArtworkById($artworkId) {
        $statement = $this->conn->prepare("
            SELECT art_info.file, art_info.title, art_info.description, art_info.category
            FROM art_info
            WHERE art_info.a_id = :a_id
        ");
        $statement->bindValue(':a_id', $artworkId);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getUserArtworks() {
        $statement = $this->conn->prepare("
            SELECT 
                accounts.u_id, 
                art_info.file, 
                accounts.u_name, 
                art_info.a_id, 
                art_info.title, 
                art_info.description,
                art_info.date, 
                art_info.category,
                COALESCE(COUNT(DISTINCT likes.u_id), 0) AS likes_count,
                COALESCE(COUNT(DISTINCT saved.u_id), 0) AS saved_count,
                COALESCE(COUNT(DISTINCT favorite.u_id), 0) AS favorites_count
            FROM art_info 
            JOIN accounts ON art_info.u_id = accounts.u_id
            LEFT JOIN likes ON art_info.a_id = likes.a_id
            LEFT JOIN saved ON art_info.a_id = saved.a_id
            LEFT JOIN favorite ON art_info.a_id = favorite.a_id
            WHERE accounts.u_id = :u_id AND art_info.a_status = 'Approved'
            GROUP BY art_info.a_id
        ");
        $statement->bindValue(':u_id', $this->u_id);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getPendingArtworks() {
        $statement = $this->conn->prepare("
            SELECT 
                accounts.u_id, 
                art_info.file, 
                accounts.u_name, 
                art_info.a_id, 
                art_info.title, 
                art_info.description,
                art_info.date, 
                art_info.category,
                COALESCE(COUNT(DISTINCT likes.u_id), 0) AS likes_count,
                COALESCE(COUNT(DISTINCT saved.u_id), 0) AS saved_count,
                COALESCE(COUNT(DISTINCT favorite.u_id), 0) AS favorites_count
            FROM art_info 
            JOIN accounts ON art_info.u_id = accounts.u_id
            LEFT JOIN likes ON art_info.a_id = likes.a_id
            LEFT JOIN saved ON art_info.a_id = saved.a_id
            LEFT JOIN favorite ON art_info.a_id = favorite.a_id
            WHERE accounts.u_id = :u_id AND art_info.a_status = 'Pending'
            GROUP BY art_info.a_id
        ");
        $statement->bindValue(':u_id', $this->u_id);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getCollabArtworks($exbt_id) {
        $loggedInUserId = $_SESSION['u_id'];
        $checkArtworksQuery = "
            SELECT art_info.file, art_info.a_id, art_info.title, art_info.description, art_info.category
            FROM art_info
            JOIN exhibit_artworks ON art_info.a_id = exhibit_artworks.a_id
            WHERE exhibit_artworks.exbt_id = :exbt_id
            AND art_info.u_id = :loggedInUserId
        ";
    
        $stmtArtworks = $this->conn->prepare($checkArtworksQuery);
        $stmtArtworks->bindValue(':exbt_id', $exbt_id, PDO::PARAM_INT);
        $stmtArtworks->bindValue(':loggedInUserId', $loggedInUserId, PDO::PARAM_INT); 
        $stmtArtworks->execute();
        return $stmtArtworks->fetchAll(PDO::FETCH_ASSOC);
    }


    public function visitArtworks($userId){
        $statement = $this->conn->prepare("SELECT a_id, file, title, description, category FROM art_info WHERE u_id = :u_id");
        $statement->bindValue(':u_id', $userId); 
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAllArtworks($category = null) {
        $query = "
            SELECT 
                accounts.u_id, 
                art_info.file, 
                accounts.u_name, 
                accounts.profile, 
                art_info.a_id, 
                art_info.title, 
                art_info.description, 
                art_info.date, 
                art_info.category,
                art_info.a_status,
                COUNT(DISTINCT likes.u_id) AS likes_count,
                COUNT(DISTINCT saved.u_id) AS saved_count,
                COUNT(DISTINCT favorite.u_id) AS favorites_count,
                (SELECT GROUP_CONCAT(
                    CONCAT(accounts.u_name, '::', comment.content, '::', accounts.profile)
                    ORDER BY comment.comment_id DESC) 
                FROM comment 
                JOIN accounts ON comment.u_id = accounts.u_id
                WHERE comment.a_id = art_info.a_id) AS comments

            FROM art_info
            JOIN accounts ON art_info.u_id = accounts.u_id
            LEFT JOIN likes ON art_info.a_id = likes.a_id
            LEFT JOIN saved ON art_info.a_id = saved.a_id
            LEFT JOIN favorite ON art_info.a_id = favorite.a_id
            LEFT JOIN comment ON art_info.a_id = comment.a_id
            WHERE art_info.a_status = 'approved'
        ";
        
        if ($category) {
            $query .= " AND art_info.category = :category";
        }
        $query .= " GROUP BY art_info.a_id";
        $statement = $this->conn->prepare($query);
        if ($category) {
            $statement->bindParam(':category', $category);
        }
        
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return $results;

    }
    
    public function getPendingRequests() {
        $statement = $this->conn->prepare("
            SELECT art_info.a_id, art_info.file, art_info.title, accounts.u_name AS artist_name, accounts.profile AS artist_profile
            FROM art_info
            INNER JOIN accounts ON art_info.u_id = accounts.u_id
            WHERE art_info.a_status = 'Pending'
        ");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function approveAllRequests() {
        $response = ['success' => false, 'message' => ''];
    
        try {
            
            $query = "UPDATE art_info SET a_status = 'Approved' WHERE a_status = 'Pending'";
            $statement = $this->conn->prepare($query);
    
            if ($statement->execute()) {
                $response['success'] = true;
                $response['message'] = 'All requests have been approved successfully.';
            } else {
                $response['message'] = 'Could not approve all requests.';
            }
        } catch (PDOException $e) {
            $response['message'] = 'Error: ' . $e->getMessage();
            error_log('Error in approveAllRequests: ' . $e->getMessage()); 
        }
    
        return $response;
    }
    
  
    public function handleArtworkRequest($action, $a_id) {
        $status = ($action === 'approve') ? 'Approved' : 'Declined'; 
    
        try {
            $this->conn->beginTransaction();
    
            $stmt = $this->conn->prepare("SELECT u_id, ban_end_date, u_status FROM accounts WHERE u_id = (SELECT u_id FROM art_info WHERE a_id = :a_id)");
            $stmt->bindValue(':a_id', $a_id);
            $stmt->execute();
            $user = $stmt->fetch();
    
            if ($user) {
                $banEndDate = $user['ban_end_date'];
                $currentDate = date('Y-m-d H:i:s');
    
                if ($user['u_status'] === 'Banned' && strtotime($banEndDate) < strtotime($currentDate)) {
                    $stmt = $this->conn->prepare("UPDATE accounts SET u_status = 'Active' WHERE u_id = :u_id");
                    $stmt->bindValue(':u_id', $user['u_id']);
                    $stmt->execute();
                }
            }
    
            $stmt = $this->conn->prepare("UPDATE art_info SET a_status = :status WHERE a_id = :a_id");
            $stmt->bindValue(':status', $status);
            $stmt->bindValue(':a_id', $a_id);
            $stmt->execute();
    
            if ($action === 'decline') {
                $stmt = $this->conn->prepare("SELECT u_id FROM art_info WHERE a_id = :a_id");
                $stmt->bindValue(':a_id', $a_id);
                $stmt->execute();
                $user = $stmt->fetch();
    
                if ($user) {
                    $u_id = $user['u_id'];
                    $stmt = $this->conn->prepare("UPDATE accounts SET u_status = 'Banned', ban_end_date = DATE_ADD(NOW(), INTERVAL 7 DAY) WHERE u_id = :u_id");
                    $stmt->bindValue(':u_id', $u_id);
                    $stmt->execute();
    
                    $notificationMessage = "Your artwork has been declined and your account is banned for posting artwork for 7 days.";
                    $this->sendNotification($u_id, $notificationMessage);
                }
            } else if ($action === 'approve') {
                $stmt = $this->conn->prepare("SELECT u_id FROM art_info WHERE a_id = :a_id");
                $stmt->bindValue(':a_id', $a_id);
                $stmt->execute();
                $user = $stmt->fetch();
    
                if ($user) {
                    $u_id = $user['u_id'];
                    $notificationMessage = "Your artwork has been approved.";
                    $this->sendNotification($u_id, $notificationMessage);
                }
            }
    
            $this->conn->commit();
    
            if ($stmt->rowCount() > 0) {
                return [
                    'success' => true,
                    'message' => 'Post has been ' . $status
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'No changes made. Please try again.'
                ];
            }
    
        } catch (Exception $e) {
            $this->conn->rollBack();
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }
    
    private function sendNotification($u_id, $message) {
        try {
            $stmt = $this->conn->prepare("INSERT INTO notifications (u_id, message, is_read) VALUES (:u_id, :message, 0)");
            $stmt->bindValue(':u_id', $u_id);
            $stmt->bindValue(':message', $message);
            $stmt->execute();
        } catch (Exception $e) {
            echo "Error sending notification: " . $e->getMessage();
        }
    }
    
    
    
    
    
    

}
?>