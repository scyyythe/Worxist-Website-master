<?php
session_start();

include("include/connection.php");
include 'class/accclass.php'; 
include 'class/artClass.php'; 
include 'class/exhbtClass.php'; 
include 'class/interactClass.php'; 

// Enable error reporting (for debugging)
ini_set('display_errors', 1);
error_reporting(E_ALL);


if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login-register.php");
    die;
}

$username = $_SESSION['username'];
$email = $_SESSION['email'];
$name = isset($_SESSION['name']) ? $_SESSION['name'] : 'User'; 
$u_id = $_SESSION['u_id']; 
$title = isset($_SESSION['title']) ? $_SESSION['title'] : 'Default Title';

$accountManager = new AccountManager($conn);
$userInfo = $accountManager->getAccountInfo($u_id);
$imagePath = $accountManager->getProfilePicture(); 

if (isset($_POST['uploadProfilePic'])) {
    $accountManager->uploadProfilePicture($_FILES['profilePicture']);
}
if (isset($_POST['removeProfilePic'])) {
    $accountManager->removeProfilePicture();
}

$exhibitManager = new artManager($conn);
$images = $exhibitManager->getUserArtworks();
$allImages = $exhibitManager->getAllArtworks();
$pendingArtworks = $exhibitManager->getPendingArtworks();

$exhibitManager = new ExhibitManager($conn);
$exhibit = $exhibitManager->getAcceptedExhibits();
$collaborators = $exhibitManager->fetchCollaboratorsWithArtworks();
$notifications = $exhibitManager->getNotifications($u_id);

$artInteract = new artInteraction($conn);
$artSaved = $artInteract->getSavedArtworks($u_id);
$artFave = $artInteract->getFavoriteArtworks($u_id);

// Exhibit Requests
if (isset($_POST['requestSolo'])) {
    $exhibit_title = $_POST['exhibit-title'];
    $exhibit_description = $_POST['exhibit-description'];
    $exhibit_date = $_POST['exhibit-date'];
    $selected_artworks = $_POST['selected_artworks']; 
    $exhibitManager->requestSoloExhibit($exhibit_title, $exhibit_description, $exhibit_date, $selected_artworks);
}

if (isset($_POST['requestCollab'])) {
    $exbt_title = $_POST['exhibit-title'];
    $exbt_descrip = $_POST['exhibit-description'];
    $exbt_date = $_POST['exhibit-date'];
    $selected_artworks = $_POST['selected_artworks_collab']; 
    $selected_collaborators = $_POST['selected_collaborators']; 
    $exhibitManager->requestCollabExhibit($exbt_title, $exbt_descrip, $exbt_date, $selected_artworks, $selected_collaborators);
}

// search Collaborators
if (isset($_GET['query']) && !empty($_GET['query'])) { 
    echo $exhibitManager->searchCollaborators($_GET['query']);
    exit; 
}

// Pending Exhibit Requests
$query = "SELECT * FROM exhibit_tbl WHERE u_id = :u_id AND exbt_status = 'Pending'";
$statement = $conn->prepare($query);
$statement->bindParam(':u_id', $u_id, PDO::PARAM_INT);
$statement->execute();
$pendingRequest = $statement->fetch(PDO::FETCH_ASSOC);

// if Already Scheduled an Exhibit
$query = $conn->prepare("SELECT exbt_status FROM exhibit_tbl WHERE u_id = :u_id AND exbt_status = 'Pending'");
$query->execute(['u_id' => $u_id]);
$pendingExhibit = $query->fetch(PDO::FETCH_ASSOC);
$hasPendingExhibit = $pendingExhibit ? true : false;
   
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="shortcut icon" href="gallery/image/vags-logo.png" type="image/x-icon">
     
    <title>Worxist</title>
    
</head>
<body>
   <nav class="sidebar close " id="sidebar">
        <header>
            <div class="image-text" >
                <span class="image" onclick="toggleSidebar()">
                <img src="gallery/image/white logo.png" alt="Logo" >
                    <div class="text header-text">
                    <span class="nameLogo">
                        Worxist
                    </span>        
                </div>
                </span>
                
                
            </div>
           
        </header>
      
        <div class="menu-bar">
            <div class="menu">
                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="" class="dashboard">
                            <i class='bx bxs-dashboard'></i>
                            <span class="text nav-text">
                                Dashboard
                            </span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="" class="my-artworks">
                            <i class='bx bxs-palette'></i>
                            <span class="text nav-text">
                               My Artworks
                            </span>
                        </a>
                    </li>

                    <li class="nav-link">
                    <a href="" class="messages">
                        <i class='bx bxs-chat'></i>
                        <span class="text nav-text">
                          Messages
                        </span>
                    </a>
                </li>


            <li class="nav-link">
                <a href="" class="exhibit">
                <i class='bx bx-image-alt'></i>
                    <span class="text nav-text">
                      Exhibits
                    </span>
                </a>
            </li>

            <li class="nav-link">
                <a href="" class="settings">
                    <i class='bx bxs-cog'></i>
                    <span class="text nav-text">
                      Settings
                    </span>
                </a>
            </li>
            
                </ul>
            </div>

            <div class="bottom-content">
    <li class="nav-link">
        <a href="#" id="logoutButton" class="logoutButton">
            <i class='bx bx-log-out'></i>
            <span class="text nav-text">Sign Out</span>
        </a>
    </li>
