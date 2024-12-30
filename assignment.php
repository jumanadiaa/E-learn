<?php include 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Learning Platform - Assignments</title>
    <link rel="stylesheet" type="text/css" href="view/css/assignment.css?v=1.1">
    <?php include 'nav.php'; ?>
</head>
<body>
<div class="wrapper">
    <?php 
    // Get course_id from URL parameter
    if (isset($_GET['course_id'])) {
        $course_id = intval($_GET['course_id']);
    } else {
        die("Course ID is missing.");
    }

    // Fetch assignments for the given course_id from the "assignments" table, ensuring no duplicates
    $sql = "SELECT DISTINCT id, title, description, due_date, created_at 
            FROM assignments 
            WHERE course_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if assignments are available
    if ($result->num_rows > 0) {
        while ($assignment = $result->fetch_assoc()) {
            $assignment_id = $assignment['id'];
            $title = $assignment['title'];
            $description = $assignment['description'];
            $due_date = $assignment['due_date'];
            $created_at = $assignment['created_at'];
    ?>
            <!-- Display each assignment in a brutalist card -->
            <div class="brutalist-card">
                <div class="brutalist-card__header">
                    <div class="brutalist-card__icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"></path>
                        </svg>
                    </div>
                    <div class="brutalist-card__alert">Assignment <?php echo $assignment_id; ?></div>
                </div>
                <div class="brutalist-card__body">
                    <h3><?php echo htmlspecialchars($title); ?></h3>
                    <p><?php echo htmlspecialchars($description); ?></p>
                    <p><strong>Due Date:</strong> <?php echo htmlspecialchars($due_date); ?></p>
                    <p><strong>Created At:</strong> <?php echo htmlspecialchars($created_at); ?></p>
                </div>
                <div class="brutalist-card__actions">
                    <a class="brutalist-card__button" href="#">View Details</a>
                </div>
            </div>
    <?php
        }
    } else {
        echo "<p>No assignments available for this course.</p>";
    }
    ?>
</div>
</body>
</html>
