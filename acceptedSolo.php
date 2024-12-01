<?php
session_start();
include("include/connection.php");
include 'class/accclass.php'; 
include 'class/artClass.php'; 
include 'class/exhbtClass.php'; 

$u_id = $_SESSION['u_id']; 
$exhibitManager = new ExhibitManager($conn);
$pendingExhibits = $exhibitManager->myAcceptedExhibits($u_id);
$pending = $exhibitManager->acceptedExhibits();
$updateSuccess = false;

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

        if ($stmt->execute()) {
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "Error: Could not update exhibit.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if (isset($_POST['cancelRequest']) && $_POST['cancelRequest'] === 'true') {
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
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="organizer/org.css">
    <link rel="shortcut icon" href="gallery/image/vags-logo.png" type="image/x-icon">
    <title>Pending Exhibits</title>
</head>
<body style="background-color: white;">
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

        <!-- Solo Exhibit Request -->
        <div id="reqExhibit-con" class="reqExhibit-con">
            <div class="top-req">
            <a style=" text-decoration: none; color:black; font-weight:bold; font-size:25px;" href="dashboard.php">
    <
</a>            &nbsp;&nbsp;&nbsp;<h3>Your Upcoming Exhibit</h3>
                
            </div>
            <div class="tabs">
            <h4   class="tab collaborative active">Solo</h4>
        </div>

            <div id="artworkValidationModal" class="artwork-modal">
                <div class="artwork-modal-content">
                    <span class="artwork-close">&times;</span>
                    <h3>Validation Errror</h3>
                    <p>Please select at least one artwork to schedule the exhibit.</p>
                </div>
            </div>
            <?php if (empty($pending)): ?>
                    <p>You don't have pending exhibits.</p>
                <?php else: ?>     
            <div id="Solo" class="requestTab">
    <div class="exhibit-inputs">
            <form action="" name="soloExhibit" method="POST" id="soloExhibitForm">
                    <label for="exhibit-title">Exhibit Title</label><br>
                    <input type="text" name="exhibit-title" placeholder="Enter the title of your exhibit" value="<?php echo htmlspecialchars($pending[0]['exbt_title']); ?>" required disabled><br>

                    <label for="exhibit-description">Exhibit Description</label><br>
                    <textarea name="exhibit-description" id="exhibit-description" placeholder="Describe the theme or story behind your exhibit" required disabled><?php echo htmlspecialchars($pending[0]['exbt_descrip']); ?></textarea><br>

                    <label for="exhibit-date">Exhibit Date</label><br>
                    <input type="date" id="exhibit-date" name="exhibit-date" value="<?php echo htmlspecialchars($pending[0]['exbt_date']); ?>" required disabled><br>

                    <input type="hidden" name="selected_artworks" id="selectedArtworks" value="">

                    <div class="update-actions">
                        <button type="button" class="cancel-btn" id="cancel-btn" name="cancelRequest">Cancel Request</button>
                    </div>
                </form>

        <div class="image-exhibit">
            <img src="gallery/image/solo-image.png" alt="Painting Graphics">
        </div>



    </div>

    <div class="select-art">
    <p>Selected Artworks </p>
    <div class="display-creations">
        <?php if (!empty($pending)): ?>
            <?php foreach ($pending as $image): ?>
                <div class="image-item">
                    <img style="width:300px;" src="<?php echo ($image['artwork_file']); ?>" alt="Uploaded Artwork">
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>You don't have any uploaded artworks.</p>
        <?php endif; ?>
    </div>
</div>



<?php endif; ?>
</div>


        </div>
<script src="js/dashboard.js"></script>

<script>
    
document.getElementById("cancel-btn").addEventListener("click", function() {
  document.getElementById("cancelConfirmationModal").style.display = "flex";
});
document.getElementById("closeCancel").addEventListener("click", function() {
  document.getElementById("cancelConfirmationModal").style.display = "none";
});

document.getElementById("confirmCancel").addEventListener("click", function() {
  document.getElementById("cancelConfirmationModal").style.display = "none";
  
  let formData = new FormData();
  formData.append('cancelRequest', 'true'); 

  fetch(window.location.href, {
      method: "POST",
      body: formData
  })
  .then(response => response.json())
  .then(data => {
      if (data.success) {
          document.getElementById("alertMessage").textContent = "Exhibit request cancelled successfully.";
          document.getElementById("customAlert").style.display = "block";
           document.getElementById("customAlert").style.display = "none";
        window.location.href = "dashboard.php"; 
      } else {
          document.getElementById("alertMessage").textContent = "Error: " + data.error;
          document.getElementById("customAlert").style.display = "block";
      }
  })
  .catch(error => {
      document.getElementById("alertMessage").textContent = "An error occurred: " + error;
      document.getElementById("customAlert").style.display = "block";
  });
});

</script>
</body>
</html>