<?php
session_start();

include("../include/connection.php"); 
include '../class/accclass.php';
include '../class/artClass.php';
include '../class/exhbtClass.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('display_errors', 1); // Display errors


if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: /login-register.php");
    die;
}
if (!isset($_SESSION['u_type']) || $_SESSION['u_type'] !== 'Organizer') {
    header("Location: /login-register.php");
    die;
}
if (isset($_POST['uploadProfilePic'])) {
    $accountManager=new AccountManager($conn);
    $accountManager->uploadProfilePicture($_FILES['profilePicture']);
}
$name= $_SESSION['name'];
$username = $_SESSION['username'];
$email = $_SESSION['email'];
$u_type=$_SESSION['u_type'];    
$u_id = $_SESSION['u_id'];
// $password=$_SESSION['hashed_password'];

$user = new AccountManager($conn);
$infos = $user->getAccountInfo($u_id);
$users = $user->getUsers();


// Create an instance of ExhibitManager
$exhibitManager = new ExhibitManager($conn);
$exhibits = $exhibitManager->getExhibitsByStatus('Declined');
error_reporting(E_ALL);
ini_set('display_errors', 1);


//EDIT USERNAME
$userName = new AccountManager($conn);
if (isset($_POST['changeUser'])) { 
    $new_username = trim($_POST['new_username']); 
    $u_id = $_SESSION['u_id']; 

    try {
        $userName->changeUsername($u_id, $new_username); 
        $_SESSION['username'] = $new_username;
        $username = $_SESSION['username'];
    } catch (Exception $e) {
    }
}


//retrieveing pending exhibit
$exhibit= new ExhibitManager($conn);
$pending=$exhibit->getPendingExhibits($u_id);
$request=$exhibit->getRequestExhibit();
$exhibitId = 1; 
$collaborator=$exhibit->getCollab($exhibitId);
$acceptedExhibits = $exhibit->getAccept();

if (isset($_GET['id'])) {
    $exhibit= new ExhibitManager($conn);
    $exhibitId = $_GET['id'];
    $pendingDetails = $exhibit->getExhibitDetails($exhibitId);

    header('Content-Type: application/json');
    if ($pendingDetails) {
        echo json_encode($pendingDetails);
    } else {
        echo json_encode(['error' => 'Exhibit not found']);
    }

    exit(); 
}
// approved or declined exhibits
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle 'approve_all' action
    if (isset($_POST['action']) && $_POST['action'] === 'approve_all') {
        $response = $exhibit->approveAllRequestsExhibit();
        header('Content-Type: text/plain');
        echo $response['message'];
        exit();
    }

 
    if (isset($_POST['exbt_id']) && !empty($_POST['exbt_id']) && isset($_POST['status']) && !empty($_POST['status'])) {
        $exbt_id = $_POST['exbt_id']; 
        $status = $_POST['status'];   

        if ($status === 'Accepted' || $status === 'Declined') {
            $exhibit = new ExhibitManager($conn);
            $update = $exhibit->updateExhibitStatus($exbt_id, $status); 
            
            if ($update) {
                echo json_encode(['status' => 'success', 'message' => 'Exhibit status updated successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update exhibit status']);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid status"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "exbt_id and status are required"]);
    }
    exit();
}



if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['restore_exbt_id'])) {
    $exbt_id = $_POST['restore_exbt_id'];


    $query = "UPDATE exhibit_tbl SET exbt_status = 'Pending' WHERE exbt_id = :exbt_id";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':exbt_id', $exbt_id, PDO::PARAM_INT);
    $stmt->execute();

    exit();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizer</title>
    <link rel="shortcut icon" href="/gallery/image/vags-logo.png" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="org.css">
</head>
<body>
    <main class="exhibits"> 
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">
                <img src="pics/worxist.png" alt="Logo">
            </div>
            <ul class="nav">
    <li><i class='bx bxs-dashboard'></i><a href="#dashboard" class="dasboardLink">Dashboard</a></li>
    <li><i class='bx bx-merge'></i><a href="#exhibits" class="exhibitLink">Exhibits</a></li>
    <li><i class='bx bxs-badge-check'></i></i><a href="#acceptedEx" class="acceptedLink">Accepted</a></li>
    <li><i class='bx bxs-message-rounded-error'></i></i><a href="#declinedEx" class="declinedLink">Declined</a></li>
    <li><i class='bx bxs-cog'></i><a href="#settings" class="settingLink">Settings</a></li>
</ul>
     <a href="../logout.php" class="logout logoutButton"><i class='bx bxs-log-out'></i>Logout</a>
         
        </aside>

      
