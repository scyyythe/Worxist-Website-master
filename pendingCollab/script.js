//VIEW FOLDER IMGS
document.addEventListener("DOMContentLoaded", function () {
    const adminCards = document.querySelectorAll(".admin-card, .collaborator");
    const modal = document.getElementById("image-modal");
    const modalImage = modal.querySelector(".modal-image");
    const replaceContainer = modal.querySelector(".replace-container");
    const leftBtn = modal.querySelector(".left-btn");
    const rightBtn = modal.querySelector(".right-btn");
    const replaceInput = document.getElementById("replace-input");

    let currentImages = []; 
    let currentIndex = 0;   

    // Function to open the modal and display the first image
    function openModal(images) {
        modal.style.display = "flex"; 
        currentImages = images; 
        currentIndex = 0; 
        updateModalContent(); // Display the current image and "Replace" text
    }

    // Function to update the modal content (image and "Replace" text)
    function updateModalContent() {
        modalImage.src = currentImages[currentIndex].src; 

        // Attach a click event to "Replace" text
        const replaceText = replaceContainer.querySelector(".replace-text");
        replaceText.addEventListener("click", function () {
            replaceInput.click(); // Trigger file input
        });

        // Handle file input change
        replaceInput.addEventListener("change", function () {
            if (replaceInput.files && replaceInput.files[0]) {
                const reader = new FileReader();

                // Load the new image
                reader.onload = function (e) {
                    const newSrc = e.target.result;

                    // Update the current image in the modal and folder
                    currentImages[currentIndex].src = newSrc;
                    modalImage.src = newSrc;
                };

                reader.readAsDataURL(replaceInput.files[0]); // Read the file
            }
        });
    }

    // Event listener for each admin-card or collaborator
    for (let i = 0; i < adminCards.length; i++) {
        adminCards[i].addEventListener("click", function () {
            const images = adminCards[i].querySelectorAll("img"); 
            if (images.length > 0) {
                openModal(images); // Open modal with images
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
        updateModalContent(); // Update modal content
    });

    // Navigate to the next image
    rightBtn.addEventListener("click", function () {
        if (currentIndex < currentImages.length - 1) {
            currentIndex++;
        } else {
            currentIndex = 0; 
        }
        updateModalContent(); // Update modal content
    });
});



//EDIT (PENCIL)
document.addEventListener("DOMContentLoaded", function () {
    // Get all the pencil icons
    const pencils = document.querySelectorAll(".bxs-pencil");

    // Loop through each pencil icon
    for (let i = 0; i < pencils.length; i++) {
        pencils[i].addEventListener("click", function () {
            // Find the sibling input or textarea element within the same div
            const parentDiv = pencils[i].parentNode; // Get the parent of the pencil icon
            let inputElement = parentDiv.querySelector("input, textarea");

            if (inputElement) {
                // Toggle the disabled property
                if (inputElement.disabled) {
                    inputElement.disabled = false; // Enable editing
                    inputElement.focus(); // Focus the element
                    pencils[i].style.color = "green"; // Optional: Change pencil color to green
                } else {
                    inputElement.disabled = true; // Disable editing
                    pencils[i].style.color = ""; // Reset pencil color
                }
            }
        });
    }
});

// cancel request
document.getElementById("cancel-btn").addEventListener("click", function() {
    document.getElementById("cancelConfirmationModal").style.display = "flex";
});
document.getElementById("closeCancel").addEventListener("click", function() {
    document.getElementById("cancelConfirmationModal").style.display = "none";
});

document.getElementById("confirmCancel").addEventListener("click", function() {
    document.getElementById("cancelConfirmationModal").style.display = "none";
    let formData = new FormData();
    formData.append('cancelRequest', true);

    fetch("collabRequest.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById("alertMessage").textContent = "Exhibit request cancelled successfully.";
            document.getElementById("customAlert").style.display = "block";
        } else {
            document.getElementById("alertMessage").textContent = "Error: " + data.error;
            document.getElementById("customAlert").style.display = "block";
        }
    })
    .catch(error => {
        document.getElementById("alertMessage").textContent = "An error occurred: " + error;
        document.getElementById("customAlert").style.display = "block";
    });
});

document.getElementById("alertClose").addEventListener("click", function() {
    document.getElementById("customAlert").style.display = "none";
    // window.location.href = "../dashboard.php";  
});

