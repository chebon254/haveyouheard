// Wait for the DOM to load
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contact-form');
    const messageDiv = document.getElementById('contact-message');

    form.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        // Create a new FormData object with the form data
        const formData = new FormData(form);

        // Create an AJAX request
        const xhr = new XMLHttpRequest();
        xhr.open('POST', './admin/contact.php', true);

        // Handle the AJAX response
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                // Display the response message
                messageDiv.textContent = xhr.responseText;
                form.reset(); // Reset the form after successful submission
            }
        };

        // Send the AJAX request with the form data
        xhr.send(formData);
    });
});