<!-- Main Content -->
        <section class="main-wrapper">
        <div id="logoutModal" class="logoutModal" style="display:none;">
    <div class="logoutModal-content">
        <p>Are you sure you want to sign out?</p>
        <div class="logoutModal-buttons">
            <a href="#" class="logoutModal-confirm">Yes</a>
            <button id="logoutModalCancel" class="logoutModal-cancel">Cancel</button>
        </div>
    </div>
</div>
        
            <section class="header-wrapper" id="header">
                <header class="header">
                    <div class="header-title">
                        <h1>Review an exhibit today!</h1>

                        
                        <span class="date" id="current-date"></span>
                    </div>
                    <div class="notifications">
                        <span class="bell-icon" id="notification-bell"><i class='bx bxs-bell' undefined ></i></span>
                        <div class="profile-pic1"></div>
                        <div class="dropdown">
                            <div class="nam">
                                <h4>Angel</h4>
                                <p>angelbaby123@gmail.com</p>
                            </div>
                            <ul>
                                <li>
                                    <i class='bx bx-user'></i>
                                    My Profile
                                </li>
                                <li>
                                    <i class='bx bx-cog' ></i>
                                    Account Settings
                                </li>
                                <li>
                                    <i class='bx bx-devices' ></i>
                                    Device Management
                                </li>
                                <li>
                                    <a href="signin.html">
                                        <i class='bx bx-log-out' ></i>
                                        Sign Out
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </header>
            </section>   

            <!-- EXHIBITS REQUESTS -->
            <section class="content-wrapper3" id="dashboard" style="display: none;">

            <div class="overview">
                    <div class="acc">
                        <div class="stat-box">
                            <h3>Accounts <span class="a-badge red">2</span></h3>
                        </div>
                        <div class="a_number"></div>
                    </div>
                    <div class="request">
                        <div class="stat-box">
                            <h3>Posts Requests<span class="p-badge blue">2</span></h3>
                        </div>
                        <div class="r_number"></div>
                    </div>
                </div>   
<?php

// $queryPosts = "SELECT COUNT(*) AS total_posts FROM art_info WHERE a_status = 'Approved'";
// $stmt = $conn->prepare($queryPosts);
// $stmt->execute();
// $totalPosts = $stmt->fetch(PDO::FETCH_ASSOC)['total_posts'];

$queryRequests = "SELECT COUNT(*) AS total_requests FROM exhibit_tbl WHERE exbt_status = 'Pending'";
$stmt = $conn->prepare($queryRequests);
$stmt->execute();
$totalRequests = $stmt->fetch(PDO::FETCH_ASSOC)['total_requests'];

$queryAcceptedExhibitions = "SELECT COUNT(*) AS total_accepted_exhibitions FROM exhibit_tbl WHERE accepted_at IS NOT NULL";
$stmt = $conn->prepare($queryAcceptedExhibitions);
$stmt->execute();
$totalAcceptedExhibitions = $stmt->fetch(PDO::FETCH_ASSOC)['total_accepted_exhibitions'];

  // var posts = {$totalPosts};
echo "<script>
  
    var requests = {$totalRequests};
    var acceptedExhibitions = {$totalAcceptedExhibitions};
</script>";
?>

                <div class="activity">
                    <h3>Activity</h3>
                    <select name="filterChart" id="" style="border-radius: 20px; padding:3px; border:none;">Filter
                        <option value="Weekly">Weekly</option>
                        <option value="Monthly">Monthly</option>
                        <option value="Yearly">Yearly</option>
                    </select>
                    <canvas id="activityChart"></canvas>
                </div>

</section>


            <div class="exhibit-ni-section">

            <div class="actions-wrapper">
        <button id="accept-all-btn" class="btn accept-all">Accept All</button><br><br>
        <!-- <button id="view-declined" class="view-declined">View Declined</button> -->
    </div>





    <section class="content-wrapper1" id="exhibits" style="display: none;">
                <!-- Custom Alert Box -->
       
            <div id="customAlert" class="alert-box">
                <div class="alert-content">
                    <p id="alertMessage"></p><br>
                    <button id="closeAlertBtn" class="close-btn">Close</button>
                </div>
            </div>

            <!-- Popup container -->
            <!-- <div id="declined-popup" class="declined-popup" style="display: none;">
  <div class="popup-content">
  <button id="closeDeclined" class="close-btn-declined">X</button>
  <h2>Declined Exhibits</h2>
    <div id="declined-exhibits-list"></div>
  </div>
