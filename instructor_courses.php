<?php
include 'db_connect.php';
session_start();

// Check user role
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'instructor') {
    header("Location: login.php");
    exit();
}

// Message variables
$message = '';
$feedbackMessage = '';

// Handle course creation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_course'])) {
    $instructor_id = $_SESSION['user_id']; // Dynamic instructor ID from session
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Prepare SQL and bind parameters
    $stmt = $conn->prepare("INSERT INTO courses (instructor_id, title, description) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $instructor_id, $title, $description);

    if ($stmt->execute()) {
        $message = "Course '$title' created successfully!";
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch existing courses
$instructor_id = $_SESSION['user_id'];
$coursesQuery = "SELECT c.*, (SELECT COUNT(*) FROM enrollments e WHERE e.course_id = c.id) AS students FROM courses c WHERE c.instructor_id = $instructor_id";
$result = $conn->query($coursesQuery);

$courses = [];
while ($course = $result->fetch_assoc()) {
    $courses[] = $course;
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Dashboard</title>
    <link rel="stylesheet" href="view/css/instructor_courses.css">
    <?php include 'nav.php'; ?>
    <script>
        function openModal(type) {
            document.getElementById(type + '-modal').style.display = 'block';
        }

        function closeModal(type) {
            document.getElementById(type + '-modal').style.display = 'none';
        }
    </script>
</head>
<body>

<div class="dashboard-container">
    <h1>Instructor Dashboard</h1>
    <?php if ($message) echo "<p class='message'>$message</p>"; ?>

    <!-- Course Creation Section -->
    <div class="form-section">
        <h2>Course Creation</h2>
        <form method="POST" enctype="multipart/form-data">
            <label for="title">Course Title</label>
            <input type="text" id="title" name="title" required>

            <label for="description">Course Description</label>
            <textarea id="description" name="description" rows="4" required></textarea>

            <label for="videos">Upload Videos and Materials</label>
            <input type="file" id="videos" name="videos[]" multiple>

            <button type="button" onclick="openModal('quiz')">Upload Quiz</button>
            <button type="button" onclick="openModal('assignment')">Upload Assignment</button>

            <button type="submit" name="create_course">Create Course</button>
        </form>
    </div>

    <!-- Course Management Section -->
    <div class="form-section">
        <h2>Course Management</h2>
        <?php foreach ($courses as $course): ?>
            <div class="course-item">
                <p><strong>Title:</strong> <?php echo $course['title']; ?></p>
                <p><strong>Description:</strong> <?php echo $course['description']; ?></p>
                <p><strong>Enrolled Students:</strong> <?php echo $course['students']; ?></p>
                <a href="edit_course.php?id=<?php echo $course_id; ?>" class="btn-link">Edit</a>


                <a href="delete_course.php?id=<?php echo $course['id']; ?> " onclick="return confirm('Are you sure you want to delete this course?');" class="btn-link delete-link">Delete Course</a>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Track Student Progress Section -->
    <div class="form-section">
        <h2>Track Student Progress</h2>
        <?php foreach ($courses as $course): ?>
            <div class="progress-item">
                <p><strong><?php echo $course['title']; ?>:</strong> <?php echo isset($course['progress']) ? $course['progress'] : '0'; ?>% Complete</p>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Student Interaction Section -->
    <div class="form-section">
        <h2>Student Interaction</h2>
        <form method="POST">
            <label>Respond to Student Questions:</label>
            <textarea name="response" rows="3" placeholder="Enter response here..."></textarea>
            <button type="submit" name="submit_response">Submit Response</button>

            <label>Provide Feedback on Assignments/Quizzes:</label>
            <textarea name="feedback" rows="3" placeholder="Enter feedback here..."></textarea>
            <button type="submit" name="submit_feedback">Submit Feedback</button>
        </form>
    </div>
</div>

<!-- Quiz Modal -->
<div id="quiz-modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('quiz')">&times;</span>
        <h2>Upload Quiz</h2>
        <form method="POST" enctype="multipart/form-data">
            <label for="quiz_file">Select Quiz File</label>
            <input type="file" id="quiz_file" name="quiz_file" required>
            <button type="submit" name="upload_quiz">Upload Quiz</button>
        </form>
    </div>
</div>

<!-- Assignment Modal -->
<div id="assignment-modal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('assignment')">&times;</span>
        <h2>Upload Assignment</h2>
        <form method="POST" enctype="multipart/form-data">
            <label for="assignment_file">Select Assignment File</label>
            <input type="file" id="assignment_file" name="assignment_file" required>
            <button type="submit" name="upload_assignment">Upload Assignment</button>
        </form>
    </div>
</div>

</body>
</html>
