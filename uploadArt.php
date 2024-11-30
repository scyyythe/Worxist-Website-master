<?php
session_start();
include("include/connection.php");
include 'class/accClass.php'; 

if (isset($_POST['uploadArt']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $uploader = new ArtUploader($conn);
    $uploader->uploadArtwork($_FILES['file'], $_POST['title'], $_POST['description'], $_POST['category']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="gallery/image/vags-logo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style2.css">
    <title>Upload Artwork</title>
</head>
<body>
    <header>
        <div class="return">
             <p class="return" onclick="returnArt()"><</p>
        </div>

        <div class="display-header">
            <h4>Post Artwork</h2>
            <div id="date-time-display"></div>
        </div>
        
       
 
    </header>


    <div class="container">  
        <!-- Validation Modal -->
<div id="validationModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <p>Please fill in all the fields before submitting!</p>
    </div>
</div>

    <!-- input artwork details -->
    <div class="artwork-upload">
        <form action="" method="POST" name="uploadArt" enctype="multipart/form-data">
           
            <label for="title"><b>Title</b></label><br>
            <input type="text" name="title" id="title" class="title" placeholder="Add a Title"><br>

            <label for="description-of-artwork"><b>Description</b></label><br>
            <textarea name="description" id="description" placeholder="Add a Description"></textarea><br>

            
            <label for="title"><b>Category</b></label><br>
            <select name="category" id="category">
            <option value="Sketches">Sketches</option>
        <option value="Sculpture">Sculpture</option>
        <option value="Painting">Painting</option>
        <option value="Abstract">Abstract</option>
        <option value="Landscape">Landscape</option>
        <option value="Portrait">Portrait</option>
        <option value="Figurative">Figurative</option>
        <option value="Expressionism">Expressionism</option>
        <option value="Photography">Photography</option>
        <option value="Digital Art">Digital Art</option>
        <option value="Conceptual Art">Conceptual Art</option>
        <option value="Pop Art">Pop Art</option>
        <option value="Minimalism">Minimalism</option>
        <option value="Street Art">Street Art</option>
        <option value="Fantasy">Fantasy</option>
        <option value="Crafts">Crafts</option>
        <option value="Nature">Nature</option>
        <option value="Architecture">Architecture</option>
        <option value="Historical">Historical</option>
        <option value="Political Art">Political Art</option>
        <option value="Cultural Art">Cultural Art</option>
        <option value="Installation Art">Installation Art</option>
        <option value="Performance Art">Performance Art</option>
        <option value="Renaissance">Renaissance</option>
        <option value="Baroque">Baroque</option>
        <option value="Gothic Art">Gothic Art</option>
        <option value="Contemporary Art">Contemporary Art</option>
            </select>
            <br><br>

            <div class="image-upload">
                
                <div class="image-display">
                    <img id="uploadedImage" src="" alt="Uploaded Image" class="hidden">
                   
                </div>    
                <label class="custom-file-upload">
                    <input type="file" name="file" class="choose" accept="image/*">
                    Choose a file
                </label>
                
            </div> 
            <button name="uploadArt">Upload Artwork</button>
        </form>
    </div>
    
    <!-- display image -->
 
        
    </div>

    <script>

        // Show modal
function showModal() {
    const modal = document.getElementById('validationModal');
    modal.style.display = 'block';
}

// Close modal
function closeModal() {
    const modal = document.getElementById('validationModal');
    modal.style.display = 'none';
}


document.querySelector('form[name="uploadArt"]').addEventListener('submit', function(event) {
    const title = document.getElementById('title').value.trim();
    const description = document.getElementById('description').value.trim();
    const category = document.getElementById('category').value;
    const file = document.querySelector('input[type="file"]').files[0];

    
    if (!title || !description || !category || !file) {
        event.preventDefault();  
        showModal();  
    }
});

        function returnArt() {
    window.location.href = 'dashboard.php';
    }

    // display chosen image/file
document.querySelector('.choose').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const imageDisplay = document.getElementById('uploadedImage');

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            imageDisplay.src = e.target.result; 
            imageDisplay.classList.remove('hidden'); 
            setTimeout(() => {
                imageDisplay.classList.add('show'); 
            }, 100); 
        }

        reader.readAsDataURL(file); 
    }
});

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