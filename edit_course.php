<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'instructor') {
    header("Location: login.php");
    exit();
}

include 'db_connect.php';
$error = "";
$course_id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    
    $query = "UPDATE courses SET title = '$title', description = '$description' WHERE id = $course_id";
    if ($conn->query($query)) {
        header("Location: instructor_courses.php");
        exit();
    } else {
        $error = "Error updating course: " . $conn->error;
    }
} else {
    $result = $conn->query("SELECT * FROM courses WHERE id = $course_id");
    $course = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Course</title>
    <link rel="stylesheet" href="view/css/form.css">
    <link rel="stylesheet" type="text/css" href="view/css/edit.css">
</head>
<body>
    <?php include 'nav.php'; ?>
    <div class="container">
        <h2>Edit Course</h2>
        <form action="edit_course.php?id=<?php echo $course_id; ?>" method="POST">
            <label for="title">Course Title:</label>
            <input type="text" name="title" value="<?php echo $course['title']; ?>" required>

            <label for="description">Description:</label>
            <textarea name="description" required><?php echo $course['description']; ?></textarea>

            <button type="submit" class="btn">Update Course</button>
        </form>
        <p><?php echo $error; ?></p>
    </div>
</body>
</html>
