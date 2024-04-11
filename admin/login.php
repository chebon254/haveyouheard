<?php
include 'database.php';
include 'logger.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute the SQL query
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Login successful
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            logEvent('info', 'User ' . $row['username'] . ' logged in successfully');
            header('Location: index.php');
            exit;
        } else {
            $error = 'Invalid username or password';
            logEvent('warning', 'Failed login attempt for user ' . $username);
        }
    } else {
        $error = 'Invalid username or password';
        logEvent('warning', 'Failed login attempt for user ' . $username);
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

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
                        <h1>Login</h1>
                        <p>Access your account.</p>
                        <div class="message">
                          <span>
                          <?php if (isset($error)) { echo '<p style="color: red;">' . $error . '</p>'; } ?>
                          </span>
                        </div>
                    </div>
                    <div class="form-control">
                        <label for="username">Username</label>
                        <br>
                        <br>
                        <input type="text" name="username" id="username" placeholder="Enter Username" required>
                    </div>
                    <div class="form-control">
                        <label for="password">Password</label>
                        <br>
                        <br>
                        <div class="password-container">
                            <input type="password" name="password" id="password" placeholder="Enter Password" required>
                            <i class="fas fa-eye-slash" id="togglePassword"></i>
                        </div>
                    </div>
                    <div class="form-control">
                        <button type="submit">Log In</button>
                    </div>
                    <div class="form-control">
                        <p class="p-go-to-site"><a class="go-to-site" href="../index.html"><i class="fa-solid fa-arrow-left-long"></i> Go to Website</a></p>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script src="js/script.js"></script>
    <script>
        const togglePassword = document.querySelector("#togglePassword");
        const passwordInput = document.querySelector("#password");

        togglePassword.addEventListener("click", function () {
            const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
            passwordInput.setAttribute("type", type);
            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
        });
    </script>
</body>
</html>