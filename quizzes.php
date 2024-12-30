<?php include 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Learning Platform</title>
    <link rel="stylesheet" type="text/css" href="view/css/studquiz.css?v=1.1">
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

    // Fetch quizzes for the given course_id from the "quizzes" table
    $sql = "SELECT quizzes.id, quizzes.question 
            FROM quizzes 
            WHERE quizzes.course_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if quizzes are available
    if ($result->num_rows > 0) {
        while ($quiz = $result->fetch_assoc()) {
            $quiz_id = $quiz['id'];
            $question = $quiz['question'];
    ?>
            <!-- Display each quiz in a brutalist card -->
            <div class="brutalist-card">
                <div class="brutalist-card__header">
                    <div class="brutalist-card__icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"></path>
                        </svg>
                    </div>
                    <div class="brutalist-card__alert">Quiz <?php echo $quiz_id; ?></div>
                </div>
             
               
                <div class="brutalist-card__actions">
                    <a class="brutalist-card__button" href="#">Hint</a>
                    <a class="brutalist-card__button" href="studquiz.php?course_id=<?php echo $course_id; ?>&quiz_id=<?php echo $quiz_id; ?>">Attend the Quiz</a>
                </div>
            </div>
    <?php
        }
    } else {
        echo "<p>No quizzes available for this course.</p>";
    }
    ?>
</div>
</body>
</html>
