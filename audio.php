<?php
// Enable error reporting for debugging
date_default_timezone_set('UTC');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_management";

try {
    // Set up PDO connection
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'User not logged in']);
        exit();
    }

    // Get user ID from session
    $user_id = $_SESSION['user_id'];

    // Fetch user details from the 'users' table
    $stmtUser = $pdo->prepare("SELECT id, firstname, lastname, phone_no FROM users WHERE id = :user_id");
    $stmtUser->execute(['user_id' => $user_id]);
    $userDetails = $stmtUser->fetch(PDO::FETCH_ASSOC);

    // Fetch the latest login entry for the user from the 'logins' table
    $stmtLogin = $pdo->prepare("SELECT user_location FROM logins WHERE user_id = :user_id ORDER BY login_time DESC LIMIT 1");
    $stmtLogin->execute(['user_id' => $user_id]);
    $login = $stmtLogin->fetch(PDO::FETCH_ASSOC);

    if ($userDetails && $login) {
        // Check if the form is submitted and a file is uploaded
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['video']) && isset($_POST['video_type'])) {
            // Get the uploaded file details
            $videoFile = $_FILES['video'];
            $videoMimeType = mime_content_type($videoFile['tmp_name']);
            $fileExtension = strtolower(pathinfo($videoFile['name'], PATHINFO_EXTENSION));

            // Define valid MIME types and file extensions
            $validMimeTypes = ['video/mp4', 'video/webm', 'video/ogg'];
            $validExtensions = ['mp4', 'webm', 'ogg'];

            // Validate MIME type and file extension
            if (!in_array($videoMimeType, $validMimeTypes) && !in_array($fileExtension, $validExtensions)) {
                echo json_encode(['success' => false, 'message' => 'Invalid video format. Only MP4, WebM, and OGG are allowed.']);
                exit();
            }

            // Upload video file
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = uniqid() . '-' . basename($videoFile['name']);
            $uploadFile = $uploadDir . $fileName;

            if (move_uploaded_file($videoFile['tmp_name'], $uploadFile)) {
                // Get the video type (Violence, Harassment, Others)
                $videoType = $_POST['video_type']; // Get the video type from POST data

                // Insert video details into the database
                $stmtVideo = $pdo->prepare("INSERT INTO user_videos 
                    (user_id, firstname, lastname, phone_no, user_location, video_path, video_type, uploaded_at) 
                    VALUES (:user_id, :firstname, :lastname, :phone_no, :user_location, :video_path, :video_type, :uploaded_at)");

                $stmtVideo->execute([
                    'user_id' => $userDetails['id'],
                    'firstname' => $userDetails['firstname'],
                    'lastname' => $userDetails['lastname'],
                    'phone_no' => $userDetails['phone_no'],
                    'user_location' => $login['user_location'],
                    'video_path' => $uploadFile,
                    'video_type' => $videoType, // Store the video type
                    'uploaded_at' => date('Y-m-d H:i:s')
                ]);

                echo json_encode(['success' => true, 'message' => "Video for ${videoType} issue uploaded successfully."]);
            } else {
                echo json_encode(['success' => false, 'message' => "Failed to upload video for ${videoType} issue."]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'No file uploaded or video type not set']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'User details not found']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>
