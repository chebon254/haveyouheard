<?php
include 'database.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch contact form data
$sql_contacts = "SELECT id, name, email, message, message_sent FROM contacts";
$result_contacts = $conn->query($sql_contacts);

// Fetch newsletter subscription data
$sql_newsletter = "SELECT id, email, campaign_sent FROM newsletter";
$result_newsletter = $conn->query($sql_newsletter);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link rel="icon shortcut" href="css/img/Logo.png">
    <link rel="stylesheet" href="css/style.css">

    <!-- == Font == -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- == Icons == -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" crossorigin="anonymous" />
    <style>
        body{
            position: relative;
        }
        /* Popup container */
.popup-container {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
    z-index: 9999;
}

/* Popup */
.popup {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: white;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
}

/* Popup title */
.popup h2 {
    margin-top: 0;
}

/* Popup buttons */
.button-container {
    margin-top: 20px;
}

.confirm-btn,
.cancel-btn {
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
}

.confirm-btn {
    background-color: #333;
    color: white;
}

.cancel-btn {
    background-color: #ddd;
    color: #333;
    margin-left: 10px;
}

    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get the delete button
            var deleteBtn = document.getElementById("deleteAllBtn");

            // Get the delete popup
            var deletePopup = document.getElementById("deletePopup");

            // Get the confirm and cancel buttons inside the popup
            var confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
            var cancelDeleteBtn = document.getElementById("cancelDeleteBtn");

            // When the delete button is clicked, show the popup
            deleteBtn.addEventListener("click", function() {
                deletePopup.style.display = "block";
            });

            // When the confirm button inside the popup is clicked, delete all data and show success message
            confirmDeleteBtn.addEventListener("click", function() {
                deleteAllData();
                var successText = document.createElement("span");
                successText.textContent = "Success deletion!";
                successText.style.marginLeft = "10px";
                successText.style.color = "green";
                deletePopup.appendChild(successText);
                setTimeout(function() {
                    deletePopup.style.display = "none";
                    deletePopup.removeChild(successText);
                }, 4000); // 4 seconds
            });

            // When the cancel button inside the popup is clicked, close the popup
            cancelDeleteBtn.addEventListener("click", function() {
                deletePopup.style.display = "none";
            });
        });

        // Function to delete all data from the database
        function deleteAllData() {
            // Send AJAX request to delete all data from the database
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "delete_all_data.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    // Change button text to "Success deletion!" upon successful deletion
                    var confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
                    if (confirmDeleteBtn) {
                        confirmDeleteBtn.textContent = "Success deletion!";
                        // Optionally, you can refresh the page or update the UI after deletion
                        // For example, you can add window.location.reload(); to refresh the page
                    } else {
                        console.error("Confirm delete button not found!");
                    }
                }
            };
            xhr.send();
        }
    </script>
