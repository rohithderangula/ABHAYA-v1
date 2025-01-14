<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_management";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $latitude = isset($_POST['latitude']) ? $_POST['latitude'] : null;
    $longitude = isset($_POST['longitude']) ? $_POST['longitude'] : null;

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, firstname, lastname, email, password, phone_no FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if email exists in the database
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $row['password'])) {
            session_start();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['firstname'] . " " . $row['lastname'];

            // Format location as a Google Maps link
            if ($latitude && $longitude) {
                $userLocation = "https://www.google.com/maps?q=$latitude,$longitude";
            } else {
                $userLocation = "Location not provided";
            }

            $currentTime = date("Y-m-d H:i:s");

            // Save login details in the logins table
            $logStmt = $conn->prepare("INSERT INTO logins (user_id, username, user_location, contact_number, login_time) VALUES (?, ?, ?, ?, ?)");
            $logStmt->bind_param("issss", $row['id'], $_SESSION['user_name'], $userLocation, $row['phone_no'], $currentTime);
            $logStmt->execute();
            $logStmt->close();

            // Redirect to Abhaya.html
            header("Location: Abhaya.html");
            exit();
        } else {
            echo "<script>alert('Invalid email or password.'); window.location.href = 'login.html';</script>";
        }
    } else {
        echo "<script>alert('Invalid email or password.'); window.location.href = 'login.html';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
