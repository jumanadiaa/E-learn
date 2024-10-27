<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Learning Platform</title>
    <link rel="stylesheet" type="text/css" href="view/css/styles.css">
    <?php include 'nav.php'; ?>
</head>

<body>
    <!-- Hero Section with Video Background -->
    <section class="hero">
        <video id="background-video" autoplay muted loop class="background-video">
            <source src="view/pics/homevid.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="hero-content">
            <h2>Learn from the Best Instructors Anytime, Anywhere</h2>
            <p>Access hundreds of high-quality courses designed by experts in various fields.</p>
            <a href="#" class="cta-btn">Get Started</a>
        </div>
    </section>

    <section class="courses">
        <h3>Popular Courses</h3>
        <div class="course-grid">
            <div class="course">
                <h4>Web Development</h4>
                <p>Master HTML, CSS, JavaScript, and more!</p>
            </div>
            <div class="course">
                <h4>Data Science</h4>
                <p>Learn data analysis, Python, and machine learning.</p>
            </div>
            <div class="course">
                <h4>Graphic Design</h4>
                <p>Discover the world of creativity and design.</p>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 E-Learn. All rights reserved.</p>
    </footer>
</body>
</html>
