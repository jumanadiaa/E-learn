<?php
// Include database connection file
include 'db_connect.php';
// Initialize error variable

// Initialize variables
$fullname = $email = $password = $role = "";
$error_message = "";
$success_message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Trim and sanitize input data
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);
    $role = "student";

    // Validate input fields
    if (empty($fullname) || empty($email) || empty($password) || empty($role)) {
        $error_message = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error_message = "Email already registered.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user into the database
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, role, created_at) VALUES (?, ?, ?, ?, NOW())");
            $stmt->bind_param("ssss", $fullname, $email, $hashed_password, $role);

            if ($stmt->execute()) {
                // Redirect to login page upon successful signup
                header("Location: login.php");
                exit();
            } else {
                $error_message = "Error during registration. Please try again.";
            }
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - E-Learning Platform</title>
    <link rel="stylesheet" type="text/css" href="view/css/signup.css?v=1.1">
    <?php include 'nav.php'; ?> <!-- Include the navigation bar -->
</head>
<body>
    <div class="container">
        <div class="form-content">
            <h2>Sign Up</h2>
            <form action="process_signup.php" method="POST">
                <ul class="form-list">
                    <li>
                        <label for="fullname">Full Name:</label>
                        <input type="text" name="fullname" id="fullname" required>
                    </li>
                    <li>
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" required>
                    </li>
                    <li>
                        <label for="password">Password:</label>
                        <input type="password" name="password" id="password" required>
                    </li>
                    
                </ul>
                <input type="submit" value="Sign Up">
            </form>
            <div class="login-link">
                <p>Already have an account? <a href="login.php">Log in</a></p>
            </div>
        </div>
        <div class="image-container">
            <img src="view/images/signuppic.jpg" alt="Signup Image">
        </div>
    </div>
</body>
</html>
