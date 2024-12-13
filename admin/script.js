// SIDEBAR NAVIGATION
document.addEventListener('DOMContentLoaded', function() {
  // Sidebar links
  const dashboardLink = document.querySelector('a[href="dashboard"]');
  const usersLink = document.querySelector('a[href="users"]');
  const postsLink = document.querySelector('a[href="posts"]');
  const settingsLink = document.querySelector('a[href="settings"]');
  const declineLink = document.querySelector('a[href="decline"]');

  // Section containers
  const dashboardSection = document.querySelector('.content-wrapper1');
  const userSection = document.querySelector('.content-wrapper2');
  const postsSection = document.querySelector('.post-section');
  const settingsSection = document.querySelector('.content-wrapper4');
  const declineSection = document.querySelector('.decline-section');
  const topSection = document.querySelector('.header-wrapper');
  const acceptAll = document.querySelector('.accept-all');
  const postWrap = document.querySelector('.post-wrapper');
  // Header title
  const headerTitle = document.querySelector('.header-title');

  // Hide all sections initially except for the dashboard
  userSection.style.display = 'none';
  postsSection.style.display = 'none';
  settingsSection.style.display = 'none';
  declineSection.style.display = 'none';

  topSection.style.display = 'flex';

  // Function to update the header title based on the section
  function updateHeaderTitle(section) {
    if (section === userSection) {
      headerTitle.innerHTML = `
        <h1> Accounts</h1>
        <span class="des">Manage user accounts</span>
      `;
    }else if (section === postsSection) {
      headerTitle.innerHTML = `
        <h1> Posts Requests</h1>
        <span class="des">Review users' posts</span>
      `;
    } else if (section === settingsSection) {
      headerTitle.innerHTML = `
        <h1> Settings</h1>
        <span class="des">Adjust your preferences</span>
      `;
    }else if (section === dashboardSection) {
      headerTitle.innerHTML = `
        <h1> Dashboard</h1>
        <span class="date" id="current-date"></span>
      `;
      document.getElementById("current-date").innerText = formatDate();
    }else if (section === declineSection) {
      headerTitle.innerHTML = `
        <h1> Declined Posts</h1>
        <span class="date" id="current-date"></span>
      `;
      document.getElementById("current-date").innerText = formatDate();
    }
  }

  // Dashboard section
  dashboardLink.addEventListener('click', function(e) {
    e.preventDefault();
    dashboardSection.style.display = 'block';
    userSection.style.display = 'none';
    postsSection.style.display = 'none';
    settingsSection.style.display = 'none';
    topSection.style.display = 'flex';
    declineSection.style.display = 'none';
    updateHeaderTitle(dashboardSection);
  });

  // Users Management section
  usersLink.addEventListener('click', function(e) {
    e.preventDefault();
    dashboardSection.style.display = 'none';
    userSection.style.display = 'block';
    postsSection.style.display = 'none';
    settingsSection.style.display = 'none';
    topSection.style.display = 'flex';
    declineSection.style.display = 'none';
    updateHeaderTitle(userSection);
  });

  // Posts Requests section
  postsLink.addEventListener('click', function(e) {
    e.preventDefault();
    dashboardSection.style.display = 'none';
    userSection.style.display = 'none';
    postsSection.style.display = 'block';
    settingsSection.style.display = 'none';
    topSection.style.display = 'flex';
    declineSection.style.display = 'none';
    updateHeaderTitle(postsSection);
  });

  declineLink.addEventListener('click', function(e) {
    e.preventDefault();
    dashboardSection.style.display = 'none';
    userSection.style.display = 'none';
    postsSection.style.display = 'block';
    settingsSection.style.display = 'none';
    topSection.style.display = 'block';
    declineSection.style.display = 'flex';
    acceptAll.style.display = 'none';

    updateHeaderTitle(declineSection);
  });

  // Settings section
  settingsLink.addEventListener('click', function(e) {
    e.preventDefault();
    dashboardSection.style.display = 'none';
    userSection.style.display = 'none';
    postsSection.style.display = 'none';
    settingsSection.style.display = 'block';
    topSection.style.display = 'flex';
    declineSection.style.display = 'none';
    updateHeaderTitle(settingsSection);
  });
});

  // Get modal
    var modal = document.getElementById("imageModal");
    var modalImg = document.getElementById("modalImage");
    var captionText = document.getElementById("caption");

    // Get all image links
    var imageLinks = document.querySelectorAll(".image-link");

    imageLinks.forEach(function(link) {
        link.addEventListener("click", function(e) {
            e.preventDefault();
            var imageSrc = link.getAttribute("data-image");
            modal.style.display = "block";
            modalImg.src = imageSrc;
            captionText.innerHTML = link.querySelector("img").alt;
        });
    });

    // Close modal when clicking on the close button
    var closeModal = document.getElementsByClassName("close")[0];
    closeModal.onclick = function() {
        modal.style.display = "none";
    }

    // Open the popup when the "Restore" button is clicked
