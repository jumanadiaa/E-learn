<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'instructor') {
    header("Location: login.php");
    exit();
}

include 'db_connect.php';
$course_id = $_GET['id'];

$query = "DELETE FROM courses WHERE id = $course_id";
if ($conn->query($query)) {
    header("Location: instructor_courses.php");
    exit();
} else {
    echo "Error deleting course: " . $conn->error;
}
?>
