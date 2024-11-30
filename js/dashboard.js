
// js para sa login-register.php and index.php//

document.addEventListener('DOMContentLoaded', function() {

    function scrollToAbout() {
      const aboutSection = document.getElementById('about');
      if (aboutSection) {
          aboutSection.scrollIntoView({ behavior: 'smooth' });
      } else {
          console.error("Element with id='about' not found.");
      }
  }

  const exploreButton = document.querySelector('.explore-button button');
  if (exploreButton) {
      exploreButton.addEventListener('click', scrollToAbout);
  }

  const carousel = document.querySelector(".gallery-images"),
      firstImg = document.querySelectorAll("img")[0];

if (firstImg) {
  const arrowIcons = document.querySelectorAll(".arrow i");
  let firstImgWidth = firstImg.clientWidth + 272; 

  arrowIcons.forEach(icon => {
      icon.addEventListener("click", () => {
          if (icon.id === "left") {
              
              carousel.scrollLeft -= firstImgWidth; 
          } else if (icon.id === "right") {
              // Scroll right
              carousel.scrollLeft += firstImgWidth; 
          }
      });
  });
} else {
  console.error("Gallery images not found.");
}

  // return click
  const returnBtn = document.getElementById('return');
  if (returnBtn) {
    returnBtn.addEventListener('click', function() {
      window.location.href = 'index.php';
    });
  } else {
    console.error("Return button with id='return' not found.");
  }

  // return click
  const returnTo = document.getElementById('returnTo');
  if (returnTo) {
    returnTo.addEventListener('click', function() {
      window.location.href = 'index.php';
    });
  } else {
    console.error("Return button with id='return' not found.");
  }

  const signIn = document.getElementById("show-login");
  const signUp = document.getElementById("show-create");
  const wrapper = document.getElementById("wrapper");

  if (signIn && signUp && wrapper) {
    signIn.addEventListener('click', (event) => {
      event.preventDefault();  
      wrapper.classList.add("right-panel-activate");
    });

    signUp.addEventListener('click', (event) => {
      event.preventDefault();  
      wrapper.classList.remove("right-panel-activate");
    });
  } else {
    console.error("Sign-in, Sign-up, or wrapper elements not found.");
  }


  const exploreBtn = document.getElementById('explore');
  if (exploreBtn) {
    exploreBtn.addEventListener('click', function() {
      window.location.href = 'accounLogin.html';
    });
  } else {
    console.error("Explore button with id='explore' not found.");
  }

});



//dashboard page
function toggleSidebar() {
  const sidebar = document.getElementById('sidebar');
  sidebar.classList.toggle('open');
}

//sidebar active
const sidebarItems = document.querySelectorAll('.sidebar li');


sidebarItems.forEach(item => {
    item.addEventListener('click', function() {
       
        sidebarItems.forEach(el => el.classList.remove('active'));
        
        this.classList.add('active');
    });
});



// tabpane in Artwork Dashboard
function myOption(evt, option) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(option).style.display = "block";
  evt.currentTarget.className += " active";
}
document.addEventListener("DOMContentLoaded", function() {
  var firstTab = document.querySelector('.tablinks');
  firstTab.click(); 
});

//view peding exhibits
document.addEventListener("DOMContentLoaded", function () {
  const button = document.getElementById("viewExhibit-btn");
   const button2 = document.getElementById("viewExhibit");
  if (button&&button2) {
    button.addEventListener("click", function(event) {
      event.preventDefault(); 

      const exbtType = this.getAttribute("data-exbt-type"); 
      console.log(exbtType); 

      if (exbtType === 'Solo') {
        window.location.href = "soloRequest.php";
      } else if (exbtType === 'Collaborate') {
        window.location.href = "pendingCollab/collabRequest.php";
      }
    });

    button2.addEventListener("click", function(event) {
      event.preventDefault(); 

      const exbtType = this.getAttribute("data-exbt-type"); 
      console.log(exbtType); 

      if (exbtType === 'Solo') {
        window.location.href = "soloRequest.php";
      } else if (exbtType === 'Collaborate') {
        window.location.href = "pendingCollab/collabRequest.php";
      }
    });
  }
});


// dropdown filter
function toggleDropdown() {
  var dropdown = document.getElementById("dropdown");
  if (dropdown.style.display === "block") {
      dropdown.style.display = "none";
  } else {
      dropdown.style.display = "block";
  }
}