</head>
<body>
<nav>
        <div class="container">
            <div class="logged-user">
                <span>Hi, </span>
                <span><?php echo $_SESSION['username']; ?>!</span>
                <a href="../index.html" class="go-to-site"><i class="fa-solid fa-eye"></i> View Website</a>
            </div>
            <div class="logged-user">
                <a href="logout.php">Logout?</a>
            </div>
        </div>
    </nav>
    <!-- Delete Confirmation Popup -->
    <div id="deletePopup" class="popup-container">
        <div class="popup">
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete all data?</p>
            <div class="button-container">
                <button id="confirmDeleteBtn" style="margin:5px 0px;" class="confirm-btn">Yes</button>
                <button id="cancelDeleteBtn" style="margin: 5px 0px;" class="cancel-btn">Cancel</button>
            </div>
        </div>
    </div>

    <div>
        <div class="container">
            <!-- Tabs for contact form and newsletter -->
            <div class="tab-link-btns">
                <button class="tablink" onclick="openTab(event, 'contacts')" id="defaultOpen"><i class="fa-solid fa-paper-plane"></i> Contacts</button>
                <button class="tablink" onclick="openTab(event, 'newsletter')"><i class="fa-brands fa-mailchimp"></i> Newsletters</button>
            </div>


        <!-- Tab content for contacts -->
        <div id="contacts" class="tabcontent">
            <h3>Contact Form Data</h3>
            <table>
                <tr>
                    <th>No.</th>
                    <th>Unique Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>View</th>
                </tr>
                <?php 
                $rowNumber = 1; // Initialize row number
                while ($row = $result_contacts->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $rowNumber++; ?></td> <!-- Increment and display row number -->
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo substr($row['message'], 0, 20) . '...'; ?></td>
                        <td><?php echo $row['message_sent'] ? '<i class="fa-solid fa-check"></i>' : '<i class="fa-solid fa-times"></i>'; ?></td>
                        <td><button onclick="showDetails(<?php echo $row['id']; ?>)">View</button></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>

        <!-- Tab content for newsletter -->
        <div id="newsletter" class="tabcontent">
            <h3>Newsletter Subscription Data</h3>
            <div class="bulk-actions">
                <!-- Download all data to Excel -->
                <button onclick="downloadAllToExcel()"><i class="fa-solid fa-sheet-plastic"></i> Download All to Excel</button>
                <!-- Delete all data from the database -->
                <button id="deleteAllBtn"><i class="fa-solid fa-trash"></i> Delete All Data</button>
            </div>
            <style>
                .bulk-actions{
                    display: flex;
                    align-items: center;
                    justify-content: flex-start;
                }
                .bulk-actions button{
                    width: fit-content;
                    margin: 10px 10px 10px 0px;
                    padding: 10px 20px;
                }
            </style>
            <table>
                <tr>
                    <th>No</th>
                    <th>Unique id</th>
                    <th>Email</th>
                    <th></th>
                    <th>Status</th>
                    <th>Update Status!</th>
                </tr>
                <?php 
                $rowNumber = 1; // Initialize row number
                while ($row = $result_newsletter->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $rowNumber++; ?></td> <!-- Increment and display row number -->
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td>
                            <button stylee="position:relative;" onclick="copyNewsletterEmail('<?php echo $row['email']; ?>', <?php echo $row['id']; ?>)" class="modal-copy" id="copyEmailBtn_<?php echo $row['id']; ?>">
                                <i class="fa-regular fa-copy"></i>
                                <span style="position:absolute; right: -80%; top:5px;font-size: 12px;" id="tooltipText_<?php echo $row['id']; ?>"></span>
                            </button>
                        </td>
                        <td><?php echo $row['campaign_sent'] ? '<i class="fa-solid fa-check"></i>' : '<i class="fa-solid fa-times"></i>'; ?></td>
                        <td>
                            <form class="campaignSentForm" action="" style="background-color: #00000000;padding: 0px; box-shadow: none;">
                                <input type="checkbox" onchange="updateNewsletterStatus(<?php echo $row['id']; ?>, this)">
                                <button type="button" id="submitBtn_<?php echo $row['id']; ?>" class="news-btn newsletterbutton" style="border: 0px; height: 30px; margin-left: 10px; background-color: #00000000;width: fit-content; margin-top: 0px; padding: 5px 10px; cursor: pointer;">Submit</button>
                            </form>
                            <style>
                                button.news-btn:hover{
                                    background-color: #FF609A !important;
                                    color: #ffffff !important;
                                }
                            </style>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
        </div>
    </div>

    <!-- Modal for displaying contact details -->
    <div id="detailsModal" class="modal">
        <div class="modal-content">
            <button id="close-modal" class="close close-modal-btn"><i class="fa-solid fa-xmark"></i></button>
            <h3>Contact Details</h3>
            <br>
            <br>
            <h4>Name</h4>
            <p id="modalName"></p>
            <br>
            <h4>Email</h4>
            <div class="modal-email-container">
                <span id="modalEmail"></span>
                <button id="copyEmailBtn" class="modal-copy">
                    <i class="fa-regular fa-copy"></i>
                    <span style="font-size: 12px;" id="tooltipText"></span>
                </button>
            </div>
            <br>
            <h4>Message</h4>
            <p id="modalMessage"></p>
            <br>
            <br>
            <br>
            <form id="messageSentForm" class="modal" style="padding: 0px; box-shadow: none;">
                <h4>Reply Status</h4>
                <br>
                <label for="reply-satus">
                <input type="checkbox" id="messageSentCheckbox"> Confirm! After replying
                </label>
                <br>
                <button type="submit" class="contactbutton" style="width: fit-content; margin-top: 20px; padding: 10px 20px;">Submit!</button>
            </form>
        </div>
    </div>

    <script>
    // JavaScript for tabs and modal functionality
    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablink");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    document.getElementById("defaultOpen").click();

    // Get the modal
    var modal = document.getElementById("detailsModal");

    // Get the <span> element that closes the modal
    var closeModalBtn = document.getElementsByClassName("close-modal-btn")[0];

    var messageSentForm = document.getElementById("messageSentForm");
    var campaignSentForm = document.getElementById("campaignSentForm");

    // When the user clicks on the button, open the modal and fetch contact details
    function showDetails(id) {
        currentContactId = id;
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                var contactDetails = JSON.parse(this.responseText);
                document.getElementById('modalName').textContent = contactDetails.name;
                document.getElementById('modalEmail').textContent = contactDetails.email;
                document.getElementById('modalMessage').textContent = contactDetails.message;
                document.getElementById('messageSentCheckbox').checked = contactDetails.message_sent;
                modal.style.display = "block";
            }
        };
        xhr.open('GET', 'fetch_contact_details.php?id=' + id, true);
        xhr.send();
    }

    // Add event listener for the message sent form
    messageSentForm.addEventListener("submit", function(e) {
        e.preventDefault();
        var messageSent = document.getElementById("messageSentCheckbox").checked;
        var id = currentContactId;

        // Send an AJAX request to update the message sent status
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "fetch_contact_details.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                // Change button text to "Success" temporarily
                var submitButton = document.querySelector('.contactbutton');
                if (submitButton) {
                    submitButton.textContent = "Success";
                    setTimeout(function() {
                        // Revert button text back to "Submit!" after 4 seconds
                        submitButton.textContent = "Submit!";
                    }, 2000); // 4 seconds
                } else {
                    console.error("Submit button not found!");
                }
            }
        };
        xhr.send("id=" + id + "&messageSent=" + messageSent);
    });

    // Get the copy email button
    var copyEmailBtn = document.getElementById("copyEmailBtn");

    // When the user clicks on the copy email button, copy the email to clipboard
    copyEmailBtn.onclick = function() {
        var emailText = document.getElementById("modalEmail").textContent;
        navigator.clipboard.writeText(emailText).then(function() {
            var tooltipText = document.getElementById("tooltipText");
            tooltipText.style.display = "block";
            tooltipText.innerText = "Copied!";
            setTimeout(function () {
                tooltipText.style.display = "none";
            }, 4000);
        }).catch(function(error) {
            console.error("Unable to copy email: ", error);
        });
    }


    // When the user clicks on <span> (x), close the modal
    closeModalBtn.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