</div> -->

        
<div class="posts-wrapper">
    <?php if (!empty($request)) : ?>
        <?php foreach ($request as $exhibit) : ?>
            <div class="card" data-exhibit-id="<?php echo $exhibit['exbt_id']; ?>">
                <img src="pics/banner.png" class="banner-image">
                <div class="card-content">
                    <p class="art-title"><?php echo $exhibit['exbt_title']; ?></p>
                    <p class="description"><?php echo $exhibit['exbt_descrip']; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p class="no-exhibits-message">No pending exhibits available.</p>
    <?php endif; ?>

</div>


                <!-- PANEL INSIDE THE EXHBIT CARD -->
                <section id="panel"  class="panel" style="display: none;">
                    <i class='bx bx-chevron-left'></i>
                    <!-- Header -->
                    <div class="e-header">
        <div class="e-date" id="exhibit-date"></div>
        <h1 id="exhibit-title"></h1>
        <p class="e-description" id="exhibit-description"></p>
    </div>

                  <!-- Content Section -->
<div class="e-content">

<div class="collabRequest" id="collabRequest">
    <!-- Admin Section -->
    <div class="admin">
        <h2>Admin</h2>
        <p id="artist_nameCollab"></p>
        <div class="admin-card">
            <div class="art-collage">
                <div class="artworks">
                    <!-- two images  -->
                </div>
                <div class="artwork">
                    <!-- one image e -->
                </div>
            </div>
        </div>

    </div>
    <!-- Collaborators Section -->
    <div class="collaborators">
    <h2>Collaborators</h2>
    <div class="collaborator-cards" id="collaborators-cards">
        <div class="collab-details">
            <p class="collab-name1" id="collab_name">Angel</p>
            <div class="collaborator">
                <div class="art-collage">
                    <div class="c-artworks">
                        <!-- Multiple images will be inserted here -->
                    </div>
                    <div class="c-artwork">
                        <!-- One image will be inserted here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

                <!-- solo -->
                <div class="solo" id="soloRequest">
                    <h2>Exhibit Owner</h2>
                    <p id="artist_name"></p><br>
                    <div class="admin-card soloCard" id="soloCardImages">

                    </div>
                </div>

</div>

                    <!-- Modal -->
                    <div class="modal" id="image-modal">
                        <button class="nav-btn left-btn">&lt;</button>
                        <button class="nav-btn right-btn">&gt;</button>
                        <div class="modal-content">
                            <img src="" class="modal-image">
                        </div>
                    </div>
                    <div class="actions">
                    <button class="btn approve-btn" name="approveRequest" data-exhibit-id="<?php echo $exhibit['exbt_id']; ?>">Approve</button>
                    <button class="btn decline-btn" name="declineRequest" data-exhibit-id="<?php echo $exhibit['exbt_id']; ?>">Decline</button>

</div>

                    <!-- Popup Container -->
                    <div id="p-popup-container" class="p-popup">
                        <div class="p-popup-content">
                          <p id="p-popup-message" class="p-popup-message"></p>
                          <div class="p-popup-actions">
                            <button id="p-confirm-btn" class="btn p-confirm-btn">Confirm</button>
                            <button id="p-cancel-btn" class="btn p-cancel-btn">Cancel</button>
                          </div>
                        </div>
                    </div>
                </section>
            </section>


            </div>

            <section class="content-wrapper4" id="acceptedEx" style="display: none;">
    <h1>Accepted Exhibits</h1>
    <div class="filter-container">
        <label for="year">Filter by:</label>
        <select id="year" class="filter-select">
            <option value="" disabled selected>Select Year</option>
            <option value="2024">2024</option>
            <option value="2023">2023</option>
            <option value="2022">2022</option>
        </select>
        <select id="month" class="filter-select hidden">
            <option value="" disabled selected>Select Month</option>
            <option value="January">January</option>
            <option value="February">February</option>
            <option value="March">March</option>
            <option value="April">April</option>
            <option value="May">May</option>
            <option value="June">June</option>
            <option value="July">July</option>
            <option value="August">August</option>
            <option value="September">September</option>
            <option value="October">October</option>
            <option value="November">November</option>
            <option value="December">December</option>
        </select>
    </div>
    <div class="ex-wrapper">
    <?php if (!empty($acceptedExhibits)) : ?>
        <?php foreach ($acceptedExhibits as $exhibit) : ?>
            <div class="ex-card" data-year="<?php echo date('Y', strtotime($exhibit['exbt_date'])); ?>" data-month="<?php echo date('F', strtotime($exhibit['exbt_date'])); ?>">
                <img src="pics/banner.png" class="banner-image">
                <div class="ex-card-content">
                    <p class="ex-art-title"><?php echo htmlspecialchars($exhibit['exbt_title'], ENT_QUOTES); ?></p>
                    <p class="ex-description"><?php echo htmlspecialchars($exhibit['exbt_descrip'], ENT_QUOTES); ?></p>
                    
                    <!-- Hidden elements for year, month, and other data -->
                    <input type="hidden" class="hidden-date" value="<?php echo htmlspecialchars($exhibit['exbt_date'], ENT_QUOTES); ?>">
                    <input type="hidden" class="hidden-id" value="<?php echo htmlspecialchars($exhibit['exbt_id'], ENT_QUOTES); ?>">
                    <input type="hidden" class="hidden-status" value="<?php echo htmlspecialchars($exhibit['exbt_status'], ENT_QUOTES); ?>">
                </div>
                <i class='bx bxs-show'><p class="ex-views">1</p></i>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p>No accepted exhibits found.</p>
    <?php endif; ?>
    </div>
