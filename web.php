<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Development Course Details</title>
    <link rel="stylesheet" href="view/css/web.css">
</head>
<body>

    <!-- Header -->
    <header>
        <h1>Web Development Course </h1>
    </header>

    <!-- Course Description Section -->
    <section class="course-description">
        <h2>Course Description</h2>
        <p>This Web Development course is designed to equip you with essential skills in HTML, CSS, and JavaScript, enabling you to create responsive and interactive websites tailored for all levels of learners.</p>
    </section>

    <!-- Course Sections -->
    <section class="course-sections">
        <h2>Course Sections</h2>
        <table>
            <tr>
                <th>Section</th>
                <th>Description</th>
                <th>Access</th>
            </tr>
            <tr>
                <td>Lecture Slides</td>
                <td>Access comprehensive lecture slides for each topic.</td>
                <td><button onclick="window.location.href='lectures.php'">View Slides</button></td>
            </tr>
            <tr>
                <td>Assignments</td>
                <td>Complete assignments designed to reinforce learning.</td>
                <td><button onclick="window.location.href='assignments.php'">View Assignments</button></td>
            </tr>
            <tr>
                <td>Tutorials</td>
                <td>Explore tutorials for enhanced understanding of the topics.</td>
                <td><button onclick="window.location.href='tutorials.php'">View Tutorials</button></td>
            </tr>
            <tr>
                <td>Quizzes</td>
                <td>Participate in quizzes to assess your progress.</td>
                <td><button onclick="window.location.href='quizzes.php'">Take Quiz</button></td>
            </tr>
        </table>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 E-Learn. All rights reserved.</p>
    </footer>
</body>
</html>