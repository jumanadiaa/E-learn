<?php
// Include the database connection file
include 'db_connect.php'; // Adjust the path if needed

// Start the session to access user data
session_start();

// Ensure the user is logged in (check for session)
if (!isset($_SESSION['user_id'])) {
    echo "Please log in first.";
    exit();
}

// Get the user_id from the session
$userId = $_SESSION['user_id'];

// Query to fetch certificate details, user details, and course details for the logged-in user
$sql = "SELECT 
            certificates.certificate_code, 
            certificates.issued_at, 
            certificates.course_id, 
            users.name, 
            courses.title AS course_name
        FROM certificates
        JOIN users ON certificates.user_id = users.id
        JOIN courses ON certificates.course_id = courses.id
        WHERE certificates.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId); // Bind the user_id parameter to the query
$stmt->execute();
$result = $stmt->get_result();

// Check if a certificate exists for this user
if ($result->num_rows > 0) {
    // Fetch certificate, user, and course data
    $certificate = $result->fetch_assoc();
    $courseId = $certificate['course_id'];
    $certificateCode = $certificate['certificate_code'];
    $issuedDate = $certificate['issued_at'];
    $userName = $certificate['name']; // Get the user_name from the users table
    $courseName = $certificate['course_name']; // Get the course title from the courses table
} else {
    // No certificate found for this user
    echo "No certificate found for this user.";
    exit();
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Completion</title>
   
</head>
<body>

    <div class="certificate-container">
        <div class="certificate">
            <header class="certificate-header">
                <h1>Certificate of Completion</h1>
            </header>

            <section class="certificate-body">
                <p class="certificate-text">This is to certify that</p>
                <h2 class="recipient-name"><?php echo htmlspecialchars($userName); ?></h2> <!-- User name fetched from the users table -->
                <p class="certificate-text">has successfully completed the course</p>
                <h3 class="course-name"><?php echo htmlspecialchars($courseName); ?></h3> <!-- Course name fetched from the courses table -->
                <p class="certificate-text">with certificate code</p>
                <p class="certificate-code"><?php echo htmlspecialchars($certificateCode); ?></p>
                <p class="certificate-text">on</p>
                <p class="issued-date"><?php echo htmlspecialchars($issuedDate); ?></p>
            </section>

            <footer class="certificate-footer">
                <p>Issued by: E-Learn Academy</p>
            </footer>
        </div>
    </div>
<style>/* General Styling */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  background: #f0f0f0;
  font-family: 'Arial', sans-serif;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  padding: 20px;
}

.certificate-container {
  position: relative;
  width: 70%;
  max-width: 900px;
  height: 80%;
  background: #fff;
  border: 15px solid #b29570; /* Gold border for a professional look */
  border-radius: 15px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  padding: 40px;
  animation: fadeIn 2s ease-out;
}

.certificate {
  display: flex;
  flex-direction: column;
  text-align: center;
  position: relative;
}

.certificate-header h1 {
  font-size: 36px;
  font-weight: bold;
  color: #b29570;
  margin-bottom: 20px;
  letter-spacing: 2px;
  animation: slideDown 2s ease-out;
}

.certificate-body {
  margin-top: 20px;
  animation: slideUp 2s ease-out;
}

.certificate-text {
  font-size: 20px;
  color: #333;
  margin: 10px 0;
}

.recipient-name {
  font-size: 28px;
  font-weight: bold;
  color: #b29570;
  margin: 20px 0;
  text-transform: uppercase;
  letter-spacing: 1px;
  animation: slideLeft 2s ease-out;
}

.course-name {
  font-size: 24px;
  font-weight: bold;
  color: #5c5c5c;
  margin: 20px 0;
}

.certificate-code {
  font-size: 20px;
  font-weight: bold;
  color: #4d94ff;
}

.issued-date {
  font-size: 20px;
  color: #888;
  margin-top: 10px;
}

.certificate-footer {
  margin-top: 30px;
  font-size: 18px;
  color: #5c5c5c;
}

.certificate-footer p {
  font-weight: bold;
}

/* Background Pattern */
.certificate-container:before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: url('https://www.toptal.com/designers/subtlepatterns/patterns/geometry.png') repeat;
  opacity: 0.05;
  z-index: -1;
}

/* Animations */
@keyframes fadeIn {
  0% {
      opacity: 0;
  }
  100% {
      opacity: 1;
  }
}

@keyframes slideDown {
  0% {
      transform: translateY(-30px);
      opacity: 0;
  }
  100% {
      transform: translateY(0);
      opacity: 1;
  }
}

@keyframes slideUp {
  0% {
      transform: translateY(30px);
      opacity: 0;
  }
  100% {
      transform: translateY(0);
      opacity: 1;
  }
}

@keyframes slideLeft {
  0% {
      transform: translateX(-30px);
      opacity: 0;
  }
  100% {
      transform: translateX(0);
      opacity: 1;
  }
}

/* Responsive Design */
@media (max-width: 768px) {
  .certificate-container {
      width: 90%;
      height: auto;
      padding: 20px;
  }

  .certificate-header h1 {
      font-size: 28px;
  }

  .recipient-name {
      font-size: 24px;
  }

  .course-name {
      font-size: 20px;
  }

  .certificate-footer p {
      font-size: 16px;
  }
}
</style>
</body>
</html>