</section>


<!-- declined -->
<section class="content-wrapper5" id="declinedEx" style="display: none;">
    <h1>Declined Exhibits</h1>
<div class="header-controls">
<h2>Total Users <span class="total-users"><?= count($exhibits); ?></span></h2>
                    <div class="table-controls">
                      <input type="text" class="search-bar" placeholder="Search">
                      <i class='bx bx-filter'><p class="filter-btn">Filter</p></i>
                    </div>
                </div>
                <table class="user-table">
    <thead>
        <tr>
            <th>Photo</th>
            <th>Name</th>
            <th>Exhibit Title</th>
            <th>Date</th>
            <th>Type</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($exhibits)): ?>
            <?php foreach ($exhibits as $exhibit): ?>
                <tr data-id="<?= $exhibit['exbt_id']; ?>">
                    <td>
                        <?php
                        // Check if the profile image exists
                        $imagePath = '../profile_pics/' . $exhibit['profile'];
                        if (file_exists($imagePath) && !empty($exhibit['profile'])) {
                            echo "<img src=\"$imagePath\" alt=\"Profile Photo\" class=\"user-photo\">";
                        } else {
                            echo "<img src=\"../gallery/head.png\" alt=\"Default Profile Photo\" class=\"user-photo\">";
                        }
                        ?>
                    </td>
                    <td class="name"><?= $exhibit['u_name']; ?></td>
                    <td class="exhibit-title"><?= $exhibit['exbt_title']; ?></td>
                    <td class="exhibit-date"><?= $exhibit['exbt_date']; ?></td>
                    <td class="exhibit-type"><?= $exhibit['exbt_type']; ?></td>
                    <td style="color: red;" class="status <?= strtolower($exhibit['exbt_status']); ?>">
                        <?= $exhibit['exbt_status']; ?>
                    </td>
                    <td>
                  
                        <?php if ($exhibit['exbt_status'] == 'Declined'): ?>
                            <form method="POST" action="restore_exhibit.php">
                                <input type="hidden" name="exbt_id" value="<?= $exhibit['exbt_id']; ?>">  
                                <input type="hidden" name="status" value="Pending"> 
                                <button type="submit" class="restoreExhibit">Restore</button>
                            </form>

                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="7">No exhibits found</td></tr>
        <?php endif; ?>
    </tbody>
</table>


<!-- Popup for Archive Action -->
<div class="popup" id="popup" style="display: none;">
    <div class="popup-content">
        <i class='bx bxs-archive'></i>
        <h2>Archive User?</h2>
        <p>Are you sure you want to archive this user? This action is reversible.</p>
        <div class="popup-btns">
            <button class="continue-btn" id="continueBtn">Continue</button>
            <button class="cancel-btn" id="cancelBtn">Cancel</button>
        </div>
    </div>
</div>

</section>
            
            <!-- SETTINGS -->
