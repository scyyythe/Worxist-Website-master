<?php
session_start();

include("../include/connection.php"); 
include '../class/accclass.php';
include '../class/artClass.php';


if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: /login-register.php");
    die;
}
if (!isset($_SESSION['u_type']) || $_SESSION['u_type'] !== 'Admin') {
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


$user = new AccountManager($conn);
$infos = $user->getAccountInfo($u_id);
$users = $user->getUsers();


ini_set('display_errors', 1);
error_reporting(E_ALL);

//ARTWORK REQUEST
$artManager = new ArtManager($conn);
if (isset($_GET['action'], $_GET['a_id'])) {
    $action = $_GET['action'];
    $a_id = $_GET['a_id'];
    $result = $artManager->handleArtworkRequest($action, $a_id);
    header('Content-Type: application/json');  
    echo json_encode($result); 
    exit(); 
}

//ARCHIVED USER
if (isset($_POST['archive_user']) && $_POST['archive_user'] == true) {
    $accountManager = new AccountManager($conn);
    $u_id = $_POST['archive_user_id'];
    $result = $accountManager->archiveUser($u_id);
    header('Content-Type: application/json');

    if ($result) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Failed to archive user"]);
    }
    exit(); 
}


//EDIT USERNAME
$userName = new AccountManager($conn);
if (isset($_POST['changeUser'])) { 
    $new_username = trim($_POST['new_username']); 
    $u_id = $_SESSION['u_id']; 
    try {
        $userName->changeUsername($u_id, $new_username); 
        $_SESSION['username'] = $new_username;
        echo json_encode(['success' => true, 'message' => 'Username updated successfully']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    
}

?>

<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="/gallery/image/vags-logo.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    
    <main class="dashboard"> 
    <div id="custom-alert" class="alert-container">
  <div class="alert-box">
    <span id="alert-message"></span>
    <button id="close-alert" class="close-btn">OK</button>
  </div>
</div>
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">
                <img src="pics/worxist.png" alt="Logo">
            </div>
            <ul class="nav">
                <li><i class='bx bxs-dashboard'></i><a href="dashboard">Dashboard</a></li>
                <li><i class='bx bxs-user-account'></i><a href="users">Accounts</a></li>
                <li><i class='bx bxs-blanket'></i><a href="posts">Posts</a></li>
                <li><i class='bx bxs-cog'></i><a href="settings">Settings</a></li>
            </ul>
            <a href="../logout.php" class="logout"><i class='bx bxs-log-out'></i>Logout</a>
        </aside>

            <!-- Main Content -->
        <section class="main-wrapper">
            <section class="header-wrapper" id="header">
                <header class="header">
                    <div class="header-title">
                        <h1>Dashboard</h1>
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

            <!-- DASHBOARD -->
            <section class="content-wrapper1" id="dashboard">
                <div class="overview">
                    <div class="acc">
                        <div class="stat-box">
                            <h3>Accounts <span class="a-badge red"></span></h3>
                        </div>
                        <div class="a_number"></div>
                    </div>
                    <div class="request">
                        <div class="stat-box">
                            <h3>Posts Requests<span class="p-badge blue"></span></h3>
                        </div>
                        <div class="r_number"></div>
                    </div>
                </div>   

                <div class="main-content">
                    <div class="best-posts">
                        <h3>Best Performing Posts</h3>
                        <div class="post">
                            <img src="pics/a1.jpg" alt="Post Image">
                            <div class="post-info">
                                <p>Likes</p>
                                <div class="likes">
                                    <span class="heart">❤</span>
                                    <span class="count">7.2k</span>
                                </div>
                            </div>
                        </div>
                        <div class="post">
                            <img src="pics/a2.jpg" alt="Post Image">
                            <div class="post-info">
                                <p>Likes</p>
                                <div class="likes">
                                    <span class="heart">❤</span>
                                    <span class="count">6.4k</span>
                                </div>
                            </div>
                        </div>
                        <div class="post">
                            <img src="pics/a3.jpg" alt="Post Image">
                            <div class="post-info">
                                <p>Likes</p>
                                <div class="likes">
                                    <span class="heart">❤</span>
                                    <span class="count">3.5k</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="post-stats">
                        <h3>Post Stats</h3>
                        <canvas id="postStatsChart"></canvas>
                    </div>
                </div>

                <div class="top-artists">
                    <h3>Top 10 Artists</h3>
                    <ul class="artist-list">
                        <li>
                            <img src="pics/1672369246156.jpg" alt="Artist Image">
                            <div class="artist-info">
                                <span class="artist-name">Jera Anderson</span>
                                <span class="artist-handle">@jeraander</span>
                            </div>
                            <span class="artist-percentage">35%</span>
                        </li>
                        <li>
                            <img src="pics/mona.jpg" alt="Artist Image">
                            <div class="artist-info">
                                <span class="artist-name">Jandeb Laplap</span>
                                <span class="artist-handle">@jandebdab</span>
                            </div>
                            <span class="artist-percentage">18%</span>
                        </li>
                        <li>
                            <img src="pics/SHREK.jpg" alt="Artist Image">
                            <div class="artist-info">
                                <span class="artist-name">Jimmy Boy</span>
                                <span class="artist-handle">@jimmyboy</span>
                            </div>
                            <span class="artist-percentage">25%</span>
                        </li>
                        <li>
                            <img src="pics/1672369246156.jpg" alt="Artist Image">
                            <div class="artist-info">
                                <span class="artist-name">Jera Anderson</span>
                                <span class="artist-handle">@jeraander</span>
                            </div>
                            <span class="artist-percentage">35%</span>
                        </li>
                        <li>
                            <img src="pics/mona.jpg" alt="Artist Image">
                            <div class="artist-info">
                                <span class="artist-name">Jandeb Laplap</span>
                                <span class="artist-handle">@jandebdab</span>
                            </div>
                            <span class="artist-percentage">18%</span>
                        </li>
                        <li>
                            <img src="pics/SHREK.jpg" alt="Artist Image">
                            <div class="artist-info">
                                <span class="artist-name">Jimmy Boy</span>
                                <span class="artist-handle">@jimmyboy</span>
                            </div>
                            <span class="artist-percentage">25%</span>
                        </li>
                    </ul>
                    <a href="#" class="view-more">View More</a>
                </div>


                <div class="activity">
                    <h3>Activity</h3>
                    <canvas id="activityChart"></canvas>
                </div>
            </section>

            <!-- MANAGE USERS -->
            <section class="content-wrapper2" id="users" >
                <div class="header-controls">
                    <h2>Total Users <span class="total-users"> 219</span></h2>
                    <div class="table-controls">
                      <input type="text" class="search-bar" placeholder="Search">
                      <i class='bx bx-filter'><p class="filter-btn">Filter</p></i>
                    </div>
                </div>

            <!-- Table -->
<table class="user-table">
    <thead>
        <tr>
            <th>Photo</th>
            <th>Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
                <tr data-id="<?= $user['u_id']; ?>">
                    <td>
                        <?php
                        $imagePath = '../profile_pics/' . $user['profile'];  
                        if (file_exists($imagePath) && !empty($user['profile'])) {
                            echo "<img src=\"$imagePath\" alt=\"Profile Photo\" class=\"user-photo\">";
                        } else {
                            echo "<img src=\"../gallery/head.png\" alt=\"Default Profile Photo\" class=\"user-photo\">";
                        }
                        ?>
                    </td>
                    <td class="name"><?= $user['u_name']; ?></td>
                    <td class="mobile"><?= $user['username']; ?></td>
                    <td class="email"><?= $user['email']; ?></td>
                    <td><span class="status <?= strtolower($user['u_status']); ?>"><?= $user['u_status']; ?></span></td>

                    <td>
                        <!-- Archive Form -->
                        <form action="" method="POST" class="archive-form" id="archiveForm_<?= $user['u_id']; ?>">
                            <input type="hidden" name="archive_user_id" value="<?= $user['u_id']; ?>">
                            <button type="button" class="archive-btn" onclick="openPopup(<?= $user['u_id']; ?>)">
                                <i class='bx bx-archive-in archive-icon'></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6">No users found</td></tr>
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

            <!-- POSTS REQUESTS -->
            <section class="content-wrapper3" id="posts">
    <div class="posts-wrapper">
        <?php
        $artManage = new artManager($conn);
        $pendingRequests = $artManage->getPendingRequests();

        foreach ($pendingRequests as $request) {
            $profilePath = '../profile_pics/' . $request['artist_profile'];
            if (file_exists($profilePath) && !empty($request['artist_profile'])) {
                $profileImage = $profilePath;
            } else {
                $profileImage = '../gallery/head.png';
            }

            $imagePath = '../' . $request['file'];
            if (file_exists($imagePath) && !empty($request['file'])) {
                $imageToShow = $imagePath;
            } else {
                $imageToShow = '../gallery/head.png';
            }

            echo '
                <div class="card" data-id="' . $request['a_id'] . '">
                    <img src="' . $imageToShow . '" class="banner-image" alt="Artwork">
                    <div class="card-content">
                        <p class="art-title">' . $request['title'] . '</p>
                        <div class="profile">
                            <img src="' . $profileImage . '" alt="Profile Picture" class="profile-picture">
                            <div class="profile-info">
                                <h3 class="name">' . $request['artist_name'] . '</h3>
                            </div>
                        </div>
                        <div class="actions">
                            <button class="btn approve-btn" data-id="' . $request['a_id'] . '">Approve</button>
                            <button class="btn decline-btn" data-id="' . $request['a_id'] . '">Decline</button>
                        </div>
                    </div>
                </div>';

            
        }
        ?>
    </div>

    <!-- Modal -->
    <div class="modal" id="image-modal">
        <button class="nav-btn left-btn">&lt;</button>
        <button class="nav-btn right-btn">&gt;</button>
        <div class="modal-content">
            <img src="" class="modal-image">
        </div>
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


            <!-- SETTINGS -->
             <section class="content-wrapper4" id="settings">
                <div class="settings-container">
                    <!-- Sidebar -->
                    <div class="s_sidebar">
                        <h1>Settings</h1>
                        <ul>
                            <li><a href="#s-profile-section" id="profile-link">Public Profile</a></li>
                            <li><a href="#account-section" id="account-link">Account Settings</a></li>
                            <li><a href="#notifications-section" id="notifications-link">Notifications</a></li>
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
                                        <button class="upload-btn" name="uploadProfilePic">Upload</button>
                                        <button class="remove-btn" style="display: none;">Remove image</button>
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
                        
                    
                        <!-- Notifications Section -->
                        <div id="notifications-section" class="ss_section hidden">
                            <h3>Notifications</h3>
                            <div class="s_notifications">
                                <!-- Enable Desktop Notification -->
                                <div class="notification-group">
                                    <div class="notification-text">
                                        <strong>Enable Desktop Notification</strong>
                                        <p>Receive notification for all messages, updates, and documents</p>
                                    </div>
                                    <label class="switch">
                                        <input type="checkbox" checked>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                        
                                <!-- Enable Unread Notification -->
                                <div class="notification-group-n">
                                    <div class="notification-text">
                                        <strong>Enable Unread Notification</strong>
                                        <p>Shows a red badge when you have an unread message</p>
                                    </div>
                                    <label class="switch">
                                        <input type="checkbox" checked>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                        
                                <!-- Email Notifications -->
                                <h3 class="n_email">Email Notifications</h3>
                        
                                <!-- Communication Emails -->
                                <div class="notification-group">
                                    <div class="notification-text">
                                        <strong>Communication Emails</strong>
                                        <p>Receive emails for messages, contracts, and documents</p>
                                    </div>
                                    <label class="switch">
                                        <input type="checkbox" checked>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                        
                                <!-- Announcements & Updates -->
                                <div class="notification-group">
                                    <div class="notification-text">
                                        <strong>Announcements & Updates</strong>
                                        <p>Receive emails about product updates, improvements, etc.</p>
                                    </div>
                                    <label class="switch">
                                        <input type="checkbox" checked>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
             </section>

        </section>

    </main>

    <script src="script.js"></script>
    
</body>
</html>