</div>
        </div>   
   </nav>
<!-- end of sidebar -->

   <div class="wrapper">

   <div id="logoutModal" class="logoutModal">
    <div class="logoutModal-content">
        <p>Are you sure you want to sign out?</p>
        <div class="logoutModal-buttons">
            <a href="./logout.php" class="logoutModal-confirm">Yes</a>
            <button id="logoutModalCancel" class="logoutModal-cancel">Cancel</button>
        </div>
    </div>
</div>
 <!-- Pop-up -->
 <div class="popup" id="popup">
    <div class="box-pop">
   
        <img src="" alt="" class="popup-image">
    </div>

    <div class="social-interact-icons">
    <i class='bx bxs-heart like-icon' id="like-icon" onclick="toggleLike(this)"></i>
    <p class="noHeart"></p> 

    <i class='bx bxs-bookmark bookmark-icon' onclick="toggleSave(this)"></i>
    <p class="noBookmark"></p> 

    <i class='bx bxs-star favorite-icon' onclick="toggleFavorite(this)"></i>
    <p class="noFavorite"></p> 
</div>
    
    
   
    <div class="art-details">
        <div class="top-details"> 
            <h3 class="data-artId"></h3>
           
            <div class="close-popup" onclick="closePopup()">
                <i class="bx bx-x"></i>
            </div>
        </div>

        <div class="art-information">
       
        <p>
            <b>Artist:</b> 
            <em>
                <a href="javascript:void(0);" class="data-id" id="data-id" data-artist-id="<?php echo $_SESSION['u_id']; ?>" onclick="window.location.href='profileDash.php?id=' + this.getAttribute('data-artist-id');"></a> 
            </em>
        </p>

            <p><b>Category:</b> <span class="category"></span></p><br>
            <p class="description-of-art"></p>
            <p><b>Date:</b>&nbsp;<span class="dateUpload"></span></p>
          
        </div>

        
        <div class="interaction">
            <h5>Comments</h5>
            <div class="user-image">
                <div class="profile-pic"> 
                <img src="<?php echo $imagePath; ?>" alt="Profile Picture">
                </div> 
                <h5>Angel Canete</h5>                             
            </div>
            <div class="comment">
                <p>Wow!</p>
            </div>                            
        </div>

       
        <div class="input-comment">
            <textarea name="comment" id="comment" class="comment-area"></textarea>
            <button class="comment-btn"><i class="bx bxs-send"></i></button>
        </div>
    </div>