<section class="content-wrapper2" id="settings" style="display: none;">
    <div class="settings-container">
        <!-- Sidebar -->
        <div class="s_sidebar">
            <h1>Settings</h1>
            <ul>
                <li><a href="#s-profile-section" id="profile-link">Public Profile</a></li>
                <li><a href="#account-section" id="account-link">Account Settings</a></li>
            </ul>
        </div>
        
        <!-- Content -->
        <div class="s_content" id="content">
            <!-- Public Profile Section -->
            <div id="s-profile-section" class="ss_section active">
                <h3>My Profile</h3>
                <div class="s_profile">
                    <!-- Profile Image Section -->
                    <div class="s_profile-image">
                        <div class="profile-pic2"></div>
                        <input type="file" id="file-input" accept="image/*" style="display: none;">
                        <div class="s_text">
                            <h4>Upload new image</h4>
                            <p class="file-size">Max file size - 10mb</p>
                        </div>
                        <div class="image-buttons">
                            <button class="upload-btn">Upload</button>
                            <button class="remove-btn">Remove image</button>
                        </div>
                    </div>
                
                     <!-- Profile Form Section -->
                     <form action="" method="POST">
                        <label>Username<i class='bx bxs-pencil'></i></label>
                        <input type="text" name="new_username" value="<?php echo($username) ?>" class="input-field">
                        <input type="hidden" name="action" value="change_username"> 
                        <label>Role</label>
                        <input type="text" value="<?php echo($u_type) ?>" class="input-field" disabled>
                        
                        <label>Bio</label>
                        <textarea placeholder="Write a short introduction..." class="textarea-field"></textarea>
                        
                        <div class="form-buttons">
                            <button type="submit" name="changeUser" class="save-btn">Save Changes</button>
                            <button type="reset" class="clear-btn">Clear all</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <?php
            $nameParts = explode(' ', $name);
            $firstName = $nameParts[0];
            $lastName = isset($nameParts[1]) ? $nameParts[1] : ''; 
            ?>
            <!-- Account Settings Section -->
            <div id="account-section" class="ss_section hidden">
                <h3>Account Settings</h3>
                <form>
                    <!-- Name Section -->
                    <div class="s-full">
                    <h4 class="namee">Name</h4>
                        <div class="form-row">
                        <div class="form-group">
                            <p>First name</p>
                            <input type="text" value="<?php echo ($firstName); ?>" class="f-input-field">
                        </div>
                        <div class="form-group">
                            <p>Last name</p>
                            <div class="s-name">
                                <input type="text" value="<?php echo ($lastName); ?>" class="l-input-field">
                            </div>
                        </div>
                        </div>
                    </div>
                    
                    <!-- Email Address Section -->
                    <div class="form-group">
                        <div class="s-em">
                            <label>Email Address</label>
                            <div class="email">
                                <p class="email-display">Your email is <strong><?php echo ($email)?></strong></p>
                                <!-- <a href="#" class="change-link">Change</a> -->
                            </div>
                        </div>
                    </div>
            
                    <!-- Password Section -->
                    <div class="form-group">
                        <label>Password</label>
                        <div id="password-view" class="p-pass">
                            <input type="password" value="<?php echo($password)?>" class="p-input-field" disabled>
                            <a href="#" id="change-link" class="change-link">Change</a>
                        </div>
                        <div id="password-edit" class="p-hidden">
                            <div class="pass">
                                <div class="p-current">
                                    <p>Current Password</p>
                                    <input type="password" id="new-password" class="p--input-field" placeholder="Enter new password">
                                </div>
                                <div class="p-new">
                                    <p>New Password</p>
                                    <input type="password" id="current-password" class="p--input-field" placeholder="Enter current password">
                                </div>
                                <a href="#" id="hide-link" class="change-link">Hide</a>
                            </div>
                            <div class="reset">
                                <p>Can't remember your current password? <a href="#">Reset your password</a></p>
                                <button type="button" id="save-password-btn">Save password</button>
                            </div>
                        </div>    
                    </div>
            
                    <!-- Delete Account Section -->
                    <div class="delete-account">
                        <label>Delete Account</label>
                        <div class="del">
                            <p class="d-text">Would you like to delete your account? Deleting your account will remove all the content associated with it.</p>
                            <a href="#" class="delete-link">I want to delete my account</a>
                        </div>
                    </div>
                    <div class="s-popup-overlay" id="s-popup">
                        <div class="s-popup-content">
                            <div class="s-popup-header">
                                <i class='bx bx-trash'></i>
                                <h2>Delete Account?</h2>
                            </div>
                            <p>Deleting your account is irreversible and will erase all your data. This action cannot be undone.</p>
                            <div class="popup-actions">
                                <button id="s-continueButton" class="s-continue-button">Continue</button>
                                <button id="s-cancelButton" class="s-cancel-button">Cancel</button>
                            </div>
                        </div>
                    </div> 
                </form>
            </div>
        </div>
    </div>
</section>
          

        </section>
    </main>
    
    <script src="org.js"></script>
    <script>
         const exhibitType = "<?php echo $exhibit['exbt_type']; ?>";
    </script>
</body>
</html>