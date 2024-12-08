<?php
session_start();
include("../include/connection.php");
include '../class/accclass.php'; 
include '../class/artClass.php'; 
include '../class/exhbtClass.php'; 

$u_id = $_SESSION['u_id']; 
$exhibit = new ExhibitManager($conn);
$pendingExhibits = $exhibit->myPendingExhibits($u_id);
$pending = $exhibit->getPendingExhibits($u_id);
$response = [];

if (isset($_POST['updateRequest'])) {
    $exhibit_title = htmlspecialchars($_POST['exhibit-title']);
    $exhibit_description = htmlspecialchars($_POST['exhibit-description']);
    $exhibit_date = $_POST['exhibit-date'];
    $exbt_id = $pending[0]['exbt_id'];

    try {
        $query = "UPDATE exhibit_tbl SET 
                    exbt_title = :exbt_title, 
                    exbt_descrip = :exbt_description, 
                    exbt_date = :exbt_date
                  WHERE exbt_id = :exbt_id AND u_id = :u_id";

        $stmt = $conn->prepare($query);
        $stmt->bindValue(':exbt_title', $exhibit_title, PDO::PARAM_STR);
        $stmt->bindValue(':exbt_description', $exhibit_description, PDO::PARAM_STR);
        $stmt->bindValue(':exbt_date', $exhibit_date, PDO::PARAM_STR);
        $stmt->bindValue(':exbt_id', $exbt_id, PDO::PARAM_INT);
        $stmt->bindValue(':u_id', $u_id, PDO::PARAM_INT);

        // If the update is successful, reload the page
        if ($stmt->execute()) {
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "Error: Could not update exhibit.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if (isset($_POST['cancelRequest'])) {
    $exbt_id = $pending[0]['exbt_id']; 
    
    try {
        $query = "UPDATE exhibit_tbl SET exbt_status = 'Cancelled' WHERE exbt_id = :exbt_id AND u_id = :u_id";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':exbt_id', $exbt_id, PDO::PARAM_INT);
        $stmt->bindValue(':u_id', $u_id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Could not cancel the request.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/gallery/image/vags-logo.png" type="image/x-icon">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <title>Pending Exhibit</title>
</head>
<body>
    <section class="container">
        <!-- Cancel Confirmation Modal -->
<div id="cancelConfirmationModal" class="modal">
    <div class="modal-content">
        <p>Are you sure you want to cancel the request?</p>
        <button id="confirmCancel" class="confirm-btn">Yes</button>
        <button id="closeCancel" class="close-btn">No</button>
    </div>
</div>

<!-- Custom Alert Box -->
<div id="customAlert" class="alert-box">
    <div class="alert-content">
        <span id="alertMessage"></span>
        <button id="alertClose" class="alert-close-btn">Close</button>
    </div>
</div>


        <div class="header">
        <a style="text-decoration: none;color:black; font-weight:bold; font-size:25px;" href="/dashboard.php"><</a>
            <span class="title">Pending Exhibit</span>
        </div>
        <div class="tabs">
            <h4 class="tab collaborative active">Collaborative</h4>
        </div>
        <div class="wrapper">
    
        <form id="updateExhibitForm" action="" name="updateCollab" method="POST">
    <div class="form">
        <div class="form-group">
            <label for="exhibit-title">Exhibit Title</label>
            <div class="input-field">
                <i class='bx bxs-pencil'></i>
                <input type="text" id="exhibit-title" name="exhibit-title" placeholder="Enter the title of your exhibit" value="<?php echo htmlspecialchars($pending[0]['exbt_title']); ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label for="exhibit-description">Exhibit Description</label>
            <div class="input-field1">
                <i class='bx bxs-pencil'></i>
                <textarea id="exhibit-description" name="exhibit-description" placeholder="Describe the theme or story behind your exhibit" required><?php echo htmlspecialchars($pending[0]['exbt_descrip']); ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="exhibit-date">Exhibit Date</label>
            <div class="input-field">
                <i class='bx bxs-pencil'></i>
                <div class="date-picker">
                    <input type="date" id="exhibit-date" name="exhibit-date" value="<?php echo htmlspecialchars($pending[0]['exbt_date']); ?>" required>
                </div>
            </div>
        </div>

        <div class="update-actions">
            <button type="submit" class="update-btn" id="update-btn" name="updateRequest">Save Changes</button>
            <button type="button" class="cancel-btn" id="cancel-btn" name="cancelRequest">Cancel Request</button>
        </div>
        <img src="pics/graphic.png" class="graphic">
    </div>
</form>


            <div class="artworks">
            <div class="admin">
    <h4>Your Artworks</h4>
<div class="admin-card">
    <div class="art-collage">
        <div class="artworks">
            <?php if (isset($pending[0])): ?>
                <img src="/<?php echo htmlspecialchars($pending[0]['artwork_file'], ENT_QUOTES); ?>" class="art1">
            <?php else: ?>
                <img src="/pics/a1.jpg" class="art1">
            <?php endif; ?>

            <?php if (isset($pending[1])): ?>
                <img src="/<?php echo htmlspecialchars($pending[1]['artwork_file'], ENT_QUOTES); ?>" class="art2">
            <?php else: ?>
                <img src="/pics/a3.jpg" class="art2">
            <?php endif; ?>
        </div>
        <div class="artwork">
            <?php if (isset($pending[2])): ?>
                <img src="/<?php echo htmlspecialchars($pending[2]['artwork_file'], ENT_QUOTES); ?>" alt="<?php echo htmlspecialchars($pending[2]['artwork_title'], ENT_QUOTES); ?>">
            <?php else: ?>
                <img src="/pics/a2.jpg" alt="Art 3">
            <?php endif; ?>
        </div>
    </div>
</div>

</div>


                <div class="collaborators">
        <h2>Collaborators</h2>
        <div class="collaborator-cards" id="collaborators-cards">
        
        <?php 
        $collaborators = [];
        foreach ($pending as $exhibit) {
            if (!empty($exhibit['collaborator_name'])) {
                $collaborators[] = $exhibit['collaborator_name'];
            }
        }
        $collaborators = array_unique($collaborators);
        foreach ($collaborators as $collaborator) {
            
            $firstName = explode(' ', $collaborator)[0];
            
            echo "<div class='collab-details'>";
            echo "<p class='collab-name1' id='collab_name'>" . htmlspecialchars($firstName) . "</p>";
            
            echo "<div class='collaborator'>
                    <div class='art-collage'>
                        <div class='c-artworks'>
                            <img src='pics/a1.jpg' alt='Art 1'>
                            <img src='pics/a3.jpg' alt='Art 2'>
                        </div>
                        <div class='c-artwork'>
                            <img src='pics/a2.jpg' alt='Art 3'>
                        </div>
                    </div>
                  </div>";
            echo "</div>";
        }
    ?>            
        
        </div>
    </div>


            </div>

            <!-- Modal -->
            <div class="modal" id="image-modal">
                <button class="nav-btn left-btn">&lt;</button>
                <button class="nav-btn right-btn">&gt;</button>
                <div class="modal-content">
                    <img src="" class="modal-image">
                    <div class="replace-container">
                        <div class="replace-text">Replace</div>
                        <input type="file" id="replace-input" accept="image/*" style="display: none;">
                    </div>
                </div>
            </div>
            
            <div class="footer">
                <p>Wait for the organizer to approve your exhibit</p>
            </div>
        </div>
    </section>
    <script src="script.js"></script>

</body>
</html>