function openRestorePopup(postId) {
  const popup = document.getElementById('restorePopup');
  popup.style.display = 'block';
  
  document.getElementById('restoreContinueBtn').setAttribute('data-post-id', postId);
}

document.getElementById('restoreCancelBtn').addEventListener('click', function() {
  const popup = document.getElementById('restorePopup');
  popup.style.display = 'none';
});


document.getElementById('restoreContinueBtn').addEventListener('click', function(event) {
  event.preventDefault();  

  const postId = this.getAttribute('data-post-id');
  const form = document.getElementById('restoreForm_' + postId);
  
  const formData = new FormData(form);

  fetch('', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {

    showCustomAlert(data.message);
  
    const popup = document.getElementById('restorePopup');
    popup.style.display = 'none';
  })
  .catch(error => {

    showCustomAlert('An error occurred while restoring the post.');
  });
});


// Function to format and display the current date in dashboard
function formatDate() {
    let today = new Date();

    let days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    let months = ['Jan.', 'Feb.', 'Mar.', 'Apr.', 'May.', 'Jun.', 'Jul.', 'Aug.', 'Sept.', 'Oct.', 'Nov.', 'Dec.'];

    let dayName = days[today.getDay()]; 
    let day = today.getDate(); 
    let month = months[today.getMonth()]; 
    let year = today.getFullYear();

    return dayName + ", " + day + " " + month + " " + year;
}

document.getElementById("current-date").innerText = formatDate();



// --- Post Stats Chart ---

// Get the canvas for the Post Stats Chart
let postStatsCanvas = document.getElementById('postStatsChart').getContext('2d');

// Bar chart
let postStatsChart = new Chart(postStatsCanvas, {
    type: 'bar', // Chart type
    data: {
        labels: ['Weekly', 'Monthly', 'Yearly'], 
        datasets: [
            {
                label: 'Saved',
                data: [5, 10, 15],
                backgroundColor: '#d68b8b', 
                borderRadius: 20, 
                barThickness: 40 
            },
            {
                label: 'Likes', 
                data: [8, 12, 18],
                backgroundColor: '#8b0d0d',
                borderRadius: 20,
                barThickness: 40
            }
        ]
    },
    options: {
        responsive: true, // Make chart responsive
        maintainAspectRatio: false, // Disable fixed aspect ratio
        plugins: {
            legend: {
                position: 'top', // Legend position
                labels: {
                    boxWidth: 25,
                    font: {
                        size: 14,
                        family: 'Poppins', 
                    },
                    color: '#000' 
                }
            }
        },
        scales: {
            x: { // X-axis settings
                grid: {
                    display: false // Remove grid lines
                },
                ticks: {
                    font: {
                        size: 14,
                        family: 'Poppins'
                    },
                    color: '#000'
                }
            },
            y: { // Y-axis settings
                beginAtZero: true, // Start from 0
                ticks: {
                    stepSize: 5,
                    font: {
                        size: 14,
                        family: 'Poppins',
                        weight: 'bold'
                    },
                    color: '#000'
                }
            }
        }
    }
});