document.addEventListener('DOMContentLoaded', function () {
  const categoryLinks = document.querySelectorAll('#dropdown a'); 
  const artworks = document.querySelectorAll('.box'); 

  categoryLinks.forEach(function (link) {
      link.addEventListener('click', function (event) {
          event.preventDefault();
          const selectedCategory = link.getAttribute('data-category'); // Get the selected category
          
          filterArtworks(selectedCategory, artworks);
      });
  });

  function filterArtworks(category, artworks) {
      artworks.forEach(function (artwork) {
          if (category === 'all' || artwork.getAttribute('data-category') === category) {
              artwork.style.display = 'block';
          } else {
              artwork.style.display = 'none'; 
          }
      });
  }
});


// FOLLOWERS AND FOLLOWING
const modal = document.getElementById("followers-modal");
const followersContent = document.getElementById("followers-content");
const followingContent = document.getElementById("following-content");

const viewFollowersButton = document.getElementById("openFollowers");
const viewFollowingButton = document.getElementById("openFollowing");

const closeButton = document.getElementsByClassName("close-button")[0];

viewFollowersButton.addEventListener("click", function(event) {
    event.preventDefault(); 
    followersContent.style.display = "block";
    followingContent.style.display = "none";
    modal.style.display = "block";
});

// following modal
viewFollowingButton.addEventListener("click", function(event) {
    event.preventDefault(); 
    followersContent.style.display = "none";
    followingContent.style.display = "block";
    modal.style.display = "block";
});

closeButton.addEventListener("click", function() {
    modal.style.display = "none"; 
});

window.addEventListener("click", function(event) {
    if (event.target === modal) {
        modal.style.display = "none"; 
    }
});


// e link mga side bar
document.addEventListener('DOMContentLoaded', function() {

  // sidebar links
  const dashboardLink = document.querySelector('.dashboard');
  const artworkLink = document.querySelector('.my-artworks');
  const messageLink=document.querySelector('.messages');
  const exhibitLink=document.querySelector('.exhibit');
  const settingLink=document.querySelector('.settings');

  //exhibit
  const reqContainer=document.getElementById('reqExhibit-con');
  
  // containers
  const dashboardContainer = document.getElementById('dashboardContainer');
  const artworkContainer = document.getElementById('artworkContainer');
  const messageContainer = document.getElementById('messageContainer');
  const exhibitContainer = document.getElementById('exhibitContainer');
  const settingContainer = document.getElementById('settingsContainer');

  //  show only the dashboard and hide others
  artworkContainer.style.display = 'none';
  messageContainer.style.display = 'none';
  exhibitContainer.style.display = 'none';
  settingContainer.style.display = 'none';
  reqContainer.style.display='none';

  // Dashboard
  dashboardLink.addEventListener('click', function(e) {
      e.preventDefault(); 
      dashboardContainer.style.display = 'block';
      artworkContainer.style.display = 'none';
      messageContainer.style.display = 'none';
      exhibitContainer.style.display = 'none';
      settingContainer.style.display = 'none';
      reqContainer.style.display='none';

  });

  //my-artworks Management
  artworkLink.addEventListener('click', function(e) {
      e.preventDefault();
      dashboardContainer.style.display = 'none';
      artworkContainer.style.display = 'block';
      messageContainer.style.display = 'none';
      exhibitContainer.style.display = 'none';
      settingContainer.style.display = 'none';
      reqContainer.style.display='none';

  });

  // messages section
messageLink.addEventListener('click', function(e) {
    e.preventDefault();
    dashboardContainer.style.display = 'none';
    artworkContainer.style.display = 'none';
    messageContainer.style.display = 'block';
    exhibitContainer.style.display = 'none';
    settingContainer.style.display = 'none';
    reqContainer.style.display='none';


});

// exhibit container
exhibitLink.addEventListener('click', function(e) {
  e.preventDefault();
  dashboardContainer.style.display = 'none';
      artworkContainer.style.display = 'none';
      messageContainer.style.display = 'none'
      exhibitContainer.style.display = 'block';
      settingContainer.style.display = 'none';
      reqContainer.style.display='none';


});

// settings
settingLink.addEventListener('click', function(e) {
  e.preventDefault();
  dashboardContainer.style.display = 'none';
  artworkContainer.style.display = 'none';
  messageContainer.style.display = 'none';
  exhibitContainer.style.display = 'none';
  reqContainer.style.display = 'none';

  settingContainer.style.display = 'block';  
});

 
});


