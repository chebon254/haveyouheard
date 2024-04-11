<?php
// Start session
session_start();

// Database connection
include 'database.php';

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Check if the password change form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_new_password = $_POST['confirm_new_password'];

        // Validate the new password and confirm password
        if ($new_password === $confirm_new_password) {
            // Get the current password hash from the database
            $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $current_password_hash = $row['password'];

            // Verify the current password
            if (password_verify($current_password, $current_password_hash)) {
                // Hash the new password
                $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                // Update the password in the database
                $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                $stmt->bind_param("si", $new_password_hash, $user_id);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    $success = "Password changed successfully.";
                } else {
                    $error = "Failed to change password. Please try again.";
                }
            } else {
                $error = "Current password is incorrect.";
            }
        } else {
            $error = "New password and confirm password do not match.";
        }
    }
} else {
    $error = "You must be logged in to change your password.";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>

    <link rel="icon shortcut" href="css/img/Logo.png">
    <link rel="stylesheet" href="css/style.css">

    <!-- == Font == -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- == Icons == -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        crossorigin="anonymous" />
    <style>
        .password-container {
            position: relative;
        }

        .password-container input {
            padding-right: 30px; /* Make room for the eye icon */
        }

        .password-container i {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>
<body>
    <main>
        <div class="container">
            <div class="form">
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="form-control">
                        <h1>Change Password</h1>
                        <p>Enter you current and new password then save.</p>
                        <div class="message">
                            <span>
                                <?php
                                if (isset($error)) {
                                    echo '<p style="color: red;">' . $error . '</p>';
                                } elseif (isset($success)) {
                                    echo '<p style="color: green;">' . $success . '</p>';
                                }
                                ?>
                            </span>
                        </div>
                    </div>
                    <div class="form-control">
                        <label for="current_password">Current Password:</label>
                        <div class="password-container form-control">
                            <input type="password" id="current_password" name="current_password" placeholder="Enter Current Password" required>
                            <i class="fas fa-eye-slash" id="toggleCurrentPassword"></i>
                        </div>
                    </div>
                    <div class="form-control">
                        <label for="new_password">New Password:</label>
                        <div class="password-container form-control">
                            <input type="password" id="new_password" name="new_password" placeholder="Enter New Password"  required>
                            <i class="fas fa-eye-slash" id="toggleNewPassword"></i>
                        </div>
                    </div>
                    <div class="form-control">
                        <label for="confirm_new_password">Confirm New Password:</label>
                        <div class="password-container form-control">
                            <input type="password" id="confirm_new_password" name="confirm_new_password" placeholder="Confirm New Password" required>
                            <i class="fas fa-eye-slash" id="toggleConfirmPassword"></i>
                        </div>
                    </div>
                    <div class="form-control">
                        <button type="submit">Change Password</button>
                    </div>
                    <div class="form-control">
                        <p class="p-go-to-site"><a class="go-to-site" href="index.php"><i class="fa-solid fa-arrow-left-long"></i> Go to Dashboard</a></p>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script src="js/script.js"></script>
    <script>
        const togglePassword = document.querySelector("#toggleCurrentPassword");
        const passwordInput = document.querySelector("#current_password");

        togglePassword.addEventListener("click", function () {
            const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
            passwordInput.setAttribute("type", type);
            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
        });
    </script>
    <script>
        const toggleNewPassword = document.querySelector("#toggleNewPassword");
        const newpasswordInput = document.querySelector("#new_password");

        toggleNewPassword.addEventListener("click", function () {
            const type = newpasswordInput.getAttribute("type") === "password" ? "text" : "password";
            newpasswordInput.setAttribute("type", type);
            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
        });
    </script>
    <script>
        const toggleConfirmPassword = document.querySelector("#toggleConfirmPassword");
        const ConfirmpasswordInput = document.querySelector("#confirm_new_password");

        toggleConfirmPassword.addEventListener("click", function () {
            const type = ConfirmpasswordInput.getAttribute("type") === "password" ? "text" : "password";
            ConfirmpasswordInput.setAttribute("type", type);
            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
        });
    </script>
    
</body>
</html>