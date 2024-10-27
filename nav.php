<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<header>
    <link rel="stylesheet" type="text/css" href="view/css/navstyle.css?v=1.1">
    <div class="logo">
        <h1>E-Learn</h1>
    </div>
    <nav>
        <ul>
            <li><a href="homepage.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="#">Contact</a></li>

            <?php
            // Check if the user is logged in and display options based on role
            if (isset($_SESSION['user_role'])) {
                if ($_SESSION['user_role'] === 'student') {
                    echo '<li><a href="courses.php">Courses</a></li>';
                } elseif ($_SESSION['user_role'] === 'instructor') {
                    echo '<li><a href="instructor_courses.php">Instructor Dashboard</a></li>';
                } elseif ($_SESSION['user_role'] === 'admin') {
                    echo '<li><a href="admindash.php">Admin Dashboard</a></li>';
                }
                echo '<li><a href="signout.php" class="login-btn">Sign out</a></li>';
            } else {
                // If the user is not logged in, show login and signup links
                echo '<li><a href="login.php" class="login-btn">Login</a></li>';
                echo '<li><a href="signup.php" class="login-btn">Signup here</a></li>';
            }
            ?>
        </ul>
    </nav>
</header>
