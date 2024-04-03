// Wait for the DOM to load
document.addEventListener('DOMContentLoaded', function() {
    const newsletterForm = document.getElementById('newsletter-form');
    const newsletterMessageDiv = document.getElementById('newsletter-message');

    newsletterForm.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        // Create a new FormData object with the form data
        const formData = new FormData(newsletterForm);

        // Create an AJAX request
        const xhr = new XMLHttpRequest();
        xhr.open('POST', './admin/newsletter.php', true);

        // Handle the AJAX response
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                // Display the response message
                newsletterMessageDiv.textContent = xhr.responseText;
                newsletterForm.reset(); // Reset the form after successful submission
            }
        };

        // Send the AJAX request with the form data
        xhr.send(formData);
    });
});