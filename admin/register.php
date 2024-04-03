<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt->execute()) {
        $success = 'Registration successful! You can now log in.';
    } else {
        $error = 'Registration failed: ' . $conn->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link rel="icon shortcut" href="css/img/Cretiv Favicon White.png">
    <link rel="stylesheet" href="css/style.css">

    <!-- == Font == -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- == Icons == -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        crossorigin="anonymous" />
</head>
<body>
    <main>
        <div class="container">
            <div class="form">
                <form autocomplete="off" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="form-control">
                        <h1>Register</h1>
                        <p class="title">Create your account.</p>
                        <div class="message" id="registrationMessage">
                             <!-- Display the success message -->
                            <span id="successMessage" style="color: green !important; font-size:13px !important; font-weight: 600;"><?php if (isset($success)) { echo '<p>' . $success . '</p>'; } ?></span>

                            <!-- Display the error message -->
                            <span id="errorMessage" style="color: red !important; font-size:13px !important; font-weight: 600;"><?php if (isset($error)) { echo '<p>' . $error . '</p>'; } ?></span>
                        </div>
                    </div>
                    <div class="form-control">
                        <label for="name">Username</label>
                        <br>
                        <br>
                        <input type="text" name="username" id="username" required autocomplete="false" placeholder="Enter Username">
                    </div>
                    <div class="form-control">
                        <label for="email">Email</label>
                        <br>
                        <br>
                        <input type="email" name="email" id="email" required autocomplete="false" placeholder="Enter Email">
                    </div>
                    <div class="form-control">
                        <label for="password">Password</label>
                        <br>
                        <br>
                        <input type="password" name="password" id="password" required autocomplete="false" placeholder="Set Password">
                    </div>
                    <div class="form-control">
                        <button type="submit">Register</button>
                    </div>
                    <div class="form-control">
                        <p class="account-related">Already have an account?<a href="index.php">Sign in</a></p>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <?php if ($successMessage === "Registration successful. Redirecting..." && $emailSuccessMessage = "Registration successful. Redirecting..." ) : ?>
        <script>
            setTimeout(function() {
                window.location.href = "dashboard.php";
            }, 2500); // Redirect after 3 seconds
        </script>
    <?php endif; ?>
    <script src="js/script.js"></script>
</body>
</html>