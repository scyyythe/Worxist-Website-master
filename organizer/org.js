document.addEventListener('DOMContentLoaded', function() {
  // Sidebar links
  const dashboardLink = document.querySelector('.dasboardLink');
  const exhibitLink = document.querySelector('.exhibitLink');
  const settingsLink = document.querySelector('.settingLink');
  const acceptedLink = document.querySelector('.acceptedLink');
  const declinedLink = document.querySelector('.declinedLink');

  // Section containers
  const dashboardSection = document.getElementById('dashboard');
  const exhibitsSection = document.getElementById('exhibits');
  const settingsSection = document.getElementById('settings');
  const acceptedSection = document.getElementById('acceptedEx');
  const declinedSection = document.getElementById('declinedEx');
  const topSection = document.querySelector('.header-wrapper');
  const acceptAll = document.getElementById('accept-all-btn');
  const viewDeclined = document.getElementById('view-declined');

  // Default display settings
  dashboardSection.style.display = 'flex';
  exhibitsSection.style.display = 'none';
  settingsSection.style.display = 'none';
  acceptedSection.style.display = 'none';
  declinedSection.style.display = 'none';
  if (acceptAll) acceptAll.style.display = 'none';
  if (viewDeclined) viewDeclined.style.display = 'none';

  // Dashboard section
  dashboardLink.addEventListener('click', function(e) {
    e.preventDefault();
    console.log('Dashboard link clicked');
    dashboardSection.style.display = 'flex';
    exhibitsSection.style.display = 'none';
    settingsSection.style.display = 'none';
    acceptedSection.style.display = 'none';
    declinedSection.style.display = 'none';
    topSection.style.display = 'flex';

    if (acceptAll) acceptAll.style.display = 'none';
    if (viewDeclined) viewDeclined.style.display = 'none';
  });

  // Exhibits section
  exhibitLink.addEventListener('click', function(e) {
    e.preventDefault();
    console.log('Exhibit link clicked');
    dashboardSection.style.display = 'none';
    exhibitsSection.style.display = 'flex';
    settingsSection.style.display = 'none';
    acceptedSection.style.display = 'none';
    declinedSection.style.display = 'none';
    topSection.style.display = 'flex';

    if (acceptAll) acceptAll.style.display = 'block';
    if (viewDeclined) viewDeclined.style.display = 'block';
  });

  // Accepted section
  acceptedLink.addEventListener('click', function(e) {
    e.preventDefault();
    console.log('Accepted link clicked');
    dashboardSection.style.display = 'none';
    exhibitsSection.style.display = 'none';
    settingsSection.style.display = 'none';
    acceptedSection.style.display = 'block';
    declinedSection.style.display = 'none';
    topSection.style.display = 'none';

    if (acceptAll) acceptAll.style.display = 'none';
    if (viewDeclined) viewDeclined.style.display = 'none';
  });

  // Declined section
  declinedLink.addEventListener('click', function(e) {
    e.preventDefault();
    console.log('Declined link clicked');
    dashboardSection.style.display = 'none';
    exhibitsSection.style.display = 'none';
    settingsSection.style.display = 'none';
    acceptedSection.style.display = 'none';
    declinedSection.style.display = 'block';
    topSection.style.display = 'none';

    if (acceptAll) acceptAll.style.display = 'none';
    if (viewDeclined) viewDeclined.style.display = 'none';
  });

  // Settings section
  settingsLink.addEventListener('click', function(e) {
    e.preventDefault();
    console.log('Settings link clicked');
    dashboardSection.style.display = 'none';
    exhibitsSection.style.display = 'none';
    settingsSection.style.display = 'block';
    acceptedSection.style.display = 'none';
    declinedSection.style.display = 'none';
    topSection.style.display = 'none';

    if (acceptAll) acceptAll.style.display = 'none';
    if (viewDeclined) viewDeclined.style.display = 'none';
  });
});