<!-- Add this script at the end of your HTML file -->
<script>
    // Function to copy email to clipboard for newsletter
    function copyNewsletterEmail(email, id) {
        var tooltipText = document.getElementById("tooltipText_" + id);
        copyEmail(email, tooltipText);
    }

    // Generic function to copy email to clipboard
    function copyEmail(email, tooltipText) {
        navigator.clipboard.writeText(email).then(function() {
            tooltipText.textContent = "Copied!";
            setTimeout(function () {
                tooltipText.textContent = "";
            }, 4000);
        }).catch(function(error) {
            console.error("Unable to copy email: ", error);
        });
    }

   // Function to handle newsletter status update
    function updateNewsletterStatus(id, checkbox) {
        var campaignSent = checkbox.checked;

        // Send AJAX request to update newsletter status
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "fetch_newsletter_details.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                // Change button text to "Success" temporarily
                var submitButton = document.querySelector('#submitBtn_' + id);
                if (submitButton) {
                    submitButton.textContent = "Success!";
                    setTimeout(function() {
                        // Revert button text back to "Submit" after 4 seconds
                        submitButton.textContent = "Submit";
                    }, 4000); // 4 seconds
                } else {
                    console.error("Newsletter submit button not found!");
                }
            }
        };
        xhr.send("id=" + id + "&campaignSent=" + campaignSent);
    }

    // Function to download all data to Excel
    function downloadAllToExcel() {
        // Send AJAX request to download all data to Excel
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "download_all_to_excel.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                // Handle the response, such as triggering the download
                console.log("All data downloaded to Excel successfully.");
            }
        };
        xhr.send();
    }

</script>

</body>
</html>
