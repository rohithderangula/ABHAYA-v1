<?php
// Enable error reporting for debugging
date_default_timezone_set('UTC');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database configuration (ensure this file exists and is properly configured)
if (!file_exists('config.php')) {
    echo json_encode(['success' => false, 'message' => 'Database configuration file missing.']);
    exit();
}
require 'config.php';

// Start the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Generate a new CSRF token for the session
function generateCSRFToken() {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Generate a secure token
}

// Ensure CSRF token is present and valid for POST requests
function verifyCSRFToken() {
    if (empty($_POST['csrf_token']) || !isset($_SESSION['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo json_encode(['success' => false, 'message' => 'CSRF token validation failed.']);
        exit();
    }
}

// Check if the request method is valid
$requestMethod = $_SERVER['REQUEST_METHOD'] ?? null;

if (!$requestMethod) {
    echo json_encode(['success' => false, 'message' => 'Invalid request context.']);
    exit();
}

// Log the request method for debugging (optional)
error_log('REQUEST_METHOD: ' . $requestMethod);

// Generate CSRF token for GET requests
if ($requestMethod === 'GET') {
    generateCSRFToken();
}

try {
    // Database connection using the constants from config.php
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the user is logged in
    if (empty($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'User not logged in']);
        exit();
    }

    // Get user ID from session
    $user_id = $_SESSION['user_id'];

    // Fetch user details from the 'users' table
    $stmtUser = $pdo->prepare("SELECT id, firstname, lastname, phone_no FROM users WHERE id = :user_id");
    $stmtUser->execute(['user_id' => $user_id]);
    $userDetails = $stmtUser->fetch(PDO::FETCH_ASSOC);

    if (!$userDetails) {
        echo json_encode(['success' => false, 'message' => 'User details not found.']);
        exit();
    }

    // Handle user entry into the geo-fence
    if ($requestMethod === 'POST' && isset($_POST['action']) && $_POST['action'] === 'enter') {
        // Verify CSRF token
        verifyCSRFToken();

        // Get location and radius data from the form
        $location_db = filter_var($_POST['location_db'] ?? null, FILTER_SANITIZE_STRING);
        $location_html = filter_var($_POST['location_html'] ?? null, FILTER_SANITIZE_STRING);
        $radius = filter_var($_POST['radius'] ?? null, FILTER_VALIDATE_FLOAT, ['options' => ['min_range' => 0]]);

        if (!$location_db || !$location_html || $radius === false || $radius <= 0) {
            echo json_encode(['success' => false, 'message' => 'Location details and a positive radius are required.']);
            exit();
        }

        // Insert the user's entry into the geo-fence table
        $stmt = $pdo->prepare("INSERT INTO geofence 
            (user_id, firstname, lastname, phone_no, entry_time, location_db, location_html, radius) 
            VALUES (:user_id, :firstname, :lastname, :phone_no, NOW(), :location_db, :location_html, :radius)");

        $result = $stmt->execute([ 
            'user_id' => $userDetails['id'],
            'firstname' => $userDetails['firstname'],
            'lastname' => $userDetails['lastname'],
            'phone_no' => $userDetails['phone_no'],
            'location_db' => $location_db,
            'location_html' => $location_html,
            'radius' => $radius
        ]);

        echo json_encode(['success' => $result, 'message' => $result ? 'User entered geo-fence.' : 'Failed to insert geo-fence entry.']);
        exit();
    }

    // Handle user exit from the geo-fence
    if ($requestMethod === 'POST' && isset($_POST['action']) && $_POST['action'] === 'exit') {
        // Verify CSRF token
        verifyCSRFToken();

        // Fetch the latest entry for the user
        $stmt = $pdo->prepare("SELECT id, entry_time FROM geofence WHERE user_id = :user_id ORDER BY entry_time DESC LIMIT 1");
        $stmt->execute(['user_id' => $user_id]);
        $geofenceEntry = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$geofenceEntry) {
            echo json_encode(['success' => false, 'message' => 'No active geo-fence entry found.']);
            exit();
        }

        // Calculate duration and update the exit time
        $entryTime = new DateTime($geofenceEntry['entry_time'], new DateTimeZone('UTC'));
        $exitTime = new DateTime('now', new DateTimeZone('UTC'));
        $duration = $exitTime->getTimestamp() - $entryTime->getTimestamp();

        // Update the geo-fence record
        $stmt = $pdo->prepare("UPDATE geofence SET exit_time = NOW(), duration = :duration WHERE id = :id");
        $result = $stmt->execute([ 
            'duration' => $duration,
            'id' => $geofenceEntry['id']
        ]);

        echo json_encode([ 
            'success' => $result,
            'message' => $result ? 'User exited geo-fence.' : 'Failed to update geo-fence exit.',
            'duration' => $duration . ' seconds'
        ]);
        exit();
    }

    // Fetch all geo-fence data for the user
    if ($requestMethod === 'GET' && isset($_GET['action']) && $_GET['action'] === 'fetch') {
        $stmt = $pdo->prepare("SELECT * FROM geofence WHERE user_id = :user_id ORDER BY entry_time DESC");
        $stmt->execute(['user_id' => $user_id]);
        $geofenceData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['success' => true, 'data' => $geofenceData]);
        exit();
    }

} catch (PDOException $e) {
    error_log('Database error: ' . $e->getMessage(), 3, 'error_log.txt');
    echo json_encode(['success' => false, 'message' => 'A database error occurred.']);
    exit();
} catch (Exception $e) {
    error_log('General error: ' . $e->getMessage(), 3, 'error_log.txt');
    echo json_encode(['success' => false, 'message' => 'An error occurred.']);
    exit();
}
?>
