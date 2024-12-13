<?php
session_start();
include("include/connection.php");
include 'class/accclass.php'; 
include 'class/artClass.php'; 
include 'class/exhbtClass.php'; 

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login-register.php");
    die;
}


if (isset($_GET['exbt_id']) && isset($_SESSION['u_id'])) {
    $exbt_id = $_GET['exbt_id']; 
    $u_id = $_SESSION['u_id'];  

    
$exhibitManager = new artManager($conn);
$collabImages = $exhibitManager->getUserArtworks();
$includedArtworks = $exhibitManager->getCollabArtworks($exbt_id);

    $checkArtworkQuery = "SELECT COUNT(*) FROM `collab_exhibit` WHERE `exbt_id` = :exbt_id AND `u_id` = :u_id";
    $stmtArtwork = $conn->prepare($checkArtworkQuery);
    $stmtArtwork->bindValue(':exbt_id', $exbt_id, PDO::PARAM_INT);
    $stmtArtwork->bindValue(':u_id', $u_id, PDO::PARAM_INT);
    $stmtArtwork->execute();
    $artworkCount = $stmtArtwork->fetchColumn();

    $checkStatusQuery = "SELECT `exbt_status` FROM `exhibit_tbl` WHERE `exbt_id` = :exbt_id";
    $stmtStatus = $conn->prepare($checkStatusQuery);
    $stmtStatus->bindValue(':exbt_id', $exbt_id, PDO::PARAM_INT);
    $stmtStatus->execute();
    $status = $stmtStatus->fetchColumn();
    
    if ($artworkCount >= 5) {
        echo json_encode(['success' => false, 'message' => 'You cannot add more than 5 artworks to this exhibit.']);
        exit;
    }
    if (isset($_POST['selected_artworks_collab'])) {
        $selectedArtworks = json_decode($_POST['selected_artworks_collab'], true);

        if (empty($selectedArtworks)) {
            echo json_encode(['success' => false, 'message' => 'No artworks selected.']);
        } else {
            $exhibitManager = new ExhibitManager($conn);
            $successCount = 0;
            $errorMessages = [];

            foreach ($selectedArtworks as $a_id) {
                $result = $exhibitManager->addArtworkToExhibit($exbt_id, $a_id);
                if (strpos($result, "successfully") !== false) {
                    $successCount++;
                } else {
                    $errorMessages[] = $result;
                }
            }

            $finalMessage = '';
            if ($successCount > 0) {
                $finalMessage .= "$successCount artwork(s) added to exhibit successfully.";
            }
            if (!empty($errorMessages)) {
                $finalMessage .= " " . implode(' ', $errorMessages);
            }

            echo json_encode([
                'success' => true,
                'message' => $finalMessage,
            ]);
        }
        exit;
    }
} else {
    echo 'Exhibit ID or user not found.';
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="shortcut icon" href="gallery/image/vags-logo.png" type="image/x-icon">
    <title>Collaborative Artwork</title>
</head>
<body style="background-color: white;">
    <header class="head-collab">
        <h3>Be a Collaborator</h3>
    </header>

    <main>
        <div id="custom-alert" class="accepted-alert-container" style="display: none;">
            <div class="accepted-alert-box">
                <span id="alert-message"></span>
                <button id="close-alert" class="accepted-close-btn">OK</button>
            </div>
        </div>

        <?php if (isset($status) && $status == 'Accepted'||'Ongoing'): ?>
            <p class="displayAlertCollab">You already have an upcoming/ongoing exhibit.</p><br>

            <div class="selectart-collab">
            <h5>Your Exhibit Artworks</h5>
                <div class="includeArt-collab">
                    <?php if (!empty($includedArtworks )): ?>
                        <?php foreach ($includedArtworks as $image): ?>
                            <div class="image-itemColab">
                                <img class="imgCollab" 
                                     src="<?php echo htmlspecialchars($image['file'], ENT_QUOTES); ?>" 
                                     alt="Collaborative Artwork" 
                                     data-id="<?php echo htmlspecialchars($image['a_id'], ENT_QUOTES); ?>">
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No collaborative artworks available.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <form id="submitArtCollab">
                <input type="hidden" id="selectedArtworksCollab" name="selected_artworks_collab" value="[]">
                <div class="saveCollabArt">
                    <button type="submit">Submit Artworks</button>
                </div>
            </form>

            <div class="selectart-collab">
                <h3>Select Artworks (Maximum of 5)</h3>
                <div class="includeArt-collab">
                    <?php if (!empty($collabImages)): ?>
                        <?php foreach ($collabImages as $image): ?>
                            <div class="image-itemColab">
                                <img class="imgCollab" 
                                     src="<?php echo htmlspecialchars($image['file'], ENT_QUOTES); ?>" 
                                     alt="Collaborative Artwork" 
                                     data-id="<?php echo htmlspecialchars($image['a_id'], ENT_QUOTES); ?>">
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No collaborative artworks available.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <script>
       document.addEventListener("DOMContentLoaded", function () {
    const maxSelection = 5;
    const selectedArtworks = new Set();
    const alertContainer = document.getElementById('custom-alert');
    const alertMessage = document.getElementById('alert-message');
    const closeButton = document.getElementById('close-alert');

    const exhibitStatus = "<?php echo $status; ?>";  

    if (exhibitStatus === 'Approved') {
        showAlert('You cannot add artwork because the exhibit is ongoing.');
        return;
    }

    document.querySelectorAll('.imgCollab').forEach(img => {
        img.addEventListener('click', function () {
            const artworkId = img.dataset.id;

            if (selectedArtworks.has(artworkId)) {
                selectedArtworks.delete(artworkId);
                img.classList.remove('selected');
            }
            else if (selectedArtworks.size < maxSelection) {
                selectedArtworks.add(artworkId);
                img.classList.add('selected');
            } else {
                showAlert('You can only select up to 5 artworks.');
            }
            document.getElementById('selectedArtworksCollab').value = JSON.stringify([...selectedArtworks]);
        });
    });

    document.getElementById('submitArtCollab').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch("", {
            method: "POST",
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            showAlert(data.message);
            if (data.success) {
                setTimeout(() => {
                    location.reload();
                }, 1500);
            }
        })
        .catch(error => {
            showAlert('Failed to submit artworks. Please try again.');
            console.error(error);
        });
    });

    function showAlert(message) {
        alertMessage.textContent = message;
        alertContainer.style.display = 'flex';
        closeButton.onclick = () => alertContainer.style.display = 'none';
    }
});

    </script>
</body>
</html>

