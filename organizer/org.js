document.addEventListener('DOMContentLoaded', function() {
  // Sidebar links
  const exhibitLink = document.querySelector('.exhibitLink');
  const settingsLink = document.querySelector('.settingLink');

  // Section containers
  const exhibitsSection = document.getElementById('exhibits');
  const settingsSection = document.getElementById('settings');
  const topSection = document.querySelector('.header-wrapper');


  settingsSection.style.display = 'none';
  exhibitsSection.style.display = 'flex';

  // Exhibits section
  exhibitLink.addEventListener('click', function(e) {
      e.preventDefault();
      exhibitsSection.style.display = 'block';
      settingsSection.style.display = 'none';
      topSection.style.display = 'flex';
  });

  // Settings section
  settingsLink.addEventListener('click', function(e) {
      e.preventDefault();
      exhibitsSection.style.display = 'none';
      settingsSection.style.display = 'block';
      topSection.style.display = 'none';
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




// NAVIGATION BETWEEN .posts-wrapper AND .panel
document.addEventListener("DOMContentLoaded", function () {
  const cards = document.querySelectorAll(".card");
  const panel = document.getElementById("panel"); 
  const postsWrapper = document.querySelector(".posts-wrapper"); 
  const headerWrapper = document.querySelector(".header-wrapper");
  const backButton = document.querySelector(".bx-chevron-left");

  // Solo and Collaborator Sections
  const soloRequest = document.getElementById("soloRequest");
  const collabRequest = document.getElementById("collabRequest");

  // Fetch and display exhibit data when a card is clicked
  for (let i = 0; i < cards.length; i++) {
    cards[i].addEventListener("click", function () {
      const exhibitId = cards[i].getAttribute("data-exhibit-id");
      console.log("Exhibit ID:", exhibitId);

      // Fetch exhibit data
      fetchExhibitData(exhibitId).then(exhibit => {
        if (exhibit.error) {
          console.error('Exhibit not found');
          alert('Exhibit not found');
          return;
        }

    // Populate panel with fetched exhibit data
document.getElementById("exhibit-date").innerText = exhibit.exhibit.exbt_date;
document.getElementById("exhibit-title").innerText = exhibit.exhibit.exbt_title;
document.getElementById("exhibit-description").innerText = exhibit.exhibit.exbt_descrip;

// Solo Section
document.getElementById('artist_name').textContent = exhibit.exhibit.organizer_name || 'Unknown Organizer';
const artworkFiles = exhibit.artwork_files;

const soloCardImages = document.getElementById('soloCardImages');
soloCardImages.innerHTML = '';

artworkFiles.forEach(file => {
    const img = document.createElement('img');
    img.src = `../${file}`;
    img.alt = 'Artwork';
    img.style.width = '100%';
    img.style.margin = '10px';

    soloCardImages.appendChild(img);
});

// Collaborator Section
document.getElementById('artist_nameCollab').textContent = exhibit.exhibit.organizer_name || 'Unknown Organizer';

const collaboratorsContainer = document.getElementById('collaborators-cards');
const collaboratorNames = exhibit.collaborator_names || ['Unknown Collaborator'];
collaboratorsContainer.innerHTML = '';

collaboratorNames.forEach((name, index) => {
    const collabDetails = document.createElement('div');
    collabDetails.classList.add('collab-details');

    const collabNameElement = document.createElement('p');
    collabNameElement.classList.add('collab-name1');
    collabNameElement.textContent = name;

    const collaboratorContainer = document.createElement('div');
    collaboratorContainer.classList.add('collaborator');

    const artCollage = document.createElement('div');
    artCollage.classList.add('art-collage');

    const cArtworks = document.createElement('div');
    cArtworks.classList.add('c-artworks');

    const collaboratorFiles = exhibit.artwork_files.slice(0, 2); 
    collaboratorFiles.forEach(file => {
        const image = document.createElement('img');
        image.src = `../${file}`;
        cArtworks.appendChild(image);
    });

    const cArtwork = document.createElement('div');
    cArtwork.classList.add('c-artwork');
    if (exhibit.artwork_files[2]) {
        const image = document.createElement('img');
        image.src = `../${exhibit.artwork_files[2]}`;
        cArtwork.appendChild(image);
    } else if (exhibit.artwork_files.length === 0) {
        const noImagesText = document.createElement('p');
        noImagesText.textContent = 'No images';
        cArtwork.appendChild(noImagesText);
    }

    artCollage.appendChild(cArtworks);
    artCollage.appendChild(cArtwork);

    collaboratorContainer.appendChild(artCollage);

    collabDetails.appendChild(collabNameElement);
    collabDetails.appendChild(collaboratorContainer);

    collaboratorsContainer.appendChild(collabDetails);
});

// Admin & Collaborator Image Handling (Admin Section)
const artworksContainer = document.querySelector('.artworks');
const artworkContainer = document.querySelector('.artwork');

artworkFiles.slice(0, 3).forEach((file, index) => {
    const img = document.createElement('img');
    img.src = `../${file}`;
    img.alt = `Art ${index + 1}`;

    if (index < 2) {
        artworksContainer.appendChild(img);
    } else {
        artworkContainer.appendChild(img);
    }
});



        // get the exhibit type
        const fetchedExhibitType = exhibit.exhibit.exbt_type; 
        console.log("Fetched Exhibit Type:", fetchedExhibitType);


        // Show/hide Solo or Collab sections based on the fetched exhibit type
        if (fetchedExhibitType === "Solo") {
          soloRequest.style.display = "block";
          collabRequest.style.display = "none";
        } else if (fetchedExhibitType === "Collaborate") {
          soloRequest.style.display = "none";
          collabRequest.style.display = "block";
        }

        // Show the panel and hide posts wrapper and header
        if (postsWrapper && headerWrapper) {
          postsWrapper.style.display = "none";
          headerWrapper.style.display = "none";
        }

        if (panel) {
          panel.style.display = "block";
        }

      }).catch(error => {
        console.error('Error fetching exhibit data:', error);
        alert('An error occurred while fetching exhibit details.');
      });
    });
  }

  // Back button functionality
  if (backButton) {
    backButton.addEventListener("click", function () {
      if (panel) {
        panel.style.display = "none";
      }

      if (postsWrapper && headerWrapper) {
        postsWrapper.style.display = "block";
        headerWrapper.style.display = "block";
      }
      window.location.reload();
    });
  }
});

// Fetch exhibit data function
function fetchExhibitData(exhibitId) {
  return new Promise((resolve, reject) => {
    fetch(`org.php?id=${exhibitId}`)
    .then(response => response.text())
    .then(data => {
      console.log("Raw data:", data);
      try {
        const exhibit = JSON.parse(data); 
        resolve(exhibit);
      } catch (error) {
        console.error('Error parsing JSON:', error);
        reject(error);
      }
    })
    .catch(error => reject(error));
  });
}






// POPUP MSG FOR APPROVE & DECLINE
document.addEventListener("DOMContentLoaded", function () {
  const approveButtons = document.querySelectorAll(".approve-btn");
  const declineButtons = document.querySelectorAll(".decline-btn");

  const popupContainer = document.getElementById("p-popup-container");
  const popupMessage = document.getElementById("p-popup-message");
  const confirmButton = document.getElementById("p-confirm-btn");
  const cancelButton = document.getElementById("p-cancel-btn");

  let currentAction = ""; 
  let currentExhibitId = null; // To store the exhibit ID to be updated

  // Function to show the popup
  function showPopup(message, action, exhibitId) {
    popupMessage.textContent = message; 
    popupContainer.style.display = "flex"; 
    currentAction = action;
    currentExhibitId = exhibitId; // Store the exhibit ID for the action
  }

  // Function to hide the popup
  function hidePopup() {
    popupContainer.style.display = "none";
    currentAction = ""; 
    currentExhibitId = null;
  }

  // Add click listeners to all approve buttons
  for (let i = 0; i < approveButtons.length; i++) {
    approveButtons[i].addEventListener("click", function () {
      const exhibitId = approveButtons[i].getAttribute("data-exhibit-id"); 
      showPopup("Are you sure you want to approve this exhibit?", "approve", exhibitId);
    });
  }

  // Add click listeners to all decline buttons
  for (let i = 0; i < declineButtons.length; i++) {
    declineButtons[i].addEventListener("click", function () {
      const exhibitId = declineButtons[i].getAttribute("data-exhibit-id");
      showPopup("Are you sure you want to decline this exhibit?", "decline", exhibitId);
    });
  }

  confirmButton.addEventListener("click", function () {
    if (currentAction === "approve" && currentExhibitId) {
      // Approve action
      fetch('org.php', {
        method: 'POST',
        body: new URLSearchParams({
          exbt_id: currentExhibitId,
          status: 'Accepted'
        }),
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        }
      })
      .then(response => {
        if (!response.ok) {
          throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
      })
      .then(data => {
        if (data.status === 'success') {
          showCustomAlert('Exhibit approved!');
        } else {
          const errorMsg = data.message || 'Failed to update exhibit status.';
          showCustomAlert(errorMsg);
        }
      })
      .catch(error => {
        console.error('Error:', error);
        showCustomAlert('An error occurred while updating exhibit status.');
      });
      
    } else if (currentAction === "decline" && currentExhibitId) {
      // Decline action
      fetch('org.php', {
        method: 'POST',
        body: new URLSearchParams({
          exbt_id: currentExhibitId,
          status: 'Declined' 
        }),
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          showCustomAlert('Exhibit declined!');
        } else {
          showCustomAlert('Failed to update exhibit status.');
        }
      })
      .catch(error => {
        console.error('Error:', error);
        showCustomAlert('An error occurred.');
      });
    }

    hidePopup(); 
  });

  cancelButton.addEventListener("click", function () {
    hidePopup(); 
  });
});

// show custom alert
function showCustomAlert(message) {
  const alertBox = document.getElementById('customAlert');
  const alertMessage = document.getElementById('alertMessage');
  const closeButton = document.getElementById('closeAlertBtn');

  alertMessage.textContent = message; 
  alertBox.classList.add('show'); 

  closeButton.addEventListener('click', function() {
      alertBox.classList.remove('show'); 
      window.location.reload() 
  });
}

//ADMIN & COLLAB IMG CAROUSEL
document.addEventListener("DOMContentLoaded", function () {
  const adminCards = document.querySelectorAll(".admin-card, .collaborator");
  const modal = document.getElementById("image-modal");
  const modalImage = modal.querySelector(".modal-image");
  const leftBtn = modal.querySelector(".left-btn");
  const rightBtn = modal.querySelector(".right-btn");

  let currentImages = []; 
  let currentIndex = 0;   

  // Function to open the modal and show images
  function openModal(images) {
    modal.style.display = "flex"; 
    currentImages = images; 
    currentIndex = 0; 
    modalImage.src = currentImages[currentIndex].src; 
  }

  // Event listener for each admin-card or collaborator
  for (let i = 0; i < adminCards.length; i++) {
    adminCards[i].addEventListener("click", function () {
      const images = adminCards[i].querySelectorAll("img"); 

      // Only the first 3 images will be displayed in the modal initially
      const firstThreeImages = Array.from(images).slice(0, 3);

      if (firstThreeImages.length > 0) {
        openModal(firstThreeImages); 
      }
    });
  }

  // Close the modal when clicking outside the image
  modal.addEventListener("click", function (e) {
    if (e.target === modal) {
      modal.style.display = "none"; 
    }
  });

  // Navigate to the previous image
  leftBtn.addEventListener("click", function () {
    if (currentIndex > 0) {
      currentIndex--; 
    } else {
      currentIndex = currentImages.length - 1; 
    }
    modalImage.src = currentImages[currentIndex].src; 
  });

  // Navigate to the next image
  rightBtn.addEventListener("click", function () {
    if (currentIndex < currentImages.length - 1) {
      currentIndex++;
    } else {
      currentIndex = 0; 
    }
    modalImage.src = currentImages[currentIndex].src; 
  });
});





// SETTINGS
document.getElementById("profile-link").addEventListener("click", function() {
showSection('s-profile-section');
});

document.getElementById("account-link").addEventListener("click", function() {
showSection('account-section');
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
document.getElementById('change-link').addEventListener('click', function(e) {
  e.preventDefault();
  document.getElementById('password-view').style.display = 'none';  // Hide the "Change" view
  document.getElementById('password-edit').style.display = 'block'; // Show the "Edit" view
});

// Hide password edit view when 'Hide' is clicked
document.getElementById('hide-link').addEventListener('click', function(e) {
  e.preventDefault();
  document.getElementById('password-view').style.display = 'flex';  // Show the "Change" view
  document.getElementById('password-edit').style.display = 'none'; // Hide the "Edit" view
});

// Handle save password functionality
document.getElementById('save-password-btn').addEventListener('click', function() {
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


  fetch('updatePassword.php', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json'
      },
      body: JSON.stringify({
          currentPassword: currentPassword,
          newPassword: newPassword
      })
  })
  .then(response => response.json())
  .then(data => {
      if (data.success) {
          showCustomAlert('Password successfully changed!');
          document.getElementById('password-view').style.display = 'flex';  // Show the "Change" view
          document.getElementById('password-edit').style.display = 'none';  // Hide the "Edit" view
      } else {
          showCustomAlert('Error: ' + data.error);
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

const fileInput = document.createElement('input');
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

document.addEventListener('DOMContentLoaded', function () {
  const logoutButton = document.querySelector('.logoutButton');
  const logoutModal = document.getElementById('logoutModal');
  const logoutModalCancel = document.getElementById('logoutModalCancel');
  const logoutModalConfirm = document.querySelector('.logoutModal-confirm');

  // Show the logout modal when the logout button is clicked
  if (logoutButton) {
      logoutButton.addEventListener('click', function(e) {
          e.preventDefault(); // Prevent the default behavior of the anchor tag
          logoutModal.style.display = 'flex';  // Show the modal
      });
  }

  // Hide the logout modal when cancel button is clicked
  if (logoutModalCancel) {
      logoutModalCancel.addEventListener('click', function() {
          logoutModal.style.display = 'none'; // Hide the modal
      });
  }

  // Redirect to logout.php when the "Yes" button is clicked
  if (logoutModalConfirm) {
      logoutModalConfirm.addEventListener('click', function() {
          window.location.href = '../logout.php'; // Redirect to logout.php
      });
  }
});
