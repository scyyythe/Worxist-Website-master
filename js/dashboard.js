
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

document.addEventListener("DOMContentLoaded", function () {
  const button = document.getElementById("viewExhibit-btn");
  const button2 = document.getElementById("viewExhibit-accepted");

  if (button) {
    button.addEventListener("click", function(event) {
      event.preventDefault(); 

      const exbtType = this.getAttribute("data-exbt-type"); 
      console.log("Pending Exhibit type:", exbtType); 

      if (exbtType === 'Solo') {
        window.location.href = "soloRequest.php";
      } else if (exbtType === 'Collaborate') {
        window.location.href = "pendingCollab/collabRequest.php";
      }
    });
  } else {
    console.log("viewExhibit-btn button is not found.");
  }

  if (button2) {
    button2.addEventListener("click", function(event) {
      event.preventDefault(); 

      const exbtType = this.getAttribute("data-exbt-type"); 
      console.log("Accepted Exhibit type:", exbtType); 

      if (exbtType === 'Solo') {
        window.location.href = "acceptedSolo.php";
      } else if (exbtType === 'Collaborate') {
        window.location.href = "pendingCollab/acceptedCollab.php";
      }
    });
  } else {
    console.log("viewExhibit-accepted button is not found.");
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

// Search Bar
document.addEventListener('DOMContentLoaded', () => {
  const categoryLinks = document.querySelectorAll('#dropdown a');
  const artworks = document.querySelectorAll('.box');
  const searchInput = document.querySelector('#search-input');
  const searchIcon = document.querySelector('.search');

  categoryLinks.forEach(link =>
    link.addEventListener('click', event => {
      event.preventDefault();
      filterArtworks(link.getAttribute('data-category'), artworks);
    })
  );

  searchInput.addEventListener('input', () =>
    filterArtworksBySearch(searchInput.value.toLowerCase(), artworks)
  );

  searchIcon.addEventListener('click', () =>
    filterArtworksBySearch(searchInput.value.toLowerCase(), artworks)
  );

  const filterArtworks = (category, artworks) => {
    artworks.forEach(artwork => {
      const matchesCategory = category === 'all' || artwork.getAttribute('data-category') === category;
      artwork.style.display = matchesCategory ? 'block' : 'none';
    });
  };

  const filterArtworksBySearch = (searchTerm, artworks) => {
    artworks.forEach(artwork => {
      const titleElement = artwork.querySelector('.artwork-title');
      const artistElement = artwork.querySelector('.artist-name');
      const title = titleElement ? titleElement.textContent.toLowerCase() : '';
      const artist = artistElement ? artistElement.textContent.toLowerCase() : '';
      const matchesSearch = title.includes(searchTerm) || artist.includes(searchTerm);

      artwork.style.display = matchesSearch ? 'block' : 'none';
    });
  };
});


// FOLLOWERS AND FOLLOWING
// JavaScript for modal functionality
document.addEventListener("DOMContentLoaded", () => {
  const followersLink = document.getElementById("openFollowers");
  const followingLink = document.getElementById("openFollowing");
  const modal = document.getElementById("followers-modal");
  const closeButton = document.querySelector(".close-button");
  const followersContent = document.getElementById("followers-content");
  const followingContent = document.getElementById("following-content");

  // Open Followers Modal
  followersLink.addEventListener("click", (event) => {
    event.preventDefault(); // Prevent page reload
    followersContent.style.display = "block";
    followingContent.style.display = "none";
    modal.style.display = "block";
  });

  // Open Following Modal
  followingLink.addEventListener("click", (event) => {
    event.preventDefault(); // Prevent page reload
    followersContent.style.display = "none";
    followingContent.style.display = "block";
    modal.style.display = "block";
  });

  // Close Modal
  closeButton.addEventListener("click", () => {
    modal.style.display = "none";
  });

  // Close Modal When Clicking Outside of It
  window.addEventListener("click", (event) => {
    if (event.target === modal) {
      modal.style.display = "none";
    }
  });
});

document.addEventListener("DOMContentLoaded", () => {
  const followButton = document.querySelector(".follow-btn");
  const followedId = followButton.getAttribute("data-followed-id"); 
  followButton.addEventListener("click", () => {
    const isFollowing = followButton.textContent.trim() === "Unfollow";
    const action = isFollowing ? "unfollow" : "follow";

    fetch("../class/follow.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: `action=${action}&followed_id=${followedId}`,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          followButton.textContent = isFollowing ? "Follow" : "Unfollow";
        } else {
          alert(data.message);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  });
});

// Get the modal notifaction
var notifModal = document.getElementById('notifModal');
var viewAllNotifications = document.getElementById('viewAllNotifications');
var notifClosebtn = document.getElementById('notifClosebtn');

viewAllNotifications.onclick = function(event) {
    event.preventDefault(); 
    notifModal.style.display = 'block';
}
notifClosebtn.onclick = function() {
    notifModal.style.display = 'none';
}

window.onclick = function(event) {
    if (event.target == notifModal) {
        notifModal.style.display = 'none';
    }
}

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

// description of exhibit
document.addEventListener('DOMContentLoaded', () => {
  const descriptionTrigger = document.querySelector('.viewDescription');
  const popup = document.querySelector('.exhibition-description-popup');
  const closePopup = document.querySelector('.exhibition-close-popup');

  descriptionTrigger.addEventListener('click', () => {
      popup.style.display = 'block';
  });

  closePopup.addEventListener('click', () => {
      popup.style.display = 'none';
  });

  window.addEventListener('click', (event) => {
      if (event.target === popup) {
          popup.style.display = 'none';
      }
  });
});

// search artist name and title of artowrk
document.querySelector('.search').addEventListener('click', function () {
  const query = document.querySelector('.bar').value;
  fetch(`/dashboard.php?search=${encodeURIComponent(query)}`)
      .then(response => response.json())
      .then(data => {
          console.log(data); // Debugging
          const resultsContainer = document.querySelector('.results-container');
          resultsContainer.innerHTML = '';
          data.forEach(item => {
              const result = document.createElement('div');
              result.innerHTML = `
                  <h3>${item.artwork_title}</h3>
                  <p>By: ${item.artist_name}</p>
                  <p>${item.description}</p>
                  <p>Category: ${item.category}</p>
                  <img src="../${item.file}" alt="${item.artwork_title}" style="max-width: 200px;">
                  <p>Date: ${item.date}</p>
              `;
              resultsContainer.appendChild(result);
          });
      })
      .catch(error => console.error('Error:', error));
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
  const comments = element.getAttribute('data-comments'); 
  const status = element.getAttribute('data-status');

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
  document.querySelector('.noHeart').innerText = liked;
  document.querySelector('.noBookmark').innerText = saved;
  document.querySelector('.noFavorite').innerText = favorite;

  const commentDisplay = document.querySelector('.comment-display'); 

  if (comments && comments !== '[]') {
    commentDisplay.innerHTML = '';  

    const commentArray = comments.split(','); 
    commentArray.forEach(comment => {
      const [userName, commentText, userImage] = comment.split('::');  

      if (userName && commentText && userImage) {
        const commentWrapper = document.createElement('div');
        commentWrapper.classList.add('comment-display');

        const userImageWrapper = document.createElement('div');
        userImageWrapper.classList.add('user-image');

        const profilePicWrapper = document.createElement('div');
        profilePicWrapper.classList.add('profile-pic');

        const imgElement = document.createElement('img');
        const cleanedImage = (userImage && typeof userImage === 'string') ? userImage.replace(/^\/+|"+$/g, '') : ''; 

        const imagePath = `./profile_pics/${cleanedImage}`;
        console.log("Image path: ", imagePath);

        imgElement.src = imagePath;
        imgElement.alt = 'Profile Picture';

        imgElement.onerror = () => {
          imgElement.src = './gallery/eyes.jpg'; 
        };

        profilePicWrapper.appendChild(imgElement);

        const userNameElement = document.createElement('h5');
        userNameElement.innerText = userName;

        userImageWrapper.appendChild(profilePicWrapper);
        userImageWrapper.appendChild(userNameElement);

        const commentWrapperElement = document.createElement('div');
        commentWrapperElement.classList.add('comment');

        const commentTextElement = document.createElement('p');
        commentTextElement.innerText = commentText;

        commentWrapperElement.appendChild(commentTextElement);

        commentWrapper.appendChild(userImageWrapper);
        commentWrapper.appendChild(commentWrapperElement);

        commentDisplay.appendChild(commentWrapper);
      }
    });
  } else {
    commentDisplay.innerHTML = "<p>No comments available.</p>";
  }

  
  // edit option
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

  // Close popup functionality
  popup.style.display = 'flex';
  setTimeout(() => {
    popup.classList.add('active');
  }, 0);

  blur.classList.add('active');
  
  resetIconStates();
   // Handle like, save, and favorite actions
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

  initializeIconStates(artworkId);

  function closePopup(event) {
    if (!popup.contains(event.target) && !element.contains(event.target)) {
      popup.style.display = 'none';
      blur.classList.remove('active');
      document.removeEventListener('click', closePopup); 
    }
  }

  document.addEventListener('click', closePopup);
}
function resetIconStates() {
  // Remove 'liked', 'saved', and 'favorited' states from all other artwork icons
  const allLikeIcons = document.querySelectorAll('.like-icon');
  allLikeIcons.forEach(icon => icon.classList.remove('liked'));
  
  const allBookmarkIcons = document.querySelectorAll('.bookmark-icon');
  allBookmarkIcons.forEach(icon => icon.classList.remove('saved'));

  const allFavoriteIcons = document.querySelectorAll('.favorite-icon');
  allFavoriteIcons.forEach(icon => icon.classList.remove('favorited'));
}

function initializeIconStates(artworkId) {
  fetch(`../class/interaction.php?action=getStates&a_id=${artworkId}`)
    .then(response => response.json())
    .then(data => {
        if (data) {
            const artworkElement = document.querySelector(`[data-artwork-id="${artworkId}"]`);

            if (artworkElement) {
                const likeIcon = artworkElement.querySelector('.like-icon');
                const bookmarkIcon = artworkElement.querySelector('.bookmark-icon');
                const favoriteIcon = artworkElement.querySelector('.favorite-icon');

                if (likeIcon && data.liked) {
                    likeIcon.classList.add('liked');
                    likeIcon.style.color = 'red'; 
                } else {
                    likeIcon.classList.remove('liked');
                    likeIcon.style.color = ''; 
                }

                if (bookmarkIcon && data.saved) {
                    bookmarkIcon.classList.add('saved');
                    bookmarkIcon.style.color = 'yellow'; 
                } else {
                    bookmarkIcon.classList.remove('saved');
                    bookmarkIcon.style.color = ''; 
                }

                if (favoriteIcon && data.favorited) {
                    favoriteIcon.classList.add('favorited');
                    favoriteIcon.style.color = 'gold'; 
                } else {
                    favoriteIcon.classList.remove('favorited');
                    favoriteIcon.style.color = ''; 
                }
            }
        }
    })
    .catch(error => {
        console.error('Error fetching icon states:', error);
    });
}


async function updateDatabase(action, artworkId, newCount) {
  try {
    const response = await fetch('../class/interaction.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ action: action, a_id: artworkId, newCount: newCount })
    });
    const data = await response.json();
    if (!data.success) {
      console.error('Error updating database');
    } else {
      console.log(`${action} updated successfully!`);
    }
  } catch (error) {
    console.error('Error:', error);
  }
}

//insert comment
document.addEventListener("DOMContentLoaded", function () {
  const commentBtn = document.querySelector('.comment-btn');

  if (commentBtn) {
  
    if (!commentBtn.hasAttribute('data-listener')) {
      commentBtn.addEventListener('click', submitComment);
      commentBtn.setAttribute('data-listener', 'true'); 
    }
  } else {
    console.log("Comment button is not found.");
  }
});

// Comment function
function submitComment() {
  const comment = document.getElementById('comment').value;
  const artworkId = document.querySelector('.social-interact-icons').getAttribute('data-artwork-id');
  const userId = document.getElementById('userId').value;

  if (comment.trim() === '') {
    alert('Comment cannot be empty!');
    return;
  }

  fetch('../class/submitComment.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ comment, artworkId, userId })
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
     
      const commentDisplay = document.querySelector('.interaction');
      const newComment = `
        <div class="comment-display">
          <div class="user-image">
            <div class="profile-pic">
              <img src="${data.userImage}" alt="Profile Picture">
            </div>
            <h5>${data.username}</h5>
          </div>
          <div class="comment">
            <p>${data.content}</p>
          </div>
        </div>`;
        
      commentDisplay.insertAdjacentHTML('beforeend', newComment);
      document.getElementById('comment').value = ''; 
    } else {
      console.error('Failed to post comment. Server response:', data);
      alert(data.message || 'Failed to post comment.');
    }
  })
  .catch(error => console.error('Error occurred while submitting the comment:', error));
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
//validation in requesting an exhibit
// Validation for solo exhibit
document.addEventListener('DOMContentLoaded', function () {
  const soloExhibitForm = document.getElementById('soloExhibitForm');
  const selectedArtworks = document.getElementById('selectedArtworks');
  const artworkValidationModal = document.getElementById('artworkValidationModal');
  const closeModal = document.querySelector('.artwork-modal .artwork-close');

  if (soloExhibitForm) {
    soloExhibitForm.addEventListener('submit', function (e) {
      console.log('Selected Artworks:', selectedArtworks ? selectedArtworks.value : '');

      if (!selectedArtworks || !selectedArtworks.value.trim()) {
          e.preventDefault();
          if (artworkValidationModal) {
              artworkValidationModal.style.display = 'block';
          }

          if (closeModal) {
              closeModal.addEventListener('click', () => {
                  if (artworkValidationModal) artworkValidationModal.style.display = 'none';
              });
          }

          window.addEventListener('click', (event) => {
              if (artworkValidationModal && event.target === artworkValidationModal) {
                  artworkValidationModal.style.display = 'none';
              }
          });
      }
    });
  }
});


// Validation for date in solo exhibit
document.getElementById('soloExhibitForm').addEventListener('submit', function(event) {
  const selectedDate = document.getElementById('exhibit-date').value;
  const data = new FormData();
  data.append('date', selectedDate);

  fetch('/dashboard.php', {
      method: 'POST',
      body: data
  })
  .then(response => response.json())
  .then(data => {
      const messageElement = document.getElementById('date-validation-message');
      const submitButton = document.getElementById('solo-btn');

      if (data.isTaken) {
          event.preventDefault();
          messageElement.textContent = 'This date is taken, please choose another date.';
          messageElement.style.color = 'red';
          messageElement.style.fontSize = '12px';
          submitButton.disabled = true;
      } else {
          messageElement.textContent = '';
          submitButton.disabled = false;
          alert('Exhibit Requested Successfully')
      }
  })
  .catch(error => {
      console.error('Error:', error);
  });
});

// Reset validation for solo exhibit date
document.getElementById('exhibit-date').addEventListener('change', function() {
  const submitButton = document.getElementById('solo-btn');
  const messageElement = document.getElementById('date-validation-message');
  messageElement.textContent = '';
  submitButton.disabled = false;
});


//validation in requesting an exhibit
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

// Date validation for collaborative exhibit
document.getElementById('collabExhibitForm').addEventListener('submit', function(event) {
  const submitButton = document.getElementById('collab-btn');
  if (submitButton.disabled) {
      event.preventDefault();
      return;
  }

  const selectedDate = document.getElementById('exhibit-date-collab').value;
  const data = new FormData();
  data.append('date', selectedDate);

  fetch('/dashboard.php', {
      method: 'POST',
      body: data
  })
  .then(response => response.json())
  .then(data => {
      const messageElement = document.getElementById('date-validation-message-collab');
      if (data.isTaken) {
          event.preventDefault(); 
          messageElement.textContent = 'This date is taken, please choose another date.';
          messageElement.style.color = 'red';
          messageElement.style.fontSize = '12px';
          submitButton.disabled = true;
      } else {
          messageElement.textContent = ''; 
          submitButton.disabled = false; 
          alert('Exhibit Requested Successfully')
      }
  })
  .catch(error => {
      console.error('Error:', error); 
  });
});

// Reset validation for collaborative exhibit date
document.getElementById('exhibit-date-collab').addEventListener('change', function() {
  const submitButton = document.getElementById('collab-btn');
  const messageElement = document.getElementById('date-validation-message-collab');
  messageElement.textContent = '';
  submitButton.disabled = false;
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

document.addEventListener('DOMContentLoaded', function () {
  const logoutButton = document.querySelector('.logoutButton');
  const logoutModal = document.getElementById('logoutModal');
  const logoutModalCancel = document.getElementById('logoutModalCancel');
  const logoutModalConfirm = document.querySelector('.logoutModal-confirm');

  // Show the logout modal
  if (logoutButton) {
      logoutButton.addEventListener('click', function(e) {
          e.preventDefault(); // Prevent the default action of the anchor tag
          logoutModal.style.display = 'flex';  // Show the modal
      });
  }

  // Hide the logout modal when cancel button is clicked
  if (logoutModalCancel) {
      logoutModalCancel.addEventListener('click', function() {
          logoutModal.style.display = 'none'; // Hide the modal
      });
  }

  // Redirect to logout.php when "Yes" is clicked
  if (logoutModalConfirm) {
      logoutModalConfirm.addEventListener('click', function() {
          window.location.href = './logout.php'; // Redirect to logout.php
      });
  }
});
