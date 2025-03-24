function confirmDelete() {
    let confirmation = confirm("Are you sure you want to delete this product?");
    if (confirmation) {
        alert("Product deleted successfully.");
    }
}

function navigateTo(page) {
    // Hide all sections
    document.querySelectorAll(".content-section").forEach(section => {
        section.style.display = "none";
    });

    // Show the selected section
    const targetSection = document.getElementById(page);
    if (targetSection) {
        targetSection.style.display = "block";
    } else {
        console.error(`Section #${page} not found!`);
    }

    // Update URL without reloading (optional for better SPA behavior)
    history.pushState({}, "", `#${page}`);
}

// Ensure the correct page loads on back/forward navigation
window.addEventListener("popstate", function () {
    const page = location.hash.replace("#", "") || "home";
    navigateTo(page);
});

// On first load, navigate to the correct section
document.addEventListener("DOMContentLoaded", function () {
    const page = location.hash.replace("#", "") || "home";
    navigateTo(page);
});
