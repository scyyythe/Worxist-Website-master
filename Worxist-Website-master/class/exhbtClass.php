<?php
class ExhibitManager {
    private $conn;
    private $u_id;

    public function __construct($db_conn) {
        $this->conn = $db_conn;
        $this->u_id = $_SESSION['u_id'];
    }

    public function requestSoloExhibit($exbt_title, $exbt_descrip, $exbt_date, $selected_artworks) {
        $exbt_type = 'Solo';
        $exbt_status = 'Pending';

        if (is_string($selected_artworks)) {
            $selectedArtworks = json_decode($selected_artworks, true);
            if ($selectedArtworks === null || empty($selectedArtworks)) {
                error_log("No artworks selected or invalid JSON.");
                return;
            }
        } elseif (is_array($selected_artworks)) {
            $selectedArtworks = $selected_artworks; 
        } else {
            error_log("Invalid data format for selected_artworks.");
            return;
        }

        $this->conn->beginTransaction();

        try {
            $statement = $this->conn->prepare("
                INSERT INTO exhibit_tbl (u_id, exbt_title, exbt_descrip, exbt_date, exbt_type, exbt_status)
                VALUES (:u_id, :exbt_title, :exbt_descrip, :exbt_date, :exbt_type, :exbt_status)
            ");
            $statement->bindValue(':u_id', $this->u_id, PDO::PARAM_INT);
            $statement->bindValue(':exbt_title', $exbt_title);
            $statement->bindValue(':exbt_descrip', $exbt_descrip);
            $statement->bindValue(':exbt_date', $exbt_date);
            $statement->bindValue(':exbt_type', $exbt_type);
            $statement->bindValue(':exbt_status', $exbt_status);

            if (!$statement->execute()) {
                throw new Exception("Failed to insert into exhibit_tbl: " . implode(", ", $statement->errorInfo()));
            }

            $exbt_id = $this->conn->lastInsertId();

            foreach ($selectedArtworks as $a_id) {
                $checkStmt = $this->conn->prepare("SELECT COUNT(*) FROM art_info WHERE a_id = :a_id");
                $checkStmt->bindValue(':a_id', $a_id, PDO::PARAM_INT);
                $checkStmt->execute();

                if ($checkStmt->fetchColumn()) {
                    $artworkStmt = $this->conn->prepare("
                        INSERT INTO exhibit_artworks (exbt_id, a_id)
                        VALUES (:exbt_id, :a_id)
                    ");
                    $artworkStmt->bindValue(':exbt_id', $exbt_id, PDO::PARAM_INT);
                    $artworkStmt->bindValue(':a_id', $a_id, PDO::PARAM_INT);
                    if (!$artworkStmt->execute()) {
                        throw new Exception("Failed to insert into exhibit_artworks for artwork ID $a_id: " . implode(", ", $artworkStmt->errorInfo()));
                    }
                } else {
                    error_log("Invalid artwork ID: " . $a_id);
                }
            }

            $this->conn->commit();
            header("Location: dashboard.php");
            exit;  
        } catch (Exception $e) {
            $this->conn->rollBack();
            error_log("Error: " . $e->getMessage());
            header("Location: dashboard.php?error=true");  
            exit;
        }
    }

    public function requestCollabExhibit($exbt_title, $exbt_descrip, $exbt_date, $selected_artworks, $selected_collaborators) {
        $exbt_type = 'Collaborate';  
        $exbt_status = 'Pending';
    
        $this->conn->beginTransaction();
    
        try {
            // Insert into exhibit_tbl
            $statement = $this->conn->prepare("
                INSERT INTO exhibit_tbl (u_id, exbt_title, exbt_descrip, exbt_date, exbt_type, exbt_status)
                VALUES (:u_id, :exbt_title, :exbt_descrip, :exbt_date, :exbt_type, :exbt_status)
            ");
            $statement->bindValue(':u_id', $this->u_id, PDO::PARAM_INT);
            $statement->bindValue(':exbt_title', $exbt_title);
            $statement->bindValue(':exbt_descrip', $exbt_descrip);
            $statement->bindValue(':exbt_date', $exbt_date);
            $statement->bindValue(':exbt_type', $exbt_type);
            $statement->bindValue(':exbt_status', $exbt_status);
    
            if (!$statement->execute()) {
                throw new Exception("Failed to insert into exhibit_tbl: " . implode(", ", $statement->errorInfo()));
            }
    
            $exbt_id = $this->conn->lastInsertId();
    
            // Process selected artworks
            error_log("Selected Artworks: " . print_r($selected_artworks, true));
            $selectedArtworks = json_decode($selected_artworks, true);
            if (!empty($selectedArtworks) && is_array($selectedArtworks)) {
                foreach ($selectedArtworks as $a_id) {
                    $checkStmt = $this->conn->prepare("SELECT COUNT(*) FROM art_info WHERE a_id = :a_id");
                    $checkStmt->bindValue(':a_id', $a_id, PDO::PARAM_INT);
                    $checkStmt->execute();
    
                    if ($checkStmt->fetchColumn()) {
                        $artworkStmt = $this->conn->prepare("
                            INSERT INTO exhibit_artworks (exbt_id, a_id)
                            VALUES (:exbt_id, :a_id)
                        ");
                        $artworkStmt->bindValue(':exbt_id', $exbt_id, PDO::PARAM_INT);
                        $artworkStmt->bindValue(':a_id', $a_id, PDO::PARAM_INT);
    
                        if (!$artworkStmt->execute()) {
                            throw new Exception("Failed to insert into exhibit_artworks for artwork ID $a_id: " . implode(", ", $artworkStmt->errorInfo()));
                        }
                    } else {
                        error_log("Invalid artwork ID: " . $a_id);
                    }
                }
            } else {
                error_log("No artworks selected or invalid format.");
            }
    
            // Process collaborators
            $collaborators = explode(',', $selected_collaborators);
            foreach ($collaborators as $u_id) {
                $checkStmt = $this->conn->prepare("SELECT COUNT(*) FROM accounts WHERE u_id = :u_id");
                $checkStmt->bindValue(':u_id', $u_id, PDO::PARAM_INT);
                $checkStmt->execute();
    
                if ($checkStmt->fetchColumn()) {
                    $collabStmt = $this->conn->prepare("
                        INSERT INTO collab_exhibit (exbt_id, u_id)
                        VALUES (:exbt_id, :u_id)
                    ");
                    $collabStmt->bindValue(':exbt_id', $exbt_id, PDO::PARAM_INT);
                    $collabStmt->bindValue(':u_id', $u_id, PDO::PARAM_INT);
    
                    if (!$collabStmt->execute()) {
                        throw new Exception("Failed to insert collaborator into collab_exhibit for collaborator ID $u_id: " . implode(", ", $collabStmt->errorInfo()));
                    }
    
                    // Insert notification for collaborator
                    $notificationStmt = $this->conn->prepare("
                        INSERT INTO notifications (u_id, exbt_id, message)
                        VALUES (:u_id, :exbt_id, :message)
                    ");
                    $notificationMessage = "You have been added as a collaborator to the exhibit: $exbt_title.";
                    $notificationStmt->bindValue(':u_id', $u_id, PDO::PARAM_INT);
                    $notificationStmt->bindValue(':exbt_id', $exbt_id, PDO::PARAM_INT);
                    $notificationStmt->bindValue(':message', $notificationMessage, PDO::PARAM_STR);
    
                    if (!$notificationStmt->execute()) {
                        throw new Exception("Failed to insert notification for collaborator ID $u_id: " . implode(", ", $notificationStmt->errorInfo()));
                    }
                } else {
                    error_log("Invalid collaborator ID: " . $u_id);
                }
            }
    
            // Commit the transaction
            $this->conn->commit();
            header("Location: dashboard.php");
            exit; 
        } catch (Exception $e) {
            // Rollback on error
            $this->conn->rollBack();
            error_log("Error: " . $e->getMessage());
            header("Location: dashboard.php?error=true");
            exit;
        }
    }
    
    public function getNotifications($u_id) {
        $query = "SELECT * FROM notifications WHERE u_id = :u_id ORDER BY created_at DESC LIMIT 5"; 
        $statement = $this->conn->prepare($query);
        $statement->bindParam(':u_id', $u_id, PDO::PARAM_INT);
        
        // Execute the query and check if any records are found
        if ($statement->execute()) {
            $notifications = $statement->fetchAll(PDO::FETCH_ASSOC); 
    
            // Debug: Output the result to verify it's returning the expected data
            if (empty($notifications)) {
                error_log("No notifications found for user ID: $u_id");
            }
    
            return $notifications;
        } else {
            error_log("Error executing query: " . implode(" ", $statement->errorInfo()));
            return [];
        }
    }
    
    
    
    public function getAcceptedExhibits() {
        $statement = $this->conn->prepare("
            SELECT 
                exhibit_tbl.exbt_title, 
                exhibit_tbl.exbt_descrip, 
                art_info.title AS artwork_title, 
                art_info.description AS artwork_description, 
                art_info.file AS artwork_file, 
                art_info.u_id AS artist_id, 
                accounts.u_name AS u_name,
                accounts.profile AS profile_image  -- Add profile image
            FROM exhibit_tbl
            INNER JOIN exhibit_artworks ON exhibit_tbl.exbt_id = exhibit_artworks.exbt_id
            INNER JOIN art_info ON exhibit_artworks.a_id = art_info.a_id
            INNER JOIN accounts ON art_info.u_id = accounts.u_id
            WHERE exhibit_tbl.exbt_status = 'Accepted'
        ");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    //para sa carousel
    public function fetchCollaboratorsWithArtworks()
    {
        $statement = $this->conn->prepare("
            SELECT 
                exhibit_tbl.exbt_title, 
                exhibit_tbl.exbt_descrip, 
                art_info.title AS artwork_title, 
                art_info.description AS artwork_description, 
                art_info.file AS artwork_file, 
                art_info.u_id AS artist_id, 
                accounts.u_name AS u_name,
                accounts.profile AS profile_image,
                GROUP_CONCAT(collaborators.u_name) AS collaborator_names,
                GROUP_CONCAT(collab_exhibit.u_id) AS collaborator_ids
            FROM exhibit_tbl
            INNER JOIN exhibit_artworks ON exhibit_tbl.exbt_id = exhibit_artworks.exbt_id
            INNER JOIN art_info ON exhibit_artworks.a_id = art_info.a_id
            INNER JOIN accounts ON art_info.u_id = accounts.u_id
            LEFT JOIN collab_exhibit ON exhibit_tbl.exbt_id = collab_exhibit.exbt_id
            LEFT JOIN accounts AS collaborators ON collab_exhibit.u_id = collaborators.u_id
            WHERE exhibit_tbl.exbt_status = 'Accepted'
            GROUP BY exhibit_tbl.exbt_id, art_info.a_id;
        ");
        
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    
        $collaborators = [];
        foreach ($results as $row) {
            $artistId = $row['artist_id'];

            if (!isset($collaborators[$artistId])) {
                $collaborators[$artistId] = [
                    'u_name' => $row['u_name'],
                    'profile_image' => $row['profile_image'],
                    'artworks' => [],
                    'collaborators' => [] 
                ];
            }
    
            // Add the artwork
            $collaborators[$artistId]['artworks'][] = [
                'artwork_title' => $row['artwork_title'],
                'artwork_description' => $row['artwork_description'],
                'artwork_file' => $row['artwork_file']
            ];
    
            // Split the collaborator names and IDs into arrays
            $collaboratorNames = explode(',', $row['collaborator_names']);
            $collaboratorIds = explode(',', $row['collaborator_ids']);
    
            // Add collaborators if they exist and prevent duplicates
            foreach ($collaboratorNames as $index => $collaboratorName) {
                // Only add the collaborator if not already added
                if (!in_array($collaboratorName, array_column($collaborators[$artistId]['collaborators'], 'collaborator_name'))) {
                    $collaborators[$artistId]['collaborators'][] = [
                        'collaborator_name' => $collaboratorName,
                        'collaborator_id' => $collaboratorIds[$index]
                    ];
                }
            }
        }
    
        return array_values($collaborators);
    }
    
    
    //para sa oragniser/admin or sag asa
    public function getExhibitDetails($exhibitId) {
        $statement = $this->conn->prepare("
            SELECT 
                exhibit_tbl.*, 
                accounts.u_name AS organizer_name, 
                art_info.file AS artwork_file,
                collaborators.u_name AS collaborator_name
            FROM exhibit_tbl
            INNER JOIN accounts ON exhibit_tbl.u_id = accounts.u_id
            INNER JOIN exhibit_artworks ON exhibit_tbl.exbt_id = exhibit_artworks.exbt_id
            INNER JOIN art_info ON exhibit_artworks.a_id = art_info.a_id
            LEFT JOIN collab_exhibit ON exhibit_tbl.exbt_id = collab_exhibit.exbt_id  
            LEFT JOIN accounts AS collaborators ON collab_exhibit.u_id = collaborators.u_id  
            WHERE exhibit_tbl.exbt_id = ?
        ");
        $statement->bindValue(1, $exhibitId, PDO::PARAM_INT);
        $statement->execute();
    
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
    
        if (!$rows) {
            return null;
        }
    
        $result = [
            'exhibit' => $rows[0], 
            'artwork_files' => [],
            'collaborator_names' => [],
        ];
    
        // Collect unique artwork files
        foreach ($rows as $row) {
            if (!empty($row['artwork_file']) && !in_array($row['artwork_file'], $result['artwork_files'])) {
                $result['artwork_files'][] = $row['artwork_file'];
            }
        }
    
        // Collect unique collaborator names and format them (first name only)
        foreach ($rows as $row) {
            if (!empty($row['collaborator_name'])) {
                $fullName = $row['collaborator_name'];
                $firstName = explode(' ', trim($fullName))[0]; 
                if (!in_array($firstName, $result['collaborator_names'])) {
                    $result['collaborator_names'][] = $firstName;
                }
            }
        }
    
        return $result;
    }
    
    
    //
    public function myPendingExhibits($u_id) {
        $statement = $this->conn->prepare("
            SELECT * FROM exhibit_tbl 
            WHERE u_id = :u_id AND exbt_status = 'Pending'
        ");
        $statement->bindValue(':u_id', $u_id);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    //get artworks from exhibit
    public function getExhibitArtwork($exhibitId){
        $statement=$this->conn->prepare("SELECT * FROM exhibit_artworks");
        $statement->bindValue(1, $exhibitId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC); 
    }
    
    
    public function getRequestExhibit() {
        $statement = $this->conn->prepare("SELECT * FROM exhibit_tbl WHERE exbt_status = 'Pending'");
        $statement->execute();
        
        return $statement->fetchAll(PDO::FETCH_ASSOC); 
    }

    //pending exhibits
    public function getPendingExhibits() {
        $statement = $this->conn->prepare("
            SELECT 
                exhibit_tbl.exbt_id, 
                exhibit_tbl.exbt_title, 
                exhibit_tbl.exbt_descrip, 
                exhibit_tbl.exbt_date, 
                exhibit_tbl.exbt_type,
                accounts.u_name AS organizer_name, 
                art_info.title AS artwork_title, 
                art_info.description AS artwork_description, 
                art_info.file AS artwork_file, 
                art_info.u_id AS artist_id ,
                 collaborators.u_name AS collaborator_name
            FROM exhibit_tbl
            INNER JOIN accounts ON exhibit_tbl.u_id = accounts.u_id
            INNER JOIN exhibit_artworks ON exhibit_tbl.exbt_id = exhibit_artworks.exbt_id
            INNER JOIN art_info ON exhibit_artworks.a_id = art_info.a_id
             LEFT JOIN collab_exhibit ON exhibit_tbl.exbt_id = collab_exhibit.exbt_id  
            LEFT JOIN accounts AS collaborators ON collab_exhibit.u_id = collaborators.u_id  
            WHERE exhibit_tbl.exbt_status = 'Pending'
        ");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    //accept and decline fucntion
    public function updateExhibitStatus($exbt_id, $status) {
        if ($status !== 'Accepted' && $status !== 'Declined') {
            echo json_encode(["status" => "error", "message" => "Invalid status"]);
            exit;
        }
    
        if ($status === 'Accepted') {
            // Check if there's already an exhibit with status 'Accepted'
            $query = "SELECT * FROM exhibit_tbl WHERE exbt_status = 'Accepted' LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                echo json_encode(["status" => "error", "message" => "There is already an accepted exhibit. Please wait until it is marked as Done."]);
                exit;
            }
        }
    
        // Update exhibit status
        $statement = $this->conn->prepare("UPDATE exhibit_tbl SET exbt_status = ?, accepted_at = ? WHERE exbt_id = ?");
        
        $accepted_at = ($status === 'Accepted') ? date("Y-m-d H:i:s") : null;
        
        $statement->bindValue(1, $status, PDO::PARAM_STR);
        $statement->bindValue(2, $accepted_at, PDO::PARAM_STR); 
        $statement->bindValue(3, $exbt_id, PDO::PARAM_INT);
    
        if ($statement->execute()) {

            $message = "Your exhibit status is $status";
            $this->createNotification($exbt_id, $message);
    
            echo json_encode(["status" => "success", "message" => "Exhibit status updated to $status"]);
        } else {
            $errorInfo = $statement->errorInfo();
            echo json_encode(["status" => "error", "message" => "Failed to update status. Error: " . $errorInfo[2]]);
        }
        exit();
    }
    
    private function createNotification($exbt_id, $message) {
        $query = "SELECT u_id FROM exhibit_tbl WHERE exbt_id = :exbt_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':exbt_id', $exbt_id, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $exhibit = $stmt->fetch(PDO::FETCH_ASSOC);
            $u_id = $exhibit['u_id']; 
            
            $notificationQuery = "INSERT INTO notifications (u_id, exbt_id, message, is_read, created_at) 
                                  VALUES (:u_id, :exbt_id, :message, 0, NOW())";
            $notificationStmt = $this->conn->prepare($notificationQuery);
            $notificationStmt->bindParam(':u_id', $u_id, PDO::PARAM_INT);
            $notificationStmt->bindParam(':exbt_id', $exbt_id, PDO::PARAM_INT);
            $notificationStmt->bindParam(':message', $message, PDO::PARAM_STR);
            
            $notificationStmt->execute();
        }
    }
    
    
    
    public function autoMarkExhibitsAsDone() {
        $query = "UPDATE exhibit_tbl SET exbt_status = 'Done' 
                  WHERE exbt_status = 'Accepted' 
                  AND TIMESTAMPDIFF(HOUR, accepted_at, NOW()) >= 24";
        
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            echo "Exhibits marked as Done after 24 hours.";
        } else {
            $errorInfo = $stmt->errorInfo();
            echo "Failed to update exhibits. Error: " . $errorInfo[2];
        }
    }
    
    // get collab
    public function getCollab($exhibitId) {
        $statement = $this->conn->prepare("
            SELECT accounts.u_name 
            FROM collab_exhibit
            INNER JOIN accounts ON collab_exhibit.u_id = accounts.u_id
            WHERE collab_exhibit.exbt_id = ?
        ");
        $statement->bindValue(1, $exhibitId, PDO::PARAM_INT);
        $statement->execute();
        
        return $statement->fetchAll(PDO::FETCH_ASSOC); 
    }
    
  
 
//search collaborators
    public function searchCollaborators($query) {
        
        $response = [];
        if (!empty($query)) {
            $stmt = $this->conn->prepare("SELECT * FROM accounts WHERE u_name LIKE :query LIMIT 10");
            $stmt->execute(['query' => '%' . $query . '%']);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($results) {
                
                foreach ($results as $collaborator) {
                    $response[] = [
                        'name' => $collaborator['u_name'],
                        'u_id' => $collaborator['u_id'],
                    ];
                }
            } else {
              
                $response[] = ['name' => 'No collaborators found.'];
            }
        }
        return json_encode($response);
    }


        // check if nainfclue ba ang artwork sa exhibti para ni sa delete
        public function isArtworkInExhibit($artworkId) {
            $query = "SELECT * FROM exhibit_artworks WHERE a_id = :a_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':a_id', $artworkId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount() > 0; 
        }
        
        public function updateExhibit($exhibitId, $title, $description, $date) {
            $query = "UPDATE exhibit_tbl SET exbt_title = ?, exbt_descrip = ?, exbt_date = ? WHERE exbt_id = ?";
            $statement = $this->conn->prepare($query);
            $statement->bind_param("sssi", $title, $description, $date, $exhibitId);
    
            if ($statement->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public function addArtworkToExhibit($exbt_id, $a_id) {
            $checkCollabQuery = "SELECT * FROM `collab_exhibit` WHERE `exbt_id` = :exbt_id AND `u_id` = :u_id";
            $statement = $this->conn->prepare($checkCollabQuery);
            $statement->bindValue(':exbt_id', $exbt_id, PDO::PARAM_INT);
            $statement->bindValue(':u_id', $this->u_id, PDO::PARAM_INT);
            $statement->execute();
        
            if ($statement->rowCount() == 0) {
                return "You are not a collaborator for this exhibit.";
            }
        
            $insertQuery = "INSERT INTO `exhibit_artworks` (`exbt_id`, `a_id`) VALUES (:exbt_id, :a_id)";
            $statement = $this->conn->prepare($insertQuery);
            $statement->bindValue(':exbt_id', $exbt_id, PDO::PARAM_INT);
            $statement->bindValue(':a_id', $a_id, PDO::PARAM_INT);
        
            if ($statement->execute()) {
                return "Artwork added to exhibit successfully.";
            } else {
                $errorMessage = implode(", ", $statement->errorInfo());
                return "Error adding artwork to exhibit: $errorMessage";
            }
        }
        
        
        
    
}


?>