// --- Activity Chart ---
document.addEventListener('DOMContentLoaded', function () {
  // Get the canvas for the Activity Chart
  let activityCanvas = document.getElementById('activityChart').getContext('2d');

  // Adjust canvas resolution for high-DPI displays
  let dpr = window.devicePixelRatio || 1; // Device Pixel Ratio
  activityCanvas.canvas.width = activityCanvas.canvas.clientWidth * dpr;
  activityCanvas.canvas.height = activityCanvas.canvas.clientHeight * dpr;
  activityCanvas.scale(dpr, dpr);

  // Line chart with dynamic data for all users
  let activityChart = new Chart(activityCanvas, {
      type: 'line', // Chart type
      data: {
          labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'], 
          datasets: [
              {
                  label: 'Posts', 
                  data: [posts, posts + 1, posts + 2, posts + 3, posts + 4], // Dynamic data for posts
                  borderColor: '#a20d0d', 
                  backgroundColor: '#a20d0d', 
                  fill: false, 
                  borderWidth: 2
              },
              {
                  label: 'Requests', 
                  data: [requests, requests + 1, requests + 2, requests + 3, requests + 4], // Dynamic data for requests
                  borderColor: '#ff7272', 
                  backgroundColor: '#ff7272', 
                  fill: false, 
                  borderWidth: 2
              },
              {
                  label: 'Accepted Exhibitions', 
                  data: [acceptedExhibitions, acceptedExhibitions + 1, acceptedExhibitions + 2, acceptedExhibitions + 3, acceptedExhibitions + 4], // Dynamic data for accepted exhibitions
                  borderColor: '#ed1c24', 
                  backgroundColor: '#ed1c24', 
                  fill: false, 
                  borderWidth: 2
              }
          ]
      },
      options: {
          responsive: true, 
          maintainAspectRatio: false, 
          scales: {
              y: {
                  beginAtZero: true, 
                  ticks: {
                      font: {
                          size: 14, 
                          family: 'Poppins', 
                          weight: 'bold'
                      }
                  }
              },
              x: {
                  ticks: {
                      font: {
                          size: 14, 
                          family: 'Poppins', 
                      }
                  }
              }
          },
          plugins: {
              legend: {
                  labels: {
                      font: {
                          size: 14, 
                          family: 'Poppins', 
                      }
                  }
              }
          }
      }
  });
});


//POP UP ARCHVED USER
document.addEventListener('DOMContentLoaded', function () {
  const popup = document.getElementById('popup');
  const cancelBtn = document.getElementById('cancelBtn');
  const continueBtn = document.getElementById('continueBtn');
  let currentUserId = null;

  window.openPopup = function (userId) {
      currentUserId = userId;
      console.log('User ID to archive:', currentUserId); // Add this line to debug
      popup.style.display = 'flex';
  };

  // Cancel the action and close the popup
  cancelBtn.addEventListener('click', function () {
      popup.style.display = 'none';
  });

  continueBtn.addEventListener('click', function () {
    if (currentUserId) {
        const formData = new FormData();
        formData.append('archive_user_id', currentUserId);
        formData.append('archive_user', true);

        fetch('admin.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            console.log('Response status:', response.status); 
            return response.text(); 
        })
        .then(text => {
            console.log('Response text:', text); 
            try {
                const data = JSON.parse(text);  
                if (data.success) {
                    showCustomAlert('Successfully Archived');
                    
                    const row = document.querySelector(`tr[data-id="${currentUserId}"]`);
                    if (row) {
                        row.remove(); 
                    }
                    popup.style.display = 'none';
                } else {
                    showCustomAlert('Failed to archive user: ' + (data.error || 'Unknown error'));
                }
            } catch (error) {
                console.error('Error parsing JSON:', error);
                showCustomAlert('Failed to parse server response. Response content: ' + text);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showCustomAlert('An error occurred while archiving the user.');
        });
    }
});

});



