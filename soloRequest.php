<?php
session_start();
include("include/connection.php");
include 'class/accclass.php'; 
include 'class/artClass.php'; 
include 'class/exhbtClass.php'; 

$u_id = $_SESSION['u_id']; 
$exhibitManager = new ExhibitManager($conn);
$pendingExhibits = $exhibitManager->myPendingExhibits($u_id);
$pending = $exhibitManager->getPendingExhibits($u_id);
$updateSuccess = false;
$message = '';

if (isset($_POST['updateRequest'])) {
    $exhibit_title = htmlspecialchars($_POST['exhibit-title']);
    $exhibit_description = htmlspecialchars($_POST['exhibit-description']);
    $exhibit_date = $_POST['exhibit-date'];

 
    $exbt_id = $pending[0]['exbt_id'];
    $current_title = $pending[0]['exbt_title'];
    $current_description = $pending[0]['exbt_descrip'];
    $current_date = $pending[0]['exbt_date'];


    if ($exhibit_title === $current_title && $exhibit_description === $current_description && $exhibit_date === $current_date) {
        $message = 'No changes were made.';
    } else {
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
                $message = 'Update successful!';
                $updateSuccess = true;
            } else {
                $message = 'Error: Could not update exhibit.';
            }
        } catch (PDOException $e) {
            $message = 'Error: ' . $e->getMessage();
        }
    }
  
    echo json_encode(['message' => $message, 'updateSuccess' => $updateSuccess]);
    exit();
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

   <!-- Updated Modal for Exhibit -->
<div id="updateModal" class="modal <?php echo $updateSuccess ? 'show' : ''; ?>" style="display:<?php echo $updateSuccess ? 'block' : 'none'; ?>;">
    <div class="modal-content" style="background-color: white; color: black;">
        <span id="updateCloseBtn" class="close" style="position:relative; left:20px; color: red;"></span>
        <h3>Exhibit Update</h3>
        <p><?php echo $message; ?></p> 
    </div>
</div>


    <div id="reqExhibit-con" class="reqExhibit-con">
        <div class="top-req">
            <a style="text-decoration: none; color:black; font-weight:bold; font-size:25px;" href="dashboard.php">
                &lt; 
            </a> &nbsp;&nbsp;&nbsp;<h3>Pending Exhibit</h3>
        </div>

        <div class="tabs">
            <h4 class="tab collaborative active">Solo</h4>
        </div>

        <div id="artworkValidationModal" class="artwork-modal">
            <div class="artwork-modal-content">
                <span class="artwork-close">&times;</span>
                <h3>Validation Error</h3>
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
                        <input type="text" class="exhibit-title-display" name="exhibit-title" placeholder="Enter the title of your exhibit" value="<?php echo htmlspecialchars($pending[0]['exbt_title']); ?>" required><br>

                        <label for="exhibit-description">Exhibit Description</label><br>
                        <textarea name="exhibit-description" class="exhibit-description-display" id="exhibit-description" placeholder="Describe the theme or story behind your exhibit" required><?php echo htmlspecialchars($pending[0]['exbt_descrip']); ?></textarea><br>

                        <label for="exhibit-date">Exhibit Date</label><br>
                        <input type="date" id="exhibit-date" class="exhibit-date-display" name="exhibit-date" value="<?php echo htmlspecialchars($pending[0]['exbt_date']); ?>" required><br>

                        <input type="hidden" name="selected_artworks" id="selectedArtworks" value="">

                        <div class="update-actions">
                            <button type="submit" class="update-btn" id="update-btn" name="updateRequest">Save Changes</button>
                            <button type="button" class="cancel-btn" id="cancel-btn" name="cancelRequest">Cancel Request</button>
                        </div>
                    </form>

                    <div class="image-exhibit">
                        <img src="gallery/image/solo-image.png" alt="Painting Graphics">
                    </div>
                </div>

                <div class="select-art">
                    <p>Selected Artworks</p>
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
            </div>
        <?php endif; ?>
    </div>

    <script src="js/dashboard.js"></script>

    <script>
     document.getElementById("updateCloseBtn").onclick = function() {
    document.getElementById("updateModal").style.display = "none";
};

window.onclick = function(event) {
    if (event.target == document.getElementById("updateModal")) {
        document.getElementById("updateModal").style.display = "none";
    }
};

document.getElementById("soloExhibitForm").addEventListener("submit", function(event) {
    event.preventDefault(); 

    const formData = new FormData(this);
    formData.append("updateRequest", "true");

    fetch("", {
        method: "POST",
        body: formData
    })
    .then(response => response.json()) 
    .then(data => {
        document.getElementById("updateModal").style.display = "block";
        
    
        const message = data.message;
        document.querySelector("#updateModal .modal-content p").innerText = message;

        
        const exhibitTitle = document.querySelector("input[name='exhibit-title']").value;
        const exhibitDescription = document.querySelector("textarea[name='exhibit-description']").value;
        const exhibitDate = document.querySelector("input[name='exhibit-date']").value;

        document.querySelector(".exhibit-title-display").innerText = exhibitTitle;
        document.querySelector(".exhibit-description-display").innerText = exhibitDescription;
        document.querySelector(".exhibit-date-display").innerText = exhibitDate;
    })
    .catch(error => {
        console.error("Error updating exhibit:", error);
        alert("An error occurred while updating the exhibit.");
    });
});


document.getElementById("cancel-btn").addEventListener("click", function() {
    console.log("Cancel request clicked");
    document.getElementById("cancelConfirmationModal").style.display = "block";
});


        document.getElementById("confirmCancel").addEventListener("click", function() {
    const formData = new FormData();
    formData.append("cancelRequest", "true");

    fetch("", {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = 'dashboard.php';
        } else {
            alert(data.error);
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("An error occurred while canceling the request.");
    });
});


        document.getElementById("closeCancel").addEventListener("click", function() {
            document.getElementById("cancelConfirmationModal").style.display = "none";
        });
    </script>
</body>
</html>
