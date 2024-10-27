<?php
session_start();
 // Include your database connection
 include 'db_connect.php';
// Initialize error variable
$error = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if email and password are filled
    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        // Check if user exists in the database
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_role'] = $user['role']; // Optional: Role (student, instructor, admin)

                // Redirect to the homepage upon successful login
                header("Location: homepage.php");
                exit();
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "User not found.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Learning Platform</title>
    <link rel="stylesheet" type="text/css" href="view/css/login.css?v=1.1">
    <?php include 'nav.php'; ?>
</head>
<body>
    <div class="container">
        <div class="form-content">
            <h2>Login</h2>
            <form action="login_action.php" method="POST">
                <ul class="form-list">
                    <li>
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </li>
                    <li>
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                    </li>
                </ul>
                <input type="submit" value="Login">
            </form>
            <div class="signup-link">
                <p>Don't have an account? <a href="signup.php">Sign up</a></p>
            </div>
        </div>
        <div class="image-container">
            <img src="view/pics/signuppic.jpg" alt="Login Image">
        </div>
    </div>
</body>
</html>
