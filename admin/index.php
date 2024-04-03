<?php
include 'database.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch contact form data
$sql_contacts = "SELECT id, name, email, message FROM contacts";
$result_contacts = $conn->query($sql_contacts);

// Fetch newsletter subscription data
$sql_newsletter = "SELECT id, email FROM newsletter";
$result_newsletter = $conn->query($sql_newsletter);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link rel="icon shortcut" href="css/img/Cretiv Favicon White.png">
    <link rel="stylesheet" href="css/style.css">

    <!-- == Font == -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- == Icons == -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" crossorigin="anonymous" />
</head>
<body>
<nav>
        <div class="container">
            <div class="logged-user">
                <span>Welcome, </span>
                <span><?php echo $_SESSION['username']; ?>!</span>
                <a href="../index.html" class="go-to-site"><i class="fa-solid fa-eye"></i> View Website</a>
            </div>
            <div class="logged-user">
                <a href="logout.php">Logout?</a>
            </div>
        </div>
    </nav>

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
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>View</th>
                </tr>
                <?php while ($row = $result_contacts->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo substr($row['message'], 0, 20) . '...'; ?></td>
                        <td><button onclick="showDetails(<?php echo $row['id']; ?>)">View</button></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>

        <!-- Tab content for newsletter -->
        <div id="newsletter" class="tabcontent">
            <h3>Newsletter Subscription Data</h3>
            <table>
                <tr>
                    <th>No</th>
                    <th>Email</th>
                </tr>
                <?php while ($row = $result_newsletter->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
        </div>
    </div>

    <!-- Modal for displaying contact details -->
    <div id="detailsModal" class="modal">
        <div class="modal-content">
            <button class="close"><i class="fa-solid fa-xmark"></i></button>
            <h3>Contact Details</h3>
            <br>
            <br>
            <h4>Name</h4>
            <p id="modalName"></p>
            <br>
            <h4>Email</h4>
            <p id="modalEmail"></p>
            <br>
            <h4>Message</h4>
            <p id="modalMessage"></p>
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
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on the button, open the modal
    function showDetails(id) {
        var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                var contactDetails = JSON.parse(this.responseText);

                document.getElementById('modalName').textContent = contactDetails.name;
                document.getElementById('modalEmail').textContent = contactDetails.email;
                document.getElementById('modalMessage').textContent = contactDetails.message;

                modal.style.display = "block";
            }
        };

        xhr.open('GET', 'fetch_contact_details.php?id=' + id, true);
        xhr.send();
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
</body>
</html>