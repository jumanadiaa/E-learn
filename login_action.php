<?php
session_start();
include 'db_connect.php'; // Include your database connection

// Initialize error variable
$error = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if email and password are filled
    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
        header("Location: login.php?error=" . urlencode($error));
        exit();
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
                header("Location: login.php?error=" . urlencode($error));
                exit();
            }
        } else {
            $error = "User not found.";
            header("Location: login.php?error=" . urlencode($error));
            exit();
        }
    }
}
?>
