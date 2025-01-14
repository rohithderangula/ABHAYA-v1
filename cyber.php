<?php
// Database connection
$servername = "localhost";
$username = "root"; // Adjust according to your database settings
$password = ""; // Adjust according to your database settings
$dbname = "user_management"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $complaint = filter_var($_POST['complaint'], FILTER_SANITIZE_STRING);
    $platform = basename($_SERVER['HTTP_REFERER']); // Get the platform based on the referring URL

    // File upload handling
    $proof = [];
    for ($i = 0; $i < 2; $i++) {
        if (isset($_FILES['proof']['name'][$i]) && $_FILES['proof']['name'][$i] != '') {
            $targetDir = "uploads/";
            $fileName = basename($_FILES['proof']['name'][$i]);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            // Allow only image files
            $allowedTypes = array('jpg', 'png', 'jpeg', 'gif');
            if (in_array($fileType, $allowedTypes)) {
                if (move_uploaded_file($_FILES['proof']['tmp_name'][$i], $targetFilePath)) {
                    $proof[] = $fileName;
                } else {
                    echo "Error uploading file " . $_FILES['proof']['name'][$i];
                }
            } else {
                echo "Only image files are allowed.";
            }
        }
    }

    // Prepare SQL query to insert the data
    $proof1 = isset($proof[0]) ? $proof[0] : null;
    $proof2 = isset($proof[1]) ? $proof[1] : null;

    $stmt = $conn->prepare("INSERT INTO reports (name, address, username, complaint, proof1, proof2, platform) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $address, $username, $complaint, $proof1, $proof2, $platform);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Report submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Close connection
$conn->close();
?>