//FILTER IN SORTING USER NAMES
document.addEventListener('DOMContentLoaded', function () {
    const filterButton = document.querySelector('.bx-filter');
    const tableBody = document.querySelector('.user-table tbody');
  
    filterButton.addEventListener('click', function () {
        const rows = tableBody.querySelectorAll('tr');
        
        // Array to store name and corresponding row
        const rowsArray = [];
        for (let i = 0; i < rows.length; i++) {

          const nameCell = rows[i].querySelector('.name');
          const nameText = nameCell.textContent.trim();
        
          // Push the name and the corresponding row to the array
          rowsArray.push({ name: nameText, row: rows[i] });
        }
      
        // Alphabetical order
        for (let i = 0; i < rowsArray.length; i++) {
          for (let j = 0; j < rowsArray.length - 1; j++) {
            if (rowsArray[j].name > rowsArray[j + 1].name) {
              // Swap the elements
              const temp = rowsArray[j];
              rowsArray[j] = rowsArray[j + 1];
              rowsArray[j + 1] = temp;
            }
          }
        }
      
        tableBody.innerHTML = '';
      
        for (let i = 0; i < rowsArray.length; i++) {
          tableBody.appendChild(rowsArray[i].row);
        }
    });
});
  

//SEARCH BAR FOR USERS
document.addEventListener('DOMContentLoaded', () => {
    const searchBar = document.querySelector('.search-bar');
    const tableRows = document.querySelectorAll('.user-table tbody tr');
  
    searchBar.addEventListener('input', () => {
        const query = searchBar.value.toLowerCase();
        
        // Loop sa tanan table rows
        for (let i = 0; i < tableRows.length; i++) {
            const nameCell = tableRows[i].querySelector('.name');
            const name = nameCell.textContent.toLowerCase();
            
            if (query === '' || name.includes(query)) {
              tableRows[i].style.display = '';
            } else {
              tableRows[i].style.display = 'none';
            }
        }
    });
});
  

//TOTAL NO. AND CURRENT NO. IN THE DASHBOARD (ACCOUNTS & POSTS REQUESTS)
document.addEventListener("DOMContentLoaded", function() {
  const tableRows = document.querySelectorAll('.user-table tbody tr');
  
  let rowCount = 0;

  for (let i = 0; i < tableRows.length; i++) {
      const cells = tableRows[i].querySelectorAll('td');
      
      let hasContent = false;
      
      for (let j = 0; j < cells.length; j++) {
          if (cells[j].textContent.trim() !== "" || cells[j].querySelector('img') !== null) {
              hasContent = true;
              break;  
          }
      }
      
      if (hasContent) {
          rowCount++;
      }
  }

  const totalUsersElement = document.querySelector('.total-users');
  const aNumberElement = document.querySelector('.a_number');
  const aBadgeElement = document.querySelector('.a-badge');

  if (totalUsersElement) {
      totalUsersElement.textContent = rowCount || 0;
  }

  if (aNumberElement) {
      aNumberElement.textContent = rowCount || 0;
  }

  if (aBadgeElement) {
      aBadgeElement.textContent = 0;
  }

  const rNumberElement = document.querySelector('.r_number');
  const pBadgeElement = document.querySelector('.p-badge');

  const today = new Date().toDateString();

  const lastUpdatedDate = localStorage.getItem('lastUpdatedDate');
  if (lastUpdatedDate !== today) {
      localStorage.setItem('dailyCardCount', 0);
      localStorage.setItem('lastUpdatedDate', today);
  }

  // Update the counts
  function updateCardCounts() {
      const cards = document.querySelectorAll('.posts-wrapper .card');
      
      rNumberElement.textContent = cards.length || 0;

      let dailyCardCount = parseInt(localStorage.getItem('dailyCardCount')) || 0;

      const trackedCardCount = parseInt(localStorage.getItem('trackedCardCount')) || 0;

      if (cards.length > trackedCardCount) {
          dailyCardCount += cards.length - trackedCardCount;
          localStorage.setItem('dailyCardCount', dailyCardCount);
          localStorage.setItem('trackedCardCount', cards.length);
      }

      // Update the badge
      pBadgeElement.textContent = dailyCardCount || 0;
  }

  updateCardCounts();

  // New card additions 
  const postsWrapper = document.querySelector('.posts-wrapper');
  const observer = new MutationObserver(updateCardCounts);

  if (postsWrapper) {
      observer.observe(postsWrapper, { childList: true });
  }

  // Display 0 if no rows or cards exist
  if (tableRows.length === 0) {
      aBadgeElement.textContent = 0;
  }

  const cards = document.querySelectorAll('.posts-wrapper .card');
  if (cards.length === 0) {
      pBadgeElement.textContent = 0;
      rNumberElement.textContent = 0;
  }
});


