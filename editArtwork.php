<?php
session_start();
include("include/connection.php");
include 'class/accClass.php';  
include 'class/artClass.php'; 
include 'class/exhbtClass.php';

if (isset($_GET['a_id']) && filter_var($_GET['a_id'])) {
    $artworkId = $_GET['a_id'];
} else {
    header("Location: error.php?error=invalid_id");
    exit();
}

$artManager = new artManager($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['deleteArtwork'])) {
        if ($artManager->deleteArtwork($artworkId)) {
            header("Location: dashboard.php?message=Artwork deleted successfully");
            exit();
        } else {
            echo "<p>Error: Could not delete artwork.</p>";
        }
    } 
   
    elseif (isset($_POST['uploadArt'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $category = $_POST['category'];

        if ($artManager->updateArtwork($artworkId, $title, $description, $category)) {
            header("Location: dashboard.php?message=Artwork updated successfully");
            exit();
        } else {
            echo "<p>Error: Could not update artwork details.</p>";
        }
    }
}
$artworkDetails = $artManager->getArtworkById($artworkId); 

$title = ($artworkDetails['title']);
$description = ($artworkDetails['description']);
$category = ($artworkDetails['category']);
$imageSrc = ($artworkDetails['file']);

$exhibitManager = new ExhibitManager($conn);
$isPartOfExhibit = $exhibitManager->isArtworkInExhibit($artworkId); 
$canDelete = !$isPartOfExhibit;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="gallery/image/vags-logo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <title>Edit Artwork Details</title>
   
</head>
<body style="background-color: white;">

<header class="head-edit">
        <div class="return">
             <p class="return" onclick="returnArt()"><</p>
        </div>

        <div class="display-header">
            <h4>Change Artwork Details</h2>
            <div id="date-time-display"></div>
        </div>
 
</header>

    <div class="artwork-upload">
    <form action="" method="POST" name="uploadArt" enctype="multipart/form-data">
        <input type="hidden" name="a_id" value="<?php echo $artworkId; ?>"> 
        
        <label for="title"><b>Title</b></label><br>
        <input type="text" name="title" id="title" class="title" value="<?php echo $title; ?>" placeholder="Add a Title" required><br>

        <label for="description-of-artwork"><b>Description</b></label><br>
        <textarea name="description" id="description" placeholder="Add a Description" required><?php echo $description; ?></textarea><br>

        <label for="category"><b>Category</b></label><br>
        <select name="category" id="category">
            <option value="Sculpture" <?php echo ($category == 'Sculpture') ? 'selected' : ''; ?>>Sculpture</option>
            <option value="Painting" <?php echo ($category == 'Painting') ? 'selected' : ''; ?>>Painting</option>
            <option value="Sketches" <?php echo ($category == 'Sketches') ? 'selected' : ''; ?>>Sketches</option>
            <option value="Expressionism" <?php echo ($category == 'Expressionism') ? 'selected' : ''; ?>>Expressionism</option>
        </select><br><br>

        <div class="image-upload">
            <div class="image-display">
                <img id="uploadedImage" src="<?php echo $imageSrc; ?>" alt="Uploaded Image" class="visible"> 
            </div>    
        </div> 
        <button type="submit" name="uploadArt">Save Changes</button><br>
        <?php if (!$isPartOfExhibit): ?>
            <button type="submit" name="deleteArtwork" class="delete-artwork">Delete Artwork</button>
        <?php else: ?>
            <button type="button" class="delete-artwork" disabled>Cannot Delete Artwork. Check Exhibits</button>
        <?php endif; ?>


    </form>
    </div>

    <script>
     document.addEventListener('DOMContentLoaded', function () {
        console.log("JavaScript loaded and ready");

        document.querySelector('.delete-artwork').addEventListener('click', function(event) {
            console.log("Delete button clicked");
            var isPartOfExhibit = <?php echo json_encode($isPartOfExhibit); ?>; 

            if (isPartOfExhibit) {
                event.preventDefault(); 
                var confirmation = confirm("This artwork cannot be deleted because it is part of an exhibit.");
                if (confirmation) {
                    window.location.href = 'editArtwork.php';
                }
            } else {
                if (confirm("Are you sure you want to delete this artwork?")) {
                    document.forms['uploadArt'].submit(); 
                }
            }
        });
    });
        function returnArt() {
        window.location.href = 'dashboard.php';
    }

    // live date and time 
    function updateDateTime() {

    const dateTimeDisplay = document.getElementById("date-time-display");
    const now = new Date(); 

            //  date formatting
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        const date = now.toLocaleDateString('en-US', options);
        const time = now.toLocaleTimeString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true }); 

            dateTimeDisplay.textContent = `${date} | ${time}`; 
        }

        updateDateTime();
        setInterval(updateDateTime, 60000); 

     


    </script>
</body>
</html>