//NAVIGATION OF PAST & UPCOMING CONTAINERS
document.addEventListener("DOMContentLoaded", () => {
  const options = document.querySelectorAll(".a-option");
  const upcomingWrapper = document.getElementById("upcoming-wrapper");
  const pastWrapper = document.getElementById("past-wrapper");

  options.forEach((option, index) => {
    option.addEventListener("click", () => {
      options.forEach((opt) => opt.classList.remove("active"));
      option.classList.add("active");

      if (index === 0) { 
        upcomingWrapper.style.display = "block";
        pastWrapper.style.display = "none";
      } else if (index === 1) { 
        pastWrapper.style.display = "block";
        upcomingWrapper.style.display = "none";
      }
    });
  });

  options[0].classList.add("active");
  upcomingWrapper.style.display = "block";
  pastWrapper.style.display = "none";
});


//ACTIVE TAB
document.addEventListener("DOMContentLoaded", () => {
  const options = document.querySelectorAll(".a-option");
  const upcomingWrapper = document.getElementById("upcoming-wrapper");
  const pastWrapper = document.getElementById("past-wrapper");

  options.forEach(option => {
      option.addEventListener("click", () => {
          options.forEach(opt => {
              opt.style.color = "";
              opt.style.borderBottom = "";
          });

          option.style.color = "#a20d0d";
          option.style.borderBottom = "2px solid #a20d0d";

          if (option.textContent === "Upcoming Exhibits") {
              upcomingWrapper.style.display = "grid";
              pastWrapper.style.display = "none";
          } else if (option.textContent === "Past Exhibits") {
              pastWrapper.style.display = "grid";
              upcomingWrapper.style.display = "none";
          }
      });
  });

  options[0].style.color = "#a20d0d";
  options[0].style.borderBottom = "2px solid #a20d0d";
  upcomingWrapper.style.display = "grid";
  pastWrapper.style.display = "none";
});


document.getElementById("year").addEventListener("change", filterExhibits);
document.getElementById("month").addEventListener("change", filterExhibits);
document.getElementById("type").addEventListener("change", filterExhibits);  // Added listener for type

function filterExhibits() {
    var year = document.getElementById("year").value;
    var month = document.getElementById("month").value;
    var type = document.getElementById("type").value;  // Get the selected type

    var exhibits = document.querySelectorAll(".ex-card");

    exhibits.forEach(function(exhibit) {
        var exhibitYear = exhibit.getAttribute("data-year");
        var exhibitMonth = exhibit.getAttribute("data-month");
        var exhibitType = exhibit.getAttribute("data-type");  // Assume you have a 'data-type' attribute for type

        // Apply filter conditions for year, month, and type
        if ((year === "" || exhibitYear === year) && 
            (month === "" || exhibitMonth === month) && 
            (type === "" || exhibitType === type)) {
            exhibit.style.display = "block";
        } else {
            exhibit.style.display = "none";
        }
    });
}

