document.addEventListener("DOMContentLoaded", function() {
    const contactForm = document.getElementById('bee-contact');

    if (contactForm) {
        contactForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent immediate form submission
            if (validateContactForm()) {
                // Show success message and optionally redirect
                document.getElementById('form_status').innerHTML = 
                    '<p class="text-success">Your message has been sent successfully.</p>';
                
                setTimeout(() => {
                    contactForm.submit(); // Now submit the form after validation
                }, 1500); // Slight delay to allow user to see the message
            }
        });
    }
});

function validateContactForm() {
    let name = document.getElementById('name').value.trim();
    let email = document.getElementById('email').value.trim();
    let phone = document.getElementById('phone').value.trim();
    let subject = document.getElementById('subject').value.trim();
    let message = document.getElementById('message').value.trim();
    let statusDiv = document.getElementById('form_status');

    // Clear previous status message
    statusDiv.innerHTML = "";

    if (!name || !email || !phone || !subject || !message) {
        statusDiv.innerHTML = '<p class="text-danger">All fields are required.</p>';
        return false;
    }

    // Validate email format
    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!emailPattern.test(email)) {
        statusDiv.innerHTML = '<p class="text-danger">Please enter a valid email address.</p>';
        return false;
    }
    return true; 
}
