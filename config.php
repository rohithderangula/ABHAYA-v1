<?php
// Database configuration

// Database host (use 'localhost' for local development, or provide the IP address or domain for remote databases)
define('DB_HOST', 'localhost');

// Database name (replace with your actual database name)
define('DB_NAME', 'user_management');

// Database username (replace with your actual username)
define('DB_USER', 'root');

// Database password (replace with your actual password, or leave it empty for no password on local setup)
define('DB_PASS', '');

// Set the character set to UTF-8MB4 (Recommended for better compatibility with multi-byte characters, including emojis)
define('DB_CHARSET', 'utf8mb4');

// Database connection options
define('DB_OPTIONS', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Enable exception handling for database errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Fetch data as an associative array
    PDO::ATTR_EMULATE_PREPARES => false, // Disable emulation of prepared statements (for better security)
]);

// Timeout for database connection (optional, can be adjusted for performance)
define('DB_TIMEOUT', 30);  // Timeout in seconds for database connection

?>
