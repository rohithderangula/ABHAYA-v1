<?php
session_start();  // Ensure session is started at the top of your script

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('You need to log in first'); window.location.href = 'login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];  // Fetch the user ID from session

// Database connection
$servername = "localhost";
$username = "root"; // Use your database username
$password = ""; // Use your database password
$dbname = "user_management"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['category'])) {
    // Get form data
    $category = $conn->real_escape_string($_POST['category']);
    $victim_name = $conn->real_escape_string($_POST['name']);
    $victim_address = $conn->real_escape_string($_POST['address']);
    $username = $conn->real_escape_string($_POST['username']);
    $complaint_details = $conn->real_escape_string($_POST['complaint']);
    $incident_date = $conn->real_escape_string($_POST['incident_date']);  // This should now work

    // Handle file uploads (proof images)
    $uploaded_files = [];
    if (isset($_FILES['proof']) && count($_FILES['proof']['name']) > 0) {
        $upload_dir = 'uploads/proofs/';
        foreach ($_FILES['proof']['name'] as $index => $file_name) {
            $new_file_name = uniqid('proof_', true) . '.' . pathinfo($file_name, PATHINFO_EXTENSION);
            $file_tmp = $_FILES['proof']['tmp_name'][$index];

            if (move_uploaded_file($file_tmp, $upload_dir . $new_file_name)) {
                $uploaded_files[] = $new_file_name;
            }
        }
    }

    // Convert uploaded file names into a comma-separated string
    $proof_images = implode(',', $uploaded_files);

    // Insert complaint data into the database
    $insert_complaint_sql = "INSERT INTO cyber_harassment_complaints 
                             (user_id, category, victim_name, victim_address, username, complaint_details, proof_images, incident_date) 
                             VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($insert_complaint_sql);
    $stmt->bind_param("isssssss", $user_id, $category, $victim_name, $victim_address, $username, $complaint_details, $proof_images, $incident_date);

    if ($stmt->execute()) {
        // Display an acknowledgment message and redirect after a short delay
        echo "<script>
                alert('Complaint submitted successfully!');
                setTimeout(function() {
                    window.location.href = 'cyber.html';
                }, 500);  // 2 seconds delay before redirecting
              </script>";
    } else {
        echo "<script>alert('Error submitting complaint: " . addslashes($conn->error) . "');</script>";
    }
}
?>