document.addEventListener('DOMContentLoaded', () => {
  const descriptionTrigger = document.querySelector('.viewDescription');
  const popup = document.querySelector('.exhibition-description-popup');
  const closePopup = document.querySelector('.exhibition-close-popup');

  // Show the popup when the trigger is clicked
  descriptionTrigger.addEventListener('click', () => {
      popup.style.display = 'block';
  });

  // Close the popup when the close button is clicked
  closePopup.addEventListener('click', () => {
      popup.style.display = 'none';
  });

  // Close the popup when clicking outside the content
  window.addEventListener('click', (event) => {
      if (event.target === popup) {
          popup.style.display = 'none';
      }
  });
});


// pop up modal para sa clicked na artworks
function showPopup(element) {
  const blur = document.getElementById('blur');
  const popup = document.getElementById('popup');

  const imageSrc = element.getAttribute('data-image');
  const title = element.getAttribute('data-title');
  const artist = element.getAttribute('data-artist');
  const artistId = element.getAttribute('data-artist-id');
  const category = element.getAttribute('data-category');
  const description = element.getAttribute('data-description');
  const date = element.getAttribute('data-date');
  const artworkId = element.getAttribute('data-artwork-id');
  const liked = parseInt(element.getAttribute('data-liked')); 
    const saved = parseInt(element.getAttribute('data-saved')); 
    const favorite = parseInt(element.getAttribute('data-favorite'));


  console.log("Artwork ID (a_id):", artworkId);
  console.log("Title:", title);
  console.log("Artist:", artist);

  const socialIcons = document.querySelector('.social-interact-icons');
  socialIcons.setAttribute('data-artwork-id', artworkId);

  document.querySelector('.box-pop img').src = imageSrc;
  document.querySelector('.top-details h3').innerText = title;
  const dataIdLink = document.querySelector('.data-id');
  dataIdLink.href = `profileDash.php?id=${artistId}`;
  dataIdLink.innerText = artist;

  document.querySelector('.category').innerText = category;
  document.querySelector('.description-of-art').innerText = description;
  document.querySelector('.dateUpload').innerText = date;
  document.querySelector('.noHeart').innerText=liked;
  document.querySelector('.noBookmark').innerText=saved;
  document.querySelector('.noFavorite').innerText=favorite;

  const loggedInUserId = document.getElementById('data-id').getAttribute('data-artist-id');


  const existingEditOption = document.querySelector('.edit-option');
  if (existingEditOption) {
    existingEditOption.remove();
  }

  if (artistId === loggedInUserId) {
    const editOption = document.createElement('p');
    editOption.innerHTML = "<i class='bx bxs-edit'></i>";
    editOption.classList.add('edit-option');

    editOption.onclick = () => {
      window.location.href = `editArtwork.php?a_id=${artworkId}`;  
  };
  

    document.querySelector('.top-details').appendChild(editOption);
  }

  popup.style.display = 'flex';
  setTimeout(() => {
      popup.classList.add('active');
  }, 0);

  blur.classList.add('active');
  document.addEventListener('DOMContentLoaded', () => {
    initializeIconStates(artworkId);  
  });

  document.querySelector('.like-icon').onclick = () => {
    const likeIcon = document.querySelector('.like-icon');
    const newLikedCount = likeIcon.classList.contains('liked') ? liked - 1 : liked + 1;

    document.querySelector('.noHeart').innerText = newLikedCount;
    likeIcon.classList.toggle('liked');

    updateDatabase('likeArtwork', artworkId, newLikedCount);
};

document.querySelector('.bookmark-icon').onclick = () => {
    const bookmarkIcon = document.querySelector('.bookmark-icon');
    const newSavedCount = bookmarkIcon.classList.contains('saved') ? saved - 1 : saved + 1;
   
    document.querySelector('.noBookmark').innerText = newSavedCount;
    bookmarkIcon.classList.toggle('saved');

    updateDatabase('saveArtwork', artworkId, newSavedCount);
};

document.querySelector('.favorite-icon').onclick = () => {
    const favoriteIcon = document.querySelector('.favorite-icon');
    const newFavoriteCount = favoriteIcon.classList.contains('favorited') ? favorite - 1 : favorite + 1;

    document.querySelector('.noFavorite').innerText = newFavoriteCount;
    favoriteIcon.classList.toggle('favorited');

    updateDatabase('addToFavorites', artworkId, newFavoriteCount);
};

// Close the popup when clicking outside
function closePopup(event) {
  if (!popup.contains(event.target) && !element.contains(event.target)) {
    popup.style.display = 'none';
    blur.classList.remove('active');
    document.removeEventListener('click', closePopup); // Remove the event listener
  }
}

document.addEventListener('click', closePopup);
}