</div>

    <!-- artworks display -->
     <div class="dashcontainer" id="dashboardContainer">
    <div class="overlay">

    </div>
     <div class="top-head">
        <p><b>Worxist</b><span>
        </span></p>

            <div class="searchbar">
                 <input type="text" class="bar">
                <i class='bx bx-search search'></i>

            </div>
           
            <div class="notification-wrapper">
    <div class="notification-icon" onclick="toggleNotifications()">
        <i class='bx bxs-bell'></i>
        <span class="badge"><?php echo count($notifications); ?></span>
    </div>

    <div class="notification-center" id="notificationCenter">
    <h5>Notifications</h5>
    <ul>
        <?php if (!empty($notifications)): ?>
            <?php foreach ($notifications as $notification): ?>
                <li>
                    <a href="uploadCollab.php?exbt_id=<?php echo $notification['exbt_id']; ?>">
                        <?php echo htmlspecialchars($notification['message']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>No new notifications.</li>
        <?php endif; ?>
    </ul>
    <a href="#" class="view-all">View all notifications</a>
</div>

</div>






            
            <div class="filter-container">
                <i class='bx bx-filter filter-icon' onclick="toggleDropdown()"></i>
                <div class="dropdown">
    <div class="dropdown-content" id="dropdown">
        <a href="#" data-category="all">All Categories</a>
        <a href="#" data-category="Sketches">Sketches</a>
        <a href="#" data-category="Sculpture">Sculpture</a>
        <a href="#" data-category="Painting">Painting</a>
        <a href="#" data-category="Abstract">Abstract</a>
        <a href="#" data-category="Landscape">Landscape</a>
        <a href="#" data-category="Landscape">Landscape</a>
        <a href="#" data-category="Portrait">Portrait</a>
        <a href="#" data-category="Figurative">Figurative</a>
        <a href="#" data-category="Expressionism">Expressionism</a>
        <a href="#" data-category="Photography">Photography</a>
        <a href="#" data-category="Digital Art">Digital Art</a>
        <a href="#" data-category="Sculpture">Sculpture</a>
        <a href="#" data-category="Conceptual Art">Conceptual Art</a>
        <a href="#" data-category="Pop Art">Pop Art</a>
        <a href="#" data-category="Minimalism">Minimalism</a>
        <a href="#" data-category="Street Art">Street Art</a>
        <a href="#" data-category="Fantasy">Fantasy</a>
        <a href="#" data-category="Crafts">Crafts</a>
        <a href="#" data-category="Nature">Nature</a>
        <a href="#" data-category="Architecture">Architecture</a>
        <a href="#" data-category="Historical">Historical</a>
        <a href="#" data-category="Political Art">Political Art</a>
        <a href="#" data-category="Cultural Art">Cultural Art</a>
        <a href="#" data-category="Installation Art">Installation Art</a>
        <a href="#" data-category="Performance Art">Performance Art</a>
        <a href="#" data-category="Renaissance">Renaissance</a>
        <a href="#" data-category="Baroque">Baroque</a>
        <a href="#" data-category="Gothic Art">Gothic Art</a>
        <a href="#" data-category="Contemporary Art">Contemporary Art</a>
    </div>
</div>
            </div>
          
            <div class="profile">
                <div class="profile-pic"  onclick="toggleEditProfile()" > 
                <img src="<?php echo $imagePath; ?>" alt="Profile Picture">
                </div>
                <p class="to-edit-profile-btn" onclick="toggleEditProfile()"><b><?php echo $username;?> </b></p>
            </div>
        </div>



<div class="image-artwork" id="blur">
    <?php 
    if (!empty($allImages)) {
        foreach ($allImages as $image) { 
        
            ?>
            <div class="box" 
                 onclick="showPopup(this)" 
                 data-image="<?php echo htmlspecialchars($image['file']); ?>"
                 data-title="<?php echo($image['title']); ?>"
                 data-artist="<?php echo ($image['u_name']); ?>"
                 data-artist-id="<?php echo ($image['u_id']); ?>"
                 data-category="<?php echo($image['category']); ?>" 
                 data-description="<?php echo($image['description']); ?>"
                data-date="<?php echo date("F d, Y", strtotime($image['date'])); ?>"
                 data-artwork-id="<?php echo ($image['a_id']); ?>"
                 data-liked="<?php echo ($image['likes_count']); ?>"
                 data-favorite="<?php echo ($image['favorites_count']); ?>"
                 data-saved="<?php echo ($image['saved_count']) ?>">
                 
                <img src="<?php echo($image['file']); ?>" alt="Uploaded Image">
                <div class="artist-name">
                    <p><span><b><?php echo($image['u_name']); ?></b></span><br>
                    <?php echo ($image['title']); ?></p>
                </div>
            </div>
            <?php 
        }
    } else {
        echo "<p>No images found.</p>";
    }
    ?>
</div>

   </div>

   

        <!-- artwork section -->
     <div class="artwork-section" id="artworkContainer">
    
    <div class="tabpanes">
    <h3>Artworks</h3>
        <div class="tab">
        <a class="tablinks" onclick="myOption(event, 'Created')">Created <span></span></a>
        <a class="tablinks" onclick="myOption(event, 'Saved')">Saved <span></span></a>
        <a class="tablinks" onclick="myOption(event, 'Favorites')">Favorites<span></span></a>
        <a class="tablinks" onclick="myOption(event, 'Pending')">Pending<span></span></a>

        </div>
    <!-- Created -->
    <div class="tabcontent" id="Created" >

      <h3>My Creations</h3>
    
      <div class="image-artwork created">

            <button class="box-button" id="upload" onclick="window.location.href='uploadArt.php'"> 
                <i class='bx bx-message-square-add'></i>
            </button>
          
                        <?php 
                if (!empty($images)) {
                    foreach ($images as $image) { 
                        ?>
                         
                        <div class="box" 
                  
                            onclick="showPopup(this)" 
                            
                            data-image="<?php echo htmlspecialchars($image['file']); ?>"
                            data-title="<?php echo ($image['title']); ?>"
                            data-artist="<?php echo ($image['u_name']); ?>"
                            data-artist-id="<?php echo($image['u_id']); ?>"
                            data-category="<?php echo($image['category']); ?>" 
                            data-description="<?php echo($image['description']); ?>"
                            data-date="<?php echo($image['date']); ?>"
                            data-artwork-id="<?php echo($image['a_id']); ?>" 
                            data-liked="<?php echo ($image['likes_count']); ?>"
                            data-favorite="<?php echo ($image['favorites_count']); ?>"
                            data-saved="<?php echo ($image['saved_count']) ?>">


                            <img src="<?php echo($image['file']); ?>" alt="Uploaded Image">
                            <div class="artist-name">
                                <p><span><b><?php echo ($image['u_name']); ?></b></span><br>
                                <?php echo ($image['title']); ?></p>
                            </div>
                          
                        </div>
                        <?php 
                    }
                } else {
                    echo "<p>Empty Creations</p>";
                }
                ?>
</div>
 
    </div>
    
    
    <!-- Saved -->
    <div id="Saved" class="tabcontent">
      <h3>Saved Artworks</h3>
     
      <div class="image-artwork">
                        <?php 
                if (!empty($artSaved)) {
                    foreach ($artSaved as $save) { 
                        ?>
                        <div class="box" 
                            onclick="showPopup(this)" 
                            data-image="<?php echo htmlspecialchars($save['file']); ?>"
                            data-title="<?php echo ($save['title']); ?>"
                            data-artist="<?php echo ($save['u_name']); ?>"
                            data-artist-id="<?php echo ($save['u_id']); ?>"
                            data-category="<?php echo ($save['category']); ?>" 
                            data-description="<?php echo ($save['description']); ?>"
                            data-artwork-id="<?php echo ($save['a_id']); ?>"
                            data-liked="<?php echo ($image['likes_count']); ?>"
                            data-favorite="<?php echo ($image['favorites_count']); ?>"
                            data-saved="<?php echo ($image['saved_count']) ?>">
                                        
                            
                            <img src="<?php echo ($save['file']); ?>" alt="Uploaded Image">
                            <div class="artist-name">
                                <p><span><b><?php echo ($save['u_name']); ?></b></span><br>
                                <?php echo ($save['title']); ?></p>
                            </div>
                        </div>
                        <?php 
                    }
                } else {
                    echo "<p>Empty Saved Artwork</p>";
                }
                ?>
            </div>
                
        </div>
    
    
         <!-- Favorites -->
         <div id="Favorites" class="tabcontent">
            <h3>My Favorites</h3>
            <div class="image-artwork">
                        <?php 
                if (!empty($artFave)) {
                    foreach ($artFave as $favorite) { 
                        ?>
                        <div class="box" 
                            onclick="showPopup(this)" 
                            data-image="<?php echo htmlspecialchars($favorite['file']); ?>"
                            data-title="<?php echo($favorite['title']); ?>"
                            data-artist="<?php echo ($favorite['u_name']); ?>"
                            data-artist-id="<?php echo ($favorite['u_id']); ?>"
                            data-category="<?php echo ($favorite['category']); ?>" 
                            data-description="<?php echo ($favorite['description']); ?>"
                            data-artwork-id="<?php echo ($favorite['a_id']); ?>"
                            data-liked="<?php echo ($image['likes_count']); ?>"
                            data-favorite="<?php echo ($image['favorites_count']); ?>"
                            data-saved="<?php echo ($image['saved_count']) ?>">
                            
                            <img src="<?php echo ($favorite['file']); ?>" alt="Uploaded Image">
                            <div class="artist-name">
                                <p><span><b><?php echo ($favorite['u_name']); ?></b></span><br>
                                <?php echo ($favorite['title']); ?></p>
                            </div>
                        </div>
                        <?php 
                    }
                } else {
                    echo "<p>Empty Favorites</p>";
                }
                ?>
            </div>
        </div>
            
        <div class="tabcontent" id="Pending" >
                <div class="head-pending">
                <h3>Pending Artworks</h3>     
                <?php
    if ($pendingRequest) {
        echo "<button id='viewExhibit-btn' data-exbt-type='" . htmlspecialchars($pendingRequest['exbt_type']) . "'>View Pending Exhibit</button><br>";
    } else {
       
    }
    ?>

                </div>
            
            <div class="image-artwork created">

            <?php 
    if (!empty($pendingArtworks)) {
        foreach ($pendingArtworks as $image) { 
            ?>
             
            <div class="box" 
      
                onclick="showPopup(this)" 
                
                data-image="<?php echo htmlspecialchars($image['file']); ?>"
                data-title="<?php echo ($image['title']); ?>"
                data-artist="<?php echo ($image['u_name']); ?>"
                data-artist-id="<?php echo($image['u_id']); ?>"
                data-category="<?php echo($image['category']); ?>" 
                data-description="<?php echo($image['description']); ?>"
                data-date="<?php echo($image['date']); ?>"
                data-artwork-id="<?php echo($image['a_id']); ?>" 
                data-liked="<?php echo ($image['likes_count']); ?>"
                data-favorite="<?php echo ($image['favorites_count']); ?>"
                data-saved="<?php echo ($image['saved_count']) ?>">


                <img src="<?php echo($image['file']); ?>" alt="Uploaded Image">
                <div class="artist-name">
                    <p><span><b><?php echo ($image['u_name']); ?></b></span><br>
                    <?php echo ($image['title']); ?></p>
                </div>
              
            </div>
            <?php 
        }
    } else {
        echo "<p>No Artworks Uploaded</p>";
    }
    ?>
</div>
        </div>
        

        <!-- end of tabpande -->
    </div>
    
        <!-- end of myartwork -->
       </div>



       <!-- Messegaes -->
        <div class="messages-container" id="messageContainer">
            
            <div class="head-message">
                 <h2>Chats</h2>
                
            </div>
           
            <div class="message-name">
                
                <div class="message-name-head">
                        <div class="message-user-image"> 
                             <img src="gallery/girl.jpg" alt=""> <br>
                             <p>Jamaica Anuba</p><br>
                             <input type="text" name="search-friend" id="search-friend" placeholder="Search">
                        </div><br>
                        <h3>Messages</h3>
                        
                </div>

                <div class="name-box-container">
                     <div class="message-name-box">
                         <div class="profile-pic message-profile"> 
                             <img src="gallery/girl.jpg" alt=""> 
                        </div>
    
                        <h5>Jerald Aliviano</h5>
                </div>

                <div class="message-name-box">
                    <div class="profile-pic message-profile"> 
                        <img src="gallery/eyes.jpg" alt=""> 
                   </div>

                   <h5>Angel Canete</h5>
                </div>
                </div>
               
                 
            </div>

            <!-- image display -->
            <div class="message-display ">
                <div class="message-name-box header-chat" >
                    <div class="profile-pic message-profile"> 
                        <img src="gallery/eyes.jpg" alt=""> 
                   </div>

                   <h2>Angel Canete</h2>
                
                </div>

                <div class="messages-body">
            <!-- Incoming Message -->
            <div class="message incoming">
                <div class="message-content">
                    <p>Hello Jai</p>
                    <span class="timestamp">10:30 AM</span>
                </div>
            </div>

            <!-- Outgoing Message -->
            <div class="message outgoing">
                <div class="message-content">
                    <p>Hi gel</p>
                    <span class="timestamp">10:32 AM</span>
                </div>
            </div>

            <!-- Incoming Message -->
            <div class="message incoming">
                <div class="message-content">
                    <p>What are you up to?</p>
                    <span class="timestamp">10:33 AM</span>
                </div>
            </div>
        </div>

        <!-- Message Input Area -->
        <div class="messages-footer">
            <input type="text" placeholder="Type a message" class="message-input">
            <button class="send-btn"><i class='bx bx-send'></i></button>
        </div>

                
            </div>
            <!-- end of message container -->
        </div>




        <!-- Exhbits -->
        <div class="exhibit-container" id="exhibitContainer">
    <button onclick="toggleExhibit()" class="schedule-now">Schedule Now</button>
    
    <!-- Top gallery section with title -->
    <div class="gallery-container">
        <div class="top-gallery">
            <h3>
                <?php 
                    echo isset($exhibit[0]['exbt_title']) ? ($exhibit[0]['exbt_title']) : 'Exhibit Title'; 
                ?>
            </h3>
        </div>
        <div class="descriptionExhibit">
    <p class="viewDescription">View Description</p>
</div>

<!-- Popup modal for description -->
<div class="exhibition-description-popup">
    <div class="exhibition-description-popup-content">
        <span class="exhibition-close-popup" hidden>&times;</span>
        <p>
            <?php 
                echo isset($exhibit[0]['exbt_descrip']) ? $exhibit[0]['exbt_descrip'] : 'No description available.';
            ?>
        </p>
    </div>
</div>


        <!-- Carousel navigation icons -->
        <div class="nav-icons">
            <div class="prev-icon">&#10094;</div>
            <div class="next-icon">&#10095;</div>
        </div>

    
        <div class="carousel">
            <div class="carousel-img left-img">
                <img src="gallery/empty.png" alt="Left Image" class="side-image">
            </div>

            <div class="carousel-img center-img">
                <div class="center-container">
                    <img src="gallery/empty.png" alt="Center Image" class="center-image">
                    <div class="center-description">
                        <h3>Artwork Title</h3>
                        <p>Description</p>      
                    </div>
                </div>
            </div>

            <div class="carousel-img right-img">
                <img src="gallery/empty.png" alt="Right Image" class="side-image">
            </div>
        </div>

       
        <div class="info-exhibit">
        <div class="nav-icons2">
            <div class="prev-icon2">&#10094;</div>
            <div class="next-icon2">&#10095;</div>
         </div>
         <div class="artist-info">
    <img src="gallery/eyes.jpg" alt="Artist Profile Image" class="artist-img">
    <p>
        <span></span><br>Cebu, Philippines
    </p>
</div>

        </div>

        
    </div>
</div>

        <!--  Exhibit Request -->
        <div id="reqExhibit-con" class="reqExhibit-con">
            <div class="top-req">
                <i class='bx bx-chevron-left' onclick="toggleExhibit()"></i>
                <p>Schedule Your Exhibition Now</p>
            </div>
            <?php if ($hasPendingExhibit): ?>
        <div class="pending-exhibit-message">
            <p>You already have a pending exhibit.</p><br>
            <button class="viewExhibit" id="viewExhibit" data-exbt-type="<?php echo htmlspecialchars($pendingRequest['exbt_type']); ?>">View Pending Exhibit</button>
        </div>
        
    <?php else: ?>
            <div class="tab-btn">
                <button class="requestLink" onclick="openPage('Solo')" id="defaultOpen">Solo</button>
                <button class="requestLink" onclick="openPage('Collaborative')" >Collaborate</button>
            </div>


            <div id="artworkValidationModal" class="artwork-modal">
    <div class="artwork-modal-content">
        <span class="artwork-close">&times;</span>
        <h3>Validation Errror</h3>
        <p>Please select at least one artwork to schedule the exhibit.</p>
    </div>
</div>
            <div id="Solo" class="requestTab">
    <div class="exhibit-inputs">
        <form action="" name="soloExhibit" method="POST" id="soloExhibitForm">
            <label for="exhibit-title">Exhibit Title</label><br>
            <input type="text" name="exhibit-title" placeholder="Enter the title of your exhibit" required><br>

            <label for="exhibit-description">Exhibit Description</label><br>
            <textarea name="exhibit-description" id="exhibit-description" placeholder="Describe the theme or story behind your exhibit" required></textarea><br>

            <label for="exhibit-date">Exhibit Date</label><br>
            <input type="date" id="exhibit-date" name="exhibit-date" required><br>

            
            <input type="hidden" name="selected_artworks" id="selectedArtworks" required>

            <div class="confirm-solo">
                <button class="solo-btn" id="solo-btn" name="requestSolo">Confirm Schedule</button>
            </div>
        </form>
        <div class="image-exhibit">
            <img src="gallery/image/solo-image.png" alt="Painting Graphics">
        </div>
    </div>

    <div class="select-art">
    <p>Selected Artworks (Maximum of 10)</p>
    <div class="display-creations">
        <?php if (!empty($images)): ?>
            <?php foreach ($images as $image): ?>
                <div class="image-item">
                    <?php
                    
                    error_log("Image path: " . ($image['file']));
                    error_log("Artwork ID: " . ($image['a_id']));
                    ?>
                    <img src="<?php echo ($image['file']); ?>" alt="Uploaded Artwork" data-id="<?php echo ($image['a_id']); ?>">
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>You don't have any uploaded artworks.</p>
        <?php endif; ?>
    </div>
</div>

</div>




<!-- collab request -->
<div id="Collaborative" class="requestTab">

        <div id="artworkValidationModalCollaborative" class="artwork-modal-collaborative">
            <div class="artwork-modal-content">
                <span class="artwork-close">&times;</span>
                <h3>Validation Errror</h3>
                <p>Please select at least one artwork before submitting.</p>
            </div>
        </div>

        <div id="collaboratorValidationModal" class="collaborator-modal">
            <div class="collaborator-modal-content">
                <span class="collaborator-close">&times;</span>
                <h3>Validation Error</h3>
                <p>Please add at least one collaborator before submitting.</p>
            </div>
        </div>

        <div id="dateValidationModal" class="date-modal">
            <div class="date-modal-content">
                <span id="dateCloseButton" class="date-close">&times;</span>
                <h3>Date Validation Error</h3>
                <p>The selected exhibit date is already scheduled. Please choose a different date.</p>
            </div>
        </div>



    <div class="exhibit-inputs">
    <form action="" name="collabExhibit" method="POST" id="collabExhibitForm">

<label for="exhibit-title">Exhibit Title</label><br>
<input type="text" name="exhibit-title" placeholder="Enter the title of your exhibit" required><br>

<label for="exhibit-description">Exhibit Description</label><br>
<textarea name="exhibit-description" id="exhibit-description" placeholder="Describe the theme or story behind your exhibit" required></textarea><br>

<label for="exhibit-date">Exhibit Date</label><br>
<input type="date" id="exhibit-date" name="exhibit-date" required><br>

<input type="hidden" id="selectedCollaboratorsInput" name="selected_collaborators" value="" required>

<input type="hidden" name="selected_artworks_collab" id="selectedArtworksCollab" required>

<div class="confirm-solo">
    <button type="submit" class="collab-btn" name="requestCollab">Confirm Schedule</button>
</div>
</form>


        <div class="add-collab">
            
            <label for="collabSearch">Add Collaborators</label><br>
            <input type="text" id="collabSearch" placeholder="Search" oninput="searchCollaborators(this.value)">

            <div class="display-collab" id="searchResults"></div>

            <div id="selectedCollaborators"></div>
        </div>
    </div>

    <!-- Artworks Section -->
    <div class="select-art">
    <p>Selected Artworks (Maximum of 10)</p>
    <div class="display-creations">
        <?php if (!empty($images)): ?>
            <?php foreach ($images as $image): ?>
                <div class="image-item">
                    <?php
                    
                    error_log("Image path: " . ($image['file']));
                    error_log("Artwork ID: " . ($image['a_id']));
                    ?>
                    <img src="<?php echo ($image['file']); ?>" alt="Uploaded Artwork" data-id="<?php echo ($image['a_id']); ?>">
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


<div class="settings-container" id="settingsContainer">
<h2>Settings</h2>

<div class="tab-container">
<div class="tab-settings">
        <button class="setlinks" onclick="openSettings(event, 'myProfile')" id="defaultOpen">My Profile</button>
        <button class="setlinks" onclick="openSettings(event, 'accSetting')">Account Setting</button>
        <button class="setlinks" onclick="openSettings(event, 'notifSetting')">Notification</button>
    </div>
               
            <div id="myProfile" class="tabInformation"> 
                <h3>My Profile</h3>
                <div class="top-myprofile">
                    <div class="profile-picture">
                    <div class="image-profile">
                    <img src="<?php echo $imagePath; ?>" alt="Profile Picture">
</div>

                        <div class="text-image">
                            <h3>Upload new image</h3>
                            <p>Max file size - 10mb</p>
                        </div>
                    </div>

                    <div class="profileModal" id="profileModal" style="display:none;">
    <div class="modalProfile-content">
        <span class="profileclose-btn" id="profilecloseModal">&times;</span>
        <h2>Upload Profile Picture</h2>
        
        
        <form id="profileUploadForm" method="POST" enctype="multipart/form-data">
            <input type="file" name="profilePicture" id="profilePicture" accept="image/*" required onchange="previewImage(event)">
            <div class="upload-image-btn">
                <button type="submit" name="uploadProfilePic">Upload</button>
               
            </div>
        </form>

        
        <div id="imagePreviewContainer" style="display:none;">
            <h3>Selected Image:</h3>
            <img id="imagePreview" src="" alt="Preview" style="max-width: 200px;">
        </div>
    </div>
</div>


<button id="uploadProfileBtn">Upload Profile Picture</button>
<button type="button" id="removeProfilePic" onclick="removeProfilePic()">Remove Image</button>   

                </div>

                <div class="form-below">

                <div class="follow">
                    <p><span >10</span>
                    <a href="#" id="openFollowers">Followers</a>
                    </p>

                    <p><span >1</span>
                    <a href="#"  id="openFollowing">Following</a>
                    </p>
                </div>
                
                <!-- edit username -->
                <form action="change.php" method="POST">
                    <label for="edit-username">Edit Username</label><br>
                    <input type="text" id="edit-username" name="new_username" value="<?php echo($username); ?>" required><br><br>
                    <input type="hidden" name="action" value="change_username">
                    <button type="submit">Save Changes</button>
                </form>
                </div>
            </div>
<!-- account setting -->
            <div id="accSetting" class="tabInformation">
                <h2>Account Setting</h2>
                
                <div class="name-display">

                <div class="myname">
                <h3>Name</h3>
                    <form action="change.php" method="POST">
                        <input type="text" name="new_name" value="<?php echo htmlspecialchars($name); ?>" required>
                        <input type="hidden" name="action" value="change_name">
                        <button type="submit">Change</button>
                    </form>
                </div>
                    
                
                </div>

                <hr>
                <br>
                <h3>Email Address</h3>
                <p>Your email is <span><em><?php echo $email;?></em></span></p>
            
                <br>
                <hr>

                <div class="password-container">

                <div class="mypassword">
                    <h3>Password</h3>
                    <form action="change.php" method="POST">
                        
                        <input type="password" id="new_password" name="new_password" required>
                        <input type="hidden" name="action" value="change_password">
                        <button type="submit">Change</button>
                    </form>
                </div>

                </div>
                
            <div class="delete-container">
                    <div class="confirm-delete">
                        <h3>Delete Account</h3>
                        <p>Would you like to delete your account? Deleting your account will remove all the content associated with it.</p>
                    </div>

                    <form action="change.php" method="POST">
                        <input type="hidden" name="action" value="delete_account">
                        <button type="submit" onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">I want to delete my account</button>
                    </form>
                </div>

            </div>

<!-- notifications -->
            <div id="notifSetting" class="tabInformation"> 
                <h3>Notification</h3>
                
                <div class="enable-desktop-con">
                    <div class="descrip-notif">
                        <h5>Enable Desktop Notification</h5>
                        <p>Receive notification all of the messages, updates, documents</p>
                    </div>
                    <div class="toggle-switch">
                        <input type="checkbox" id="switch1" class="switch-input">
                        <label for="switch1" class="switch-label"></label>
                    </div>
                </div>

                <div class="enable-desktop-con">
                    <div class="descrip-notif">
                        <h5>Enable Unread Notification</h5>
                        <p>Shows a red badge when you have an unread message</p>
                    </div>
                    <div class="toggle-switch">
                        <input type="checkbox" id="switch2" class="switch-input">
                        <label for="switch2" class="switch-label"></label>
                    </div>
                </div>
                <h3>Email Notification</h3>
                <div class="enable-desktop-con">
                    <div class="descrip-notif">
                        <h5>Communication Emails</h5>
                        <p>Receive emails for messages, contracts, documents</p>
                    </div>
                    <div class="toggle-switch">
                        <input type="checkbox" id="switch3" class="switch-input">
                        <label for="switch3" class="switch-label"></label>
                    </div>
                </div>

                <div class="enable-desktop-con">
                    <div class="descrip-notif">
                        <h5>Announcements & Updates</h5>
                        <p>Receive notification all of the messages, updates, documents</p>
                    </div>
                    <div class="toggle-switch">
                        <input type="checkbox" id="switch4" class="switch-input">
                        <label for="switch4" class="switch-label"></label>
                    </div>
                </div>
            </div>      

</div>
  
         <!-- Popup Modal -->
         <div id="followers-modal" class="modal">
                        <div class="modal-content">
                            <span class="close-button">&times;</span>
                            
                            <div id="followers-content">
                                <h5>Followers</h5>
                                <div class="follower-display">
                                    <div class="profile-pic">
                                        <img src="gallery/eyes.jpg" alt="">
                                    </div>
                                    <div class="follower-name">
                                        <h5>Angel Canete <br>
                                            <span><a href="profileDash.php"><span>@</span>scyy</a></span>
                                        </h5>
                                    </div>
                                </div>
                            
                                
                            </div>

                            <div id="following-content" style="display: none;">
                                <h5>Following</h5>
                                <div class="following-display">
                                    <div class="profile-pic">
                                        <img src="gallery/girl.jpg" alt="">
                                    </div>
                                    <div class="follower-name">
                                        <h5>Angel Canete <br>
                                            <span><a href="profileDash.php"><span>@</span>scyy</a></span>
                                        </h5>
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                    </div>

            <div class="modal-content">
                <span class="close-button">&times;</span>
                
                <div id="followers-content">
                    <h5>Followers</h5>
                    <div class="follower-display">
                        <div class="profile-pic">
                            <img src="gallery/eyes.jpg" alt="">
                        </div>
                        <div class="follower-name">
                            <h5>Angel Canete <br>
                                <span><a href=""><span>@</span>scyy</a></span>
                            </h5>
                        </div>
                    </div>
                
                    
                </div>

                <div id="following-content" style="display: none;">
                    <h5>Following</h5>
                    <div class="following-display">
                        <div class="profile-pic">
                            <img src="gallery/eyes.jpg" alt="">
                        </div>
                        <div class="follower-name">
                            <h5>Angel Canete <br>
                                <span><a href="profileDash.html"><span>@</span>scyy</a></span>
                            </h5>
                        </div>
                    </div>
                
                </div>
            </div>
        </div>

    <!-- end of settings container -->
</div>



        
    <!-- end of wrapper -->
   </div>
   <script>
console.log(<?php echo json_encode($collaborators); ?>);
const collaborators = [
    <?php foreach ($collaborators as $collaborator): ?>{
        artistName: "<?php echo htmlspecialchars($collaborator['u_name']); ?>",
        artistImage: "<?php echo 'profile_pics/' . $collaborator['profile_image']; ?>",
        artworks: [
            <?php foreach ($collaborator['artworks'] as $artwork): ?>{
                src: "<?php echo htmlspecialchars($artwork['artwork_file']); ?>",
                title: "<?php echo htmlspecialchars($artwork['artwork_title']); ?>",
                description: "<?php echo htmlspecialchars($artwork['artwork_description']); ?>"
            },
            <?php endforeach; ?>
        ]
    },
    <?php endforeach; ?>
];

let currentCollaboratorIndex = 0; 
let currentArtworkIndex = 0; 


document.querySelector('.next-icon2').addEventListener('click', () => {
    console.log('Collaborators array:', collaborators);
    console.log('Collaborators length:', collaborators.length);
    console.log("Collaborators Array:", collaborators);

    if (collaborators.length <= 1) return; 

    console.log('Current index before update:', currentCollaboratorIndex);
    currentCollaboratorIndex = (currentCollaboratorIndex + 1) % collaborators.length;
    console.log('Current index after update:', currentCollaboratorIndex);

    currentArtworkIndex = 0;
    console.log('Next collaborator index:', currentCollaboratorIndex);
    updateArtist();
    updateCarousel();
});


document.querySelector('.prev-icon2').addEventListener('click', () => {
    currentCollaboratorIndex = (currentCollaboratorIndex - 1 + collaborators.length) % collaborators.length;
    currentArtworkIndex = 0;
    console.log('Previous collaborator index:', currentCollaboratorIndex);
    updateArtist();
    updateCarousel();
});

document.querySelector('.next-icon').addEventListener('click', () => {
    const artworks = collaborators[currentCollaboratorIndex].artworks;
    currentArtworkIndex = (currentArtworkIndex + 1) % artworks.length;
    updateCarousel();
});

document.querySelector('.prev-icon').addEventListener('click', () => {
    const artworks = collaborators[currentCollaboratorIndex].artworks;
    currentArtworkIndex = (currentArtworkIndex - 1 + artworks.length) % artworks.length;
    updateCarousel();
});


function updateArtist() {
    const artistInfo = document.querySelector('.artist-info');
    const collaborator = collaborators[currentCollaboratorIndex];

    const artistImageElement = artistInfo.querySelector('img');
    const artistNameElement = artistInfo.querySelector('span');

    artistImageElement.src = collaborator.artistImage;
    artistImageElement.alt = collaborator.artistName;
    artistNameElement.textContent = collaborator.artistName;
}

function updateCarousel() {
    const collaborator = collaborators[currentCollaboratorIndex];
    const artworks = collaborator.artworks;

    if (artworks.length === 0) {
        console.log('No artworks available for current collaborator');
        return;
    }

    const leftImg = document.querySelector('.left-img img');
    const centerImg = document.querySelector('.center-img img');
    const centerTitle = document.querySelector('.center-description h3');
    const centerDesc = document.querySelector('.center-description p');
    const rightImg = document.querySelector('.right-img img');

    const leftIndex = (currentArtworkIndex - 1 + artworks.length) % artworks.length;
    const centerIndex = currentArtworkIndex;
    const rightIndex = (currentArtworkIndex + 1) % artworks.length;

    leftImg.src = artworks[leftIndex].src;
    centerImg.src = artworks[centerIndex].src;
    centerTitle.textContent = artworks[centerIndex].title;
    centerDesc.textContent = artworks[centerIndex].description;
    rightImg.src = artworks[rightIndex].src;
}

// Initialize the display
updateArtist();
updateCarousel();



</script>

   <script src="js/dashboard.js"></script>
                                    
</body>
</html>