document.getElementById("year").addEventListener("change", function() {
    if (this.value !== "") {
        document.getElementById("month").classList.remove("hidden");
    } else {
        document.getElementById("month").classList.add("hidden");
    }
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
document.addEventListener('DOMContentLoaded', function () {
  // Get the canvas for the Activity Chart
  let activityCanvas = document.getElementById('activityChart').getContext('2d');

  // Adjust canvas resolution for high-DPI displays
  let dpr = window.devicePixelRatio || 1; // Device Pixel Ratio
  activityCanvas.canvas.width = activityCanvas.canvas.clientWidth * dpr;
  activityCanvas.canvas.height = activityCanvas.canvas.clientHeight * dpr;
  activityCanvas.scale(dpr, dpr);

  // Line chart with dynamic data for exhibit requests and accepted exhibitions
  let activityChart = new Chart(activityCanvas, {
      type: 'line', // Chart type
      data: {
          labels: weeks, // Dynamic week labels from PHP data
          datasets: [
              {
                  label: 'Exhibit Requests', 
                  data: requestsData, 
                  borderColor: '#a20d0d', 
                  backgroundColor: '#a20d0d', 
                  fill: false, 
                  borderWidth: 2
              },
              {
                  label: 'Accepted Exhibitions', 
                  data: acceptedData, 
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

document.addEventListener("DOMContentLoaded", function () {
  const dateElement = document.querySelector(".ex-date");
  const today = new Date();
  const month = today.getMonth() + 1; // Month is zero-indexed
  const day = today.getDate();
  const year = today.getFullYear();
  const shortYear = year.toString().slice(-2); // Last two digits of the year
  const formattedDate = `${month}/${day}/${shortYear}`;
  dateElement.textContent = formattedDate;
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
  const acceptAll=document.getElementById('accept-all-btn');
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
 document.getElementById("exhibit-date").innerText = "Exhibit Date: " + exhibit.exhibit.exbt_date;
document.getElementById("exhibit-title").innerText = exhibit.exhibit.exbt_title;
document.getElementById("exhibit-description").innerText = exhibit.exhibit.exbt_descrip;
const acceptAll = document.getElementById('accept-all-btn');
const viewDeclined= document.getElementById('view-declined');
  if (acceptAll) {
    acceptAll.style.display = 'none';
  }
  if (viewDeclined) {
    viewDeclined.style.display = 'none';
  }
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

        // Pass exhibitId to approve and decline buttons
        const approveButtons = document.querySelectorAll(".approve-btn");
        const declineButtons = document.querySelectorAll(".decline-btn");
        const popupContainer = document.getElementById("p-popup-container");
        const popupMessage = document.getElementById("p-popup-message");
        const confirmButton = document.getElementById("p-confirm-btn");
        const cancelButton = document.getElementById("p-cancel-btn");


        for (let i = 0; i < approveButtons.length; i++) {
          approveButtons[i].setAttribute("data-exhibit-id", exhibitId); // Attach exhibitId to the approve button
          approveButtons[i].addEventListener("click", function () {
            const exhibitId = this.getAttribute("data-exhibit-id"); // Retrieve the exhibitId
            showPopup(`Are you sure you want to approve this exhibit? ${exhibitId}`, "approve", exhibitId);
          });
        }

        for (let i = 0; i < declineButtons.length; i++) {
          declineButtons[i].setAttribute("data-exhibit-id", exhibitId); 
          declineButtons[i].addEventListener("click", function () {
            const exhibitId = this.getAttribute("data-exhibit-id"); 
            showPopup(`Are you sure you want to decline this exhibit? ${exhibitId}`, "decline", exhibitId);
          });
        }
        
         // Function to show the popup
  function showPopup(message, action, exhibitId) {
    popupMessage.textContent = message; 
    popupContainer.style.display = "flex"; 
    currentAction = action;
    currentExhibitId = exhibitId; 
  }

  // Function to hide the popup
  function hidePopup() {
    popupContainer.style.display = "none";
    currentAction = ""; 
    currentExhibitId = null;
  }

  
  confirmButton.addEventListener("click", function () {
    if (currentAction === "approve" && currentExhibitId) {
      // Approve action
      console.log("Approving exhibit ID:", currentExhibitId);
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
      .then(response => response.json())
      .then(data => {
        if (data.status === 'error') {
          console.log(data.message); 
          showCustomAlert(data.message);  
        } else {
          showCustomAlert("Exhibit updated successfully");
  
          // Dynamically remove or update the exhibit from the list
          let exhibitCard = document.querySelector(`.card[data-exhibit-id="${currentExhibitId}"]`);
          if (exhibitCard) {
            exhibitCard.remove(); // Remove the card after approval
          }
  
          // If there are no more pending exhibits, show a message
          let postsWrapper = document.querySelector('.posts-wrapper');
          if (!postsWrapper.querySelector('.card')) {
            postsWrapper.innerHTML = "<p class='no-exhibits-message'>No pending exhibits available.</p>";
          }
        }
      })
      .catch(error => {
        console.error("Error:", error);
        showCustomAlert("An error occurred.");
      });
      
    } else if (currentAction === "decline" && currentExhibitId) {
      // Decline action
      console.log("Declining exhibit ID:", currentExhibitId);
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
          
          // Dynamically remove or update the exhibit from the list
          let exhibitCard = document.querySelector(`.card[data-exhibit-id="${currentExhibitId}"]`);
          if (exhibitCard) {
            exhibitCard.remove(); // Remove the card after decline
          }
  
          // If there are no more pending exhibits, show a message
          let postsWrapper = document.querySelector('.posts-wrapper');
          if (!postsWrapper.querySelector('.card')) {
            postsWrapper.innerHTML = "<p class='no-exhibits-message'>No pending exhibits available.</p>";
          }
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
  const viewDeclined= document.getElementById('view-declined');
  let postsWrapperContent = postsWrapper.innerHTML;
let headerWrapperContent = headerWrapper.innerHTML;
  // Back button functionality
  if (backButton) {
    backButton.addEventListener("click", function () {
      if (panel) {
        panel.style.display = "none";
      }

      if (postsWrapper && headerWrapper) {
        postsWrapper.style.display = "block";
        headerWrapper.style.display = "block";
        acceptAll.style.display='block';
        viewDeclined.style.display='block';
      }
   
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



function showCustomAlert(message) {
  const alertBox = document.getElementById('customAlert');
  const alertMessage = document.getElementById('alertMessage');
  const closeButton = document.getElementById('closeAlertBtn');

  alertMessage.textContent = message; 
  alertBox.classList.add('show'); 

  closeButton.addEventListener('click', function() {
      alertBox.classList.remove('show'); 
      window.location.reload();
  });
}

// approve all the request exhibit
document.getElementById('accept-all-btn').addEventListener('click', function() {
  fetch('org.php', {
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


document.addEventListener("DOMContentLoaded", function () {
  const viewDeclinedButton = document.getElementById('view-declined');
  const declinedPopup = document.getElementById('declined-popup');
  const declinedExhibitsList = document.getElementById('declined-exhibits-list');

  viewDeclinedButton.addEventListener('click', function() {
    fetchDeclinedExhibits();
    declinedPopup.style.display = 'flex'; 
  });



  function processDeclinedExhibits(data) {
    const declinedExhibitsList = document.getElementById('declined-exhibits-list');
    const closeBtn = document.getElementById('closeDeclined');
    
    // Clear the list before adding new content
    declinedExhibitsList.innerHTML = ''; 
    
    if (data.length > 0) {
      data.forEach(exhibit => {
        const exhibitDiv = document.createElement('div');
        exhibitDiv.classList.add('exhibit-item');
    
        const exhibitTitle = document.createElement('h3');
        exhibitTitle.textContent = exhibit.exbt_title;
    
        const exhibitOwner = document.createElement('p');
        exhibitOwner.classList.add('owner-name');
        exhibitOwner.textContent = `Owner: ${exhibit.owner_name}`;
    
        const restoreButton = document.createElement('button');
        restoreButton.textContent = 'Restore';
        restoreButton.classList.add('restore-button');
        restoreButton.addEventListener('click', function() {
          restoreExhibit(exhibit.exbt_id);
        });
    
        exhibitDiv.appendChild(exhibitTitle);
        exhibitDiv.appendChild(exhibitOwner);
        exhibitDiv.appendChild(restoreButton);
        declinedExhibitsList.appendChild(exhibitDiv);
      });
  
      if (closeBtn) {
        closeBtn.addEventListener('click', function() {
          declinedExhibitsList.style.display = 'none';
        });
      }
  
      document.addEventListener('click', function(event) {
        if (!declinedExhibitsList.contains(event.target) && event.target !== closeBtn) {
          declinedExhibitsList.style.display = 'none'; 
        }
      });
  
    } else {
      declinedExhibitsList.innerHTML = '<p>No declined exhibits found.</p>';
    }
  }
  


  function fetchDeclinedExhibits() {
    fetch('get_declined_exhibit.php') 
      .then(response => { 
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {
        processDeclinedExhibits(data); 
      })
      .catch(error => {
        console.error('Error fetching declined exhibits:', error);
        alert('An error occurred while fetching declined exhibits.');
      });
  }

  function restoreExhibit(exhibitId) {
    fetch('restore_exhibit.php', { 
      method: 'POST',
      body: new URLSearchParams({ exbt_id: exhibitId }),
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    })
    .then(response => response.json())
    .then(data => {
      if (data.status === 'success') {
        alert('Exhibit restored successfully');
        fetchDeclinedExhibits();
      } else {
        alert('Failed to restore exhibit');
      }
    })
    .catch(error => {
      console.error('Error restoring exhibit:', error);
    });
  }


});



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