//CARD MODAL
document.addEventListener("DOMContentLoaded", function () {
    const bannerImages = document.querySelectorAll(".banner-image");
    const modal = document.getElementById("image-modal");
    const modalImage = modal.querySelector(".modal-image");
    const leftBtn = modal.querySelector(".left-btn");
    const rightBtn = modal.querySelector(".right-btn");
    let imageList = [];
    let currentIndex = 0;
  
    for (let i = 0; i < bannerImages.length; i++) {
      bannerImages[i].addEventListener("click", function () {
        // Collect all images in the same card
        const parentCard = bannerImages[i].closest(".card");
        const imagesInCard = parentCard.querySelectorAll(".banner-image");
  
        imageList = [];
        for (let j = 0; j < imagesInCard.length; j++) {
          imageList.push(imagesInCard[j].src);
        }
  
        currentIndex = imageList.indexOf(bannerImages[i].src);
  
        showImage();
        updateNavButtons();
        modal.style.display = "flex";
      });
    }
  
    leftBtn.addEventListener("click", function () {
      if (currentIndex > 0) {
        currentIndex--;
        showImage();
        updateNavButtons();
      }
    });
  
    rightBtn.addEventListener("click", function () {
      if (currentIndex < imageList.length - 1) {
        currentIndex++;
        showImage();
        updateNavButtons();
      }
    });
  
    modal.addEventListener("click", function (e) {
      if (e.target === modal) {
        modal.style.display = "none";
      }
    });
  
    function showImage() {
      modalImage.src = imageList[currentIndex];
    }
  
    function updateNavButtons() {
      if (imageList.length <= 1) {
        // Hide both buttons if there's only one image
        leftBtn.style.display = "none";
        rightBtn.style.display = "none";
      } else {
        // Show/hide left button
        if (currentIndex > 0) {
          leftBtn.style.display = "block";
        } else {
          leftBtn.style.display = "none";
        }
  
        // Show/hide right button
        if (currentIndex < imageList.length - 1) {
          rightBtn.style.display = "block";
        } else {
          rightBtn.style.display = "none";
        }
      }
    }
});
  

// POPUP MSG FOR APPROVE & DECLINE
const popupContainer = document.getElementById('p-popup-container');
const popupMessage = document.getElementById('p-popup-message');
const confirmButton = document.getElementById('p-confirm-btn');
const cancelButton = document.getElementById('p-cancel-btn');

const approveButtons = document.querySelectorAll('.approve-btn');
const declineButtons = document.querySelectorAll('.decline-btn');

let selectedCard = null;
let selectedAction = null;
let selectedAId = null;

approveButtons.forEach(button => {
  button.addEventListener('click', function() {
    selectedCard = this.closest('.card'); 
    selectedAction = 'approve';
    selectedAId = this.getAttribute('data-id');
    popupMessage.textContent = 'Are you sure you want to approve this post?';
    popupContainer.style.display = 'flex';
    console.log(selectedCard); 
  });
});

declineButtons.forEach(button => {
  button.addEventListener('click', function() {
    selectedCard = this.closest('.card'); 
    selectedAction = 'decline';
    selectedAId = this.getAttribute('data-id');
    popupMessage.textContent = 'Declining this post will ban the user from posting an artwork for 7 days. Are you sure?';
    popupContainer.style.display = 'flex';
    console.log(selectedCard);  
  });
});

confirmButton.addEventListener('click', async function() {
  if (selectedAction === 'approve' || selectedAction === 'decline') {
    try {
      const response = await fetch(`admin.php?action=${selectedAction}&a_id=${selectedAId}`, {
        method: 'GET',
      });

      const textResponse = await response.text();  

      if (textResponse.trim().startsWith("{")) {
        const data = JSON.parse(textResponse);  
        console.log('Parsed response:', data);  

        if (data.success) {
          showCustomAlert(data.message);  
          if (selectedCard) {
            selectedCard.remove();  
          }
          popupContainer.style.display = 'none';
        } else {
          showCustomAlert(data.message);  
        }
      } else {
        showCustomAlert('Invalid response from server.');
      }
    } catch (error) {
      console.error('Error occurred:', error); 
      showCustomAlert('Error occurred while processing your request.'); 
    }
  }
  popupContainer.style.display = 'none';  
});