//interaction sa like favorited andsaved
function initializeIconStates(artworkId) {
  fetch(`class/interaction.php?action=getStates&a_id=${artworkId}`)
    .then(response => response.json())
    .then(data => {
        if (data) {
          
            if (data.liked) {
                document.querySelector('.like-icon').classList.add('liked');
            }
            if (data.saved) {
                document.querySelector('.bookmark-icon').classList.add('saved');
            }
            if (data.favorited) {
                document.querySelector('.favorite-icon').classList.add('favorited');
            }
        }
    })
    .catch(error => {
        console.error('Error fetching icon states:', error);
    });
}

function updateDatabase(action, artworkId, newCount) {
  return fetch('class/interaction.php', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json'
      },
      body: JSON.stringify({ action: action, a_id: artworkId, newCount: newCount })
  })
  .then(response => response.json())
  .then(data => {
      if (!data.success) {
          console.error('Error updating database');
      } else {
          console.log(`${action} updated successfully!`);
      }
  })
  .catch(error => {
      console.error('Error:', error);
  });
}

function closePopup() {
  const popup = document.getElementById('popup');
  const blur = document.getElementById('blur');

  popup.classList.remove('active'); 
  blur.classList.remove('active'); 

  setTimeout(() => {
      popup.style.display = 'none';
  }, 300); 
}

function toggleEditProfile() {

  const dashboardContainer = document.getElementById('dashboardContainer');
  const artworkContainer = document.getElementById('artworkContainer');
  const messageContainer = document.getElementById('messageContainer');
  const exhibitContainer = document.getElementById('exhibitContainer');
  const settingContainer = document.getElementById('settingsContainer');
  const reqContainer=document.getElementById('reqExhibit-con');

  dashboardContainer.style.display = 'none';
  artworkContainer.style.display = 'none';
  messageContainer.style.display = 'none';
  exhibitContainer.style.display = 'none';
  reqContainer.style.display='none';
  
  settingContainer.style.display = 'block';
}



//exhibit
function toggleExhibit() {

  const dashboardContainer = document.getElementById('dashboardContainer');
  const artworkContainer = document.getElementById('artworkContainer');
  const messageContainer = document.getElementById('messageContainer');
  const exhibitContainer = document.getElementById('exhibitContainer');
  const settingContainer = document.getElementById('settingsContainer');
  const reqContainer=document.getElementById('reqExhibit-con');

  dashboardContainer.style.display = 'none';
  artworkContainer.style.display = 'none';
  messageContainer.style.display = 'none';
  exhibitContainer.style.display = 'none';
  settingContainer.style.display = 'none';
 
  reqContainer.style.display='block';

}

function openPage(pageName) {
  var i, tabcontent;
  tabcontent = document.getElementsByClassName("requestTab");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  document.getElementById(pageName).style.display = "block";
}
document.getElementById("defaultOpen").click();



//settings tab
function openSettings(evt, settingTab) {
  var i, tabcontent, setlinks;

  tabcontent = document.getElementsByClassName("tabInformation");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  setlinks = document.getElementsByClassName("setlinks");
  for (i = 0; i < setlinks.length; i++) {
    setlinks[i].className = setlinks[i].className.replace(" active", "");
  }
  document.getElementById(settingTab).style.display = "block";
  evt.currentTarget.className += " active";
}
function openDefaultTab() {
  var defaultTabButton = document.getElementById("defaultOpen");
  
  openSettings({ currentTarget: defaultTabButton }, 'myProfile');
}
window.onload = function() {
  openDefaultTab();
};

