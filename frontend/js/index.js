// Function to handle SPA navigation (for sections within the same page)
const navigateTo = (page) => {
    const sections = document.querySelectorAll('.content-section');
    sections.forEach(section => section.style.display = 'none'); // Hide all sections

    const selectedSection = document.getElementById(page); // Get the selected section
    if (selectedSection) {
        selectedSection.style.display = 'block'; // Show the selected section
        history.pushState({ page }, "", `#${page}`); // Update the URL hash
    }

    toggleHomeSlider(); // Ensure slider visibility is updated
};

// Ensure the page loads with the correct section visible
window.addEventListener('load', () => {
    const hash = window.location.hash.substring(1); // Get the current hash
    navigateTo(hash || 'home'); // Navigate to the correct section
});

// Function to redirect to separate login/register pages
const redirectToAuth = (page) => {
    window.location.href = page; 
};


// Function to toggle the home slider based on section visibility
function toggleHomeSlider() {
    const homeSection = document.getElementById("home");
    const slider = document.querySelector(".homepage-slider");
    if (!slider || !homeSection) return;
    const isHomeVisible = homeSection.style.display !== "none";

    if (isHomeVisible) {
        slider.style.display = "block";
    } else {
        slider.style.display = "none";
    }
}

// Hide slider forcefully when clicking any nav link
document.body.addEventListener("click", (event) => {
    const target = event.target.closest("a");
    if (target) {
        toggleHomeSlider(); // Update slider state after clicking any nav link
    }
});

// Run initially
document.addEventListener("DOMContentLoaded", () => {
    attachEventListeners();
    toggleHomeSlider();
});

//--------------------------------------------------------------
function toggleHomeSlider() {
    const homeSection = document.getElementById("home");
    const slider = document.querySelector(".homepage-slider");

    if (homeSection && homeSection.style.display !== "none") {
        slider.style.display = "block"; // Show slider when Home is active
    } else {
        slider.style.display = "none"; // Hide slider on other sections
    }
}
toggleHomeSlider();

// Observe changes in the content visibility
document.addEventListener("click", function(event) {
    setTimeout(toggleHomeSlider, 100); // Delay to allow SPA navigation to update
});

//--------------------------------------------------------------
document.addEventListener("DOMContentLoaded", function () {
    let currentPage = 1;
    const totalPages = 3; // Change this if you have more pages

    function updatePagination() {
        const paginationLinks = document.querySelectorAll("#pagination li a");
        paginationLinks.forEach(link => link.classList.remove("active"));

        // Set the active class for the current page
        paginationLinks.forEach(link => {
            if (parseInt(link.textContent) === currentPage) {
                link.classList.add("active");
            }
        });

        // Disable prev/next buttons when at the limits
        document.getElementById("prevBtn").style.pointerEvents = currentPage === 1 ? "none" : "auto";
        document.getElementById("nextBtn").style.pointerEvents = currentPage === totalPages ? "none" : "auto";
    }

    window.changePage = function (page) {
        if (page === "prev" && currentPage > 1) {
            currentPage--;
        } else if (page === "next" && currentPage < totalPages) {
            currentPage++;
        } else if (typeof page === "number") {
            currentPage = page;
        }

        updatePagination();

        // Perform content update logic here (e.g., fetch new page data)
        console.log("Page changed to:", currentPage);
    };

    // Initialize pagination
    updatePagination();
});