// Cancel button click
cancelButton.addEventListener('click', function() {
  popupContainer.style.display = 'none';
});

// approve all the request
document.getElementById('accept-all-btn').addEventListener('click', function() {
  fetch('admin.php', {
      method: 'POST',
      body: new URLSearchParams({
          action: 'approve_all' 
      })
  })
  .then(response => response.text())
  .then(message => {
      showCustomAlert(message);
  })
  .catch(error => {
      console.error('Error:', error);
      showCustomAlert('An error occurred.');
  });
});


//fucnton alert message
function showCustomAlert(message) {
  // Get the alert elements
  const alertContainer = document.getElementById('custom-alert');
  const alertMessage = document.getElementById('alert-message');
  const closeButton = document.getElementById('close-alert');


  alertMessage.textContent = message;
  alertContainer.style.display = 'flex';

  closeButton.addEventListener('click', function() {
    alertContainer.style.display = 'none'; 
  });
}

// SETTINGS
document.getElementById("profile-link").addEventListener("click", function() {
showSection('s-profile-section');
});

document.getElementById("account-link").addEventListener("click", function() {
showSection('account-section');
});

document.getElementById("notifications-link").addEventListener("click", function() {
showSection('notifications-section');
});

function showSection(sectionId) {
let sections = document.querySelectorAll('.ss_section');
sections.forEach(section => {
    section.classList.add('hidden');
});

document.getElementById(sectionId).classList.remove('hidden');
document.getElementById(sectionId).classList.add('active');
}

// CHANGE & HIDE PASSWORD

// Show password edit view when 'Change' is clicked
document.getElementById('change-link').addEventListener('click', function (e) {
  e.preventDefault();
  document.getElementById('password-view').style.display = 'none';  // Hide the "Change" view
  document.getElementById('password-edit').style.display = 'block'; // Show the "Edit" view
});

// Hide password edit view when 'Hide' is clicked
document.getElementById('hide-link').addEventListener('click', function (e) {
  e.preventDefault();
  document.getElementById('password-view').style.display = 'flex';  // Show the "Change" view
  document.getElementById('password-edit').style.display = 'none'; // Hide the "Edit" view
});

// Handle save password functionality
document.getElementById('save-password-btn').addEventListener('click', function () {
  var currentPassword = document.getElementById('current-password').value;
  var newPassword = document.getElementById('new-password').value;

  // Validate the inputs
  if (!currentPassword || !newPassword) {
      showCustomAlert('Please fill in both fields.');
      return;
  }

  if (newPassword.length < 8) {
      showCustomAlert('New password must be at least 8 characters long.');
      return;
  }

  if (!/[A-Z]/.test(newPassword)) {
      showCustomAlert('New password must contain at least one uppercase letter.');
      return;
  }

  if (!/[a-z]/.test(newPassword)) {
      showCustomAlert('New password must contain at least one lowercase letter.');
      return;
  }

  if (!/[0-9]/.test(newPassword)) {
      showCustomAlert('New password must contain at least one number.');
      return;
  }

  if (!/[!@#$%^&*(),.?":{}|<>]/.test(newPassword)) {
      showCustomAlert('New password must contain at least one special character.');
      return;
  }

  fetch('../class/updatePassword.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({
        currentPassword: currentPassword,
        newPassword: newPassword
    })
})
.then(response => response.text())  // Get the raw response text for debugging
.then(text => {
    try {
        const data = JSON.parse(text);  // Try parsing the response as JSON
        if (data.success) {
            showCustomAlert('Password successfully changed!');
            document.getElementById('password-view').style.display = 'flex';
            document.getElementById('password-edit').style.display = 'none';
        } else {
            showCustomAlert('Error: ' + (data.error || 'An unknown error occurred.'));
        }
    } catch (error) {
        console.error('Failed to parse JSON:', error);
        showCustomAlert('An error occurred while updating the password. The response was not valid JSON.');
    }
})
.catch(error => {
    console.error('Error:', error);
    showCustomAlert('An error occurred while updating the password.');
});

});