function toggleNotifications() {
  var notificationCenter = document.getElementById("notificationCenter");
  notificationCenter.classList.toggle("active"); 
}

//select an artworkkk
document.querySelectorAll('.display-creations img').forEach((img) => {
  img.addEventListener('click', function () {
      if (img.classList.contains('selected')) {
          img.classList.remove('selected');
      } else {
          if (document.querySelectorAll('.selected').length < 10) {
              img.classList.add('selected');
          } else {
              alert('You can only select up to 10 artworks.');
              return;
          }
      }
      const selectedIds = Array.from(document.querySelectorAll('.display-creations img.selected'))
          .map(selectedImg => selectedImg.getAttribute('data-id'));

      if (document.forms['collabExhibit']) {
          document.getElementById('selectedArtworksCollab').name = 'selected_artworks_collab';
      } else if (document.forms['soloExhibit']) {
          document.getElementById('selectedArtworks').name = 'selected_artworks';
      }
      
      document.getElementById('selectedArtworks').value = JSON.stringify(selectedIds);
      document.getElementById('selectedArtworksCollab').value = JSON.stringify(selectedIds);
  
      console.log('Selected Artwork IDs:', selectedIds);
  });
});




document.querySelectorAll('.includeArt-collab img').forEach((img) => {
  console.log('Attaching click event to:', img);
});

//validation in requesting an exhibit
//solo
document.getElementById('soloExhibitForm').addEventListener('submit', function (e) {
  const selectedArtworks = document.getElementById('selectedArtworks').value;

  console.log('Selected Artworks:', selectedArtworks);

  if (!selectedArtworks.trim()) { 
      e.preventDefault(); 

      const modal = document.getElementById('artworkValidationModal');
      modal.style.display = 'block';

      const closeModal = document.querySelector('.artwork-modal .artwork-close');
      closeModal.addEventListener('click', () => modal.style.display = 'none');
      window.addEventListener('click', (event) => {
          if (event.target === modal) modal.style.display = 'none';
      });
  }
});


//validation in requesting an exhibit
//collab
document.querySelector('form[name="collabExhibit"]').addEventListener('submit', function (e) {
  const selectedArtworksCollab = document.getElementById('selectedArtworksCollab').value;
  const selectedCollaborators = document.getElementById('selectedCollaboratorsInput').value;

  console.log('Selected Artworks for Collaborative Exhibit:', selectedArtworksCollab);
  console.log('Selected Collaborators:', selectedCollaborators);

  if (!selectedArtworksCollab.trim()) { 
      e.preventDefault(); 

      const artworkModal = document.getElementById('artworkValidationModalCollaborative');
      artworkModal.style.display = 'block';

      const closeArtworkModal = document.querySelector('.artwork-modal-collaborative .artwork-close');
      closeArtworkModal.addEventListener('click', () => artworkModal.style.display = 'none');
      window.addEventListener('click', (event) => {
          if (event.target === artworkModal) artworkModal.style.display = 'none';
      });

      return; 
  }

  if (!selectedCollaborators.trim()) {
      e.preventDefault(); 

      const collaboratorModal = document.getElementById('collaboratorValidationModal');
      collaboratorModal.style.display = 'block';
    
      const closeCollaboratorModal = document.querySelector('.collaborator-modal .collaborator-close');
      closeCollaboratorModal.addEventListener('click', () => collaboratorModal.style.display = 'none');
      window.addEventListener('click', (event) => {
          if (event.target === collaboratorModal) collaboratorModal.style.display = 'none';
      });
      return; 
  }
});


//search collaboratots
let debounceTimeout;

