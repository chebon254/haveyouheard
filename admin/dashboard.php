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
<html>
<head>
    <title>Dashboard</title>
    <style>
        /* Add your CSS styles here */
    </style>
</head>
<body>
    <h2>Dashboard</h2>
    <p>Welcome, <?php echo $_SESSION['username']; ?>!</p>
    <a href="logout.php">Logout</a>

    <div>
        <!-- Tabs for contact form and newsletter -->
        <button class="tablink" onclick="openTab(event, 'contacts')" id="defaultOpen">Contacts</button>
        <button class="tablink" onclick="openTab(event, 'newsletter')">Newsletter</button>

        <!-- Tab content for contacts -->
        <div id="contacts" class="tabcontent">
            <h3>Contact Form Data</h3>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>View</th>
                </tr>
                <?php while ($row = $result_contacts->fetch_assoc()) : ?>
                    <tr>
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
                    <th>Email</th>
                </tr>
                <?php while ($row = $result_newsletter->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['email']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>

    <!-- Modal for displaying contact details -->
    <div id="detailsModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Contact Details</h3>
            <p id="modalName"></p>
            <p id="modalEmail"></p>
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
        // Fetch contact details from the database using AJAX or server-side script
        // and populate the modal content with the retrieved data
        // ...

        modal.style.display = "block";
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