//DELETE ACC POP-UP
document.addEventListener("DOMContentLoaded", function () {
const deleteLink = document.querySelector(".delete-link");
const popup = document.getElementById("s-popup");
const continueButton = document.getElementById("s-continueButton");
const cancelButton = document.getElementById("s-cancelButton");

// Show the popup when the delete link is clicked
deleteLink.addEventListener("click", function (event) {
    event.preventDefault();
    popup.style.display = "flex";
});

// Handle the Continue button click (delete action)
continueButton.addEventListener("click", function () {
    popup.style.display = "none";
    alert("Account deleted successfully."); // Replace with actual delete function if needed
});

// Handle the Cancel button click (close popup)
cancelButton.addEventListener("click", function () {
    popup.style.display = "none";
});
});


//USER DROPDOWN
document.addEventListener("DOMContentLoaded", function () {
  const userImg = document.querySelector(".profile-pic1");
  const dropdown = document.querySelector(".dropdown");

  userImg.addEventListener("click", function () {
      dropdown.classList.toggle("active");
  });

  // Close dropdown if clicking outside of it
  document.addEventListener("click", function (event) {
      if (!userImg.contains(event.target) && !dropdown.contains(event.target)) {
          dropdown.classList.remove("active");
      }
  });
});


//UPLOAD PROFILE PIC
const uploadButton = document.querySelector('.upload-btn');
const removeButton = document.querySelector('.remove-btn');
const profilePics = document.querySelectorAll('.profile-pic1, .profile-pic2');
const fileInput = document.getElementById('file-input');
const uploadForm = document.getElementById('uploadForm'); // Assuming your form has an ID

fileInput.type = 'file';
fileInput.accept = 'image/*';


uploadButton.addEventListener('click', function () {
  fileInput.click();
});


fileInput.addEventListener('change', function () {
  if (fileInput.files && fileInput.files[0]) {
    const file = fileInput.files[0];
    const reader = new FileReader();

    reader.onload = function (e) {
      for (let i = 0; i < profilePics.length; i++) {
        profilePics[i].style.backgroundImage = `url('${e.target.result}')`;
        profilePics[i].style.backgroundSize = 'cover';
        profilePics[i].style.backgroundPosition = 'center';
      }
      checkImageDisplay(); 
      uploadForm.submit();
    };

    reader.readAsDataURL(file);
  }
});

// Function to check if any profile picture has an image
function checkImageDisplay() {
  let hasImage = false;
  for (let i = 0; i < profilePics.length; i++) {
    if (profilePics[i].style.backgroundImage) {
      hasImage = true;
      break;
    }
  }
  if (hasImage) {
    removeButton.style.display = 'block'; 
  } else {
    removeButton.style.display = 'none'; 
  }
}

removeButton.addEventListener('click', function () {
  for (let i = 0; i < profilePics.length; i++) {
    profilePics[i].style.backgroundImage = '';
  }
  checkImageDisplay(); 
});


//SETTINGS-PROFILE FORM
const pencilIcon = document.querySelector('.bxs-pencil');
const formButtons = document.querySelector('.form-buttons');
const inputField = document.querySelector('.input-field');
const textareaField = document.querySelector('.textarea-field');
const saveButton = document.querySelector('.save-btn');
const clearButton = document.querySelector('.clear-btn');

formButtons.style.display = 'none';
inputField.disabled = true;
textareaField.disabled = true;

const formElements = [inputField, textareaField, formButtons];

// When pencil icon is clicked, enable the fields and show the save button
pencilIcon.addEventListener('click', function() {
    for (let i = 0; i < formElements.length; i++) {
        if (formElements[i] === formButtons) {
            if (formButtons.style.display === 'none') {
                formButtons.style.display = 'block'; 
                inputField.disabled = false;
                textareaField.disabled = false; 
            } else {
                formButtons.style.display = 'none'; 
                inputField.disabled = true; 
                textareaField.disabled = true; 
            }
        }
    }
});


saveButton.addEventListener('click', function(event) {
    document.querySelector('form').submit(); 
});


clearButton.addEventListener('click', function(event) {
    event.preventDefault(); 
    inputField.value = '';
    textareaField.value = '';
});