function searchCollaborators(query) {
    const searchResultsDiv = document.getElementById("searchResults");
    searchResultsDiv.innerHTML = ""; 

    if (query.length === 0) {
        searchResultsDiv.innerHTML = '';
        return; 
    }
    searchResultsDiv.innerHTML = '<p>Loading...</p>'; 
    clearTimeout(debounceTimeout);

    debounceTimeout = setTimeout(() => {
        
        fetch('dashboard.php?query=' + encodeURIComponent(query))
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch data');
                }
                return response.json(); 
            })
            .then(data => {
              console.log(data); 
          
              searchResultsDiv.innerHTML = '';
              
              if (data.length === 1 && data[0].name === 'No collaborators found.') {
                  searchResultsDiv.innerHTML = '<p>No collaborators found.</p>';
                  return;
              }
          
              data.forEach(collaborator => {
                  const div = document.createElement('div');
                  div.classList.add('collab-item');
          
                  const span = document.createElement('span');
                  span.classList.add('collab-name');
                  span.textContent = collaborator.name;
          
                  const button = document.createElement('button');
                  button.classList.add('select-collab-btn');
                  button.textContent = 'Select';
                  button.onclick = function() {
                      console.log(collaborator); 
                      selectCollaborator(collaborator.name, collaborator.u_id); 
                  };
          
                  div.appendChild(span);
                  div.appendChild(button);
                  searchResultsDiv.appendChild(div);
              });
          })
          
            .catch(error => {
                searchResultsDiv.innerHTML = '<p>Error fetching data: ' + error.message + '</p>';
            });
    }, 300);  
}
function selectCollaborator(name, u_id) {
  console.log("Collaborator Selected:", name, u_id);  

  const selectedCollaboratorsDiv = document.getElementById("selectedCollaborators");
  const selectedCollaboratorsInput = document.getElementById("selectedCollaboratorsInput");

  const selectedCollaborators = selectedCollaboratorsInput.value ? selectedCollaboratorsInput.value.split(',') : [];

  // Restrict selection to 5 collaborators
  if (selectedCollaborators.length >= 5) {
      alert("You can only select up to 5 collaborators.");
      return;
  }

  if (selectedCollaboratorsDiv.innerHTML.includes(name)) {
      alert("This collaborator is already selected.");
      return;
  }

  const collaboratorItem = document.createElement("div");
  collaboratorItem.classList.add("selected-collaborator");
  collaboratorItem.textContent = name;

  const removeBtn = document.createElement("button");
  removeBtn.textContent = "Remove";
  removeBtn.classList.add("remove-collab-btn");
  removeBtn.onclick = function() {
      removeCollaborator(collaboratorItem, u_id);
  };

  collaboratorItem.appendChild(removeBtn);
  selectedCollaboratorsDiv.appendChild(collaboratorItem);

  selectedCollaborators.push(u_id); 
  selectedCollaboratorsInput.value = selectedCollaborators.join(',');
}


function removeCollaborator(collaboratorItem, u_id) {
  const selectedCollaboratorsDiv = document.getElementById("selectedCollaborators");
  const selectedCollaboratorsInput = document.getElementById("selectedCollaboratorsInput");

  selectedCollaboratorsDiv.removeChild(collaboratorItem);

  let selectedCollaborators = selectedCollaboratorsInput.value.split(',');
  selectedCollaborators = selectedCollaborators.filter(id => id !== u_id);
  selectedCollaboratorsInput.value = selectedCollaborators.join(',');

  console.log('Selected Collaborators Input Value after Removal:', selectedCollaboratorsInput.value); 
}



//upload profile picture modal
const uploadBtn = document.getElementById("uploadProfileBtn");
const modalProfile = document.getElementById("profileModal");
const closeModal = document.getElementById("profilecloseModal");

uploadBtn.addEventListener("click", function() {
    modalProfile.style.display = "flex";
});
closeModal.addEventListener("click", function() {
    modalProfile.style.display = "none";
});

window.addEventListener("click", function(event) {
    if (event.target === modalProfile) {
        modalProfile.style.display = "none";
    }
});

function previewImage(event) {
    const file = event.target.files[0];
    const previewContainer = document.getElementById("imagePreviewContainer");
    const imagePreview = document.getElementById("imagePreview");

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            imagePreview.src = e.target.result;
            previewContainer.style.display = "block"; 
        };
        reader.readAsDataURL(file);
    }
}

function removeProfilePic() {
    const imagePreview = document.getElementById("imagePreview");
    const previewContainer = document.getElementById("imagePreviewContainer");
    const fileInput = document.getElementById("profilePicture");

    previewContainer.style.display = "none";
    imagePreview.src = "";

    fileInput.value = "";
}

function removeProfilePic() {
    const imagePreview = document.getElementById("imagePreview");
    const previewContainer = document.getElementById("imagePreviewContainer");
    const fileInput = document.getElementById("profilePicture");

    previewContainer.style.display = "none";
    imagePreview.src = "";
    
    fileInput.value = "";
}

// soloReuqest page
