<?php
session_start();

include("include/connection.php");
include 'class/accClass.php'; 
include 'class/artClass.php'; 
include 'class/exhbtClass.php'; 


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $u_id = intval($_GET['id']); 
} else {
    echo "Invalid User ID!";
    exit; 
}
$accountManager = new AccountManager($conn); 
$accountInfo = $accountManager->getAccountInfo($u_id);

$exhibitManager = new artManager($conn);
$artwork=$exhibitManager->visitArtworks($u_id);

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style2.css">
    <link rel="shortcut icon" href="gallery/image/vags-logo.png" type="image/x-icon">
    <title>Profile View</title>
</head>
<body>
    <header class="head-view">
        <p><a href="dashboard.php"><</a></p>
    </header>

    <div class="wrapper-view">
        <div class="profile-details">
            <div class="image-profile">
                <img src="gallery/head.png" alt="">
            </div>

            <div class="user-information">
            <h5><?php echo ($accountInfo['u_name']); ?></h5>
            <p><span>@</span><?php echo ($accountInfo['username']); ?></p>

                <div class="follow">
                    <p><span >10</span>
                    <a href="" id="openFollowers">Followers</a>
                    </p>

                    <p><span >1</span>
                    <a href=""  id="openFollowing">Following</a>
                    </p>
                </div>

                <button class="follow-btn">
                    Follow
                </button>
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


        <!-- below folder section -->
 
                <div class="tab">
                    <button class="tablinks" onclick="openTab(event, 'created')">Created</button>
                    <button class="tablinks" onclick="openTab(event, 'saved')">Saved</button>
                </div>
                

                <div id="created" class="tabcontent">
                    <div class="image-artwork">
                        <?php
                        if (!empty($artwork)) {
                            foreach ($artwork as $art) {
                                ?>
                                <div class="box">
                                    <img src="<?php echo ($art['file']); ?>" alt="Uploaded Image">
                                    <div class="artist-name">
                                        <p><span><b><?php echo ($accountInfo['u_name']); ?></b></span><br>
                                        <?php echo ($art['title']); ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo "<p>No artworks found for this artist.</p>";
                        }
                        ?>
                    </div>
                </div>

                
                
                <div id="saved" class="tabcontent">
                    <div class="folder-container">

                        <div class="folder-image">

                            <div class="right-image">
                                 <img src="gallery/prof.jpg" alt="">
                                <img src="gallery/red.jpg" alt="">
                            </div>
                            

                             <div class="left-image">
                                 <img src="gallery/girl.jpg" alt="">
                             </div>                           
                             
                        </div>

                        <div class="folder-image">

                            <div class="right-image">
                                 <img src="gallery/prof.jpg" alt="">
                                <img src="gallery/red.jpg" alt="">
                            </div>
                            

                             <div class="left-image">
                                 <img src="gallery/girl.jpg" alt="">
                             </div>                           
                             
                        </div>

                        <div class="folder-image">

                            <div class="right-image">
                                 <img src="gallery/prof.jpg" alt="">
                                <img src="gallery/red.jpg" alt="">
                            </div>
                            

                             <div class="left-image">
                                 <img src="gallery/girl.jpg" alt="">
                             </div>                           
                             
                        </div>
                   
                    </div>

                    
                </div>
                
         
    </div>
    
    <script src="js/dashboard.js"> </script>
    <script>
 function openTab(evt, tabName) {
    var i, tabcontent, tablinks;

    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none"; 
    }

    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", ""); 
    }

    document.getElementById(tabName).style.display = "block"; 
    evt.currentTarget.className += " active"; 
}


document.addEventListener("DOMContentLoaded", function() {
    var firstTab = document.querySelector('.tablinks');
    firstTab.click(); 
});



      </script>
</body>
</html>