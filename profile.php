<?php
// Start the session
session_start();

// Database connection settings
$servername = "localhost";
$username = "root"; // Use your database username
$password = ""; // Use your database password
$dbname = "user_management"; // Replace with your database name

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Fetch user details from the database
$sql = "SELECT firstname, lastname, email, phone_no, profession, country, state, district, city, landmarks, houseNumber, bio,
               mobile1, relation1, mobile2, relation2, mobile3, relation3, mobile4, relation4, mobile5, relation5, created_at 
        FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch user data
    $user = $result->fetch_assoc();
} else {
    echo "No user found!";
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the updated data from the form
    $firstname = $conn->real_escape_string($_POST['firstName']);
    $lastname = $conn->real_escape_string($_POST['lastName']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone_no = $conn->real_escape_string($_POST['contactNumber']);
    $profession = $conn->real_escape_string($_POST['profession']);
    $country = $conn->real_escape_string($_POST['country']);
    $state = $conn->real_escape_string($_POST['state']);
    $district = $conn->real_escape_string($_POST['district']);
    $city = $conn->real_escape_string($_POST['city']);
    $landmarks = $conn->real_escape_string($_POST['landmarks']);
    $houseNumber = $conn->real_escape_string($_POST['houseNumber']);
    $bio = $conn->real_escape_string($_POST['bio']);

    // Handle mobile and relation inputs
    // Handle mobile and relation inputs
$mobiles = [];
$relations = [];
$invalidMobiles = [];
for ($i = 1; $i <= 5; $i++) {
    $mobile = $conn->real_escape_string($_POST["mobile$i"]);
    $mobiles[] = $mobile;
    $relations[] = $conn->real_escape_string($_POST["relation$i"]);

    // Check if the mobile number is not empty
    if (!empty($mobile)) {
        // Check if the mobile number exists in the database
        $check_sql = "SELECT id FROM users WHERE phone_no = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $mobile);
        $check_stmt->execute();
        $check_stmt->store_result();

        // Collect invalid numbers only if they exist in the database
        if ($check_stmt->num_rows > 0) {
            $invalidMobiles[] = $mobile; // Collect invalid numbers
        }
        $check_stmt->close();
    }
}

// If there are invalid numbers, display an error message
if (!empty($invalidMobiles)) {
    $invalidMobilesList = implode(", ", $invalidMobiles);
    echo "<script>alert('The following emergency contacts are already registered: $invalidMobilesList');</script>";
} else {
    // Update the user information in the database if all numbers are valid
    $update_sql = "UPDATE users SET firstname = ?, lastname = ?, email = ?, phone_no = ?, profession = ?, country = ?, state = ?, district = ?, city = ?, landmarks = ?, houseNumber = ?, bio = ?, 
                   mobile1 = ?, relation1 = ?, mobile2 = ?, relation2 = ?, mobile3 = ?, relation3 = ?, mobile4 = ?, relation4 = ?, mobile5 = ?, relation5 = ? 
                   WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssssssssssssssssssssi", 
        $firstname, $lastname, $email, $phone_no, $profession, $country, $state, $district, $city, $landmarks, 
        $houseNumber, $bio, $mobiles[0], $relations[0], $mobiles[1], $relations[1], $mobiles[2], $relations[2], 
        $mobiles[3], $relations[3], $mobiles[4], $relations[4], $user_id);

    if ($update_stmt->execute()) {
        // Redirect to the main page
        echo "<script>window.location.href = 'Abhaya.html';</script>";
        exit();
    } else {
        echo "<script>alert('Error updating profile: " . addslashes($conn->error) . "');</script>";
    }
}

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings Page</title>
    <style>
        /* Global Reset */
        *:before,
        *:after {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: linear-gradient(135deg, white, #e0dde2);
            font-family: 'Arial', sans-serif;
            margin: 0;
        }

        .main-container {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
        }
        
        .logo {
            display: flex;
            justify-content: start;
            margin-bottom: 24px;
        }

        .logo-img {
            width: 80px;
            height: 80px;
        }

        .flex {
            display: flex;
            gap: 24px; /* Increased gap between input fields */
            margin-bottom: 16px;
        }

        .form-container {
            width: 100%;
            max-width: 950px;
            padding: 40px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            animation: fadeIn 0.8s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .title {
            font-size: 3rem;
            font-weight: 800;
            color: #2c3e50;
            text-align: center;
            margin-bottom: 2rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            padding-bottom: 0.5rem;
        }

        .title:hover {
            color: #3498db;
            transition: color 0.3s ease;
        }

        .input,
        .button {
            width: 100%;
            padding: 12px 3px 5px;
            margin-top: 8px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 16px;
        }

        .input:focus {
            border-color: #007BFF;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.2);
        }

        .button {
            cursor: pointer;
            background: #007BFF;
            color: #fff;
            border: none;
            outline: none;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .button:hover {
            background: #0056b3;
        }

        .button:active {
            background: #004494;
            transform: scale(0.98);
        }

        form {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        form div {
            flex: 1 1 100%;
            margin-bottom: 1rem;
        }

        @media (min-width: 768px) {
            form div {
                flex: 1 1 45%;
            }
        }

        form label {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        form button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            transition: background-color 0.3s;
            width: 100%;
            margin-top: 1rem;
            flex: 1 1 100%;
            padding: 12px;
            border-radius: 6px;
        }

        form button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="main-container">
    <div class="form-container">
        <div class="logo">
            <img src="https://th.bing.com/th/id/OIP.j7je_RDzFA28szpzlTSKXgAAAA?rs=1&pid=ImgDetMain" alt="Logo" class="logo-img">
        </div>
        <!-- <h2 class="title">Settings Page</h2> -->
        <h2 class="title">Profile Page</h2>

        <form id="settingsForm" method="POST" action="" onsubmit="return validateForm()">
            <div>
                <label for="firstName"><b>First name</b></label>
                <input type="text" id="firstName" name="firstName" class="input" value="<?php echo htmlspecialchars($user['firstname']); ?>" required />
            </div>
            <div>
                <label for="lastName"><b>Last name</b></label>
                <input type="text" id="lastName" name="lastName" class="input" value="<?php echo htmlspecialchars($user['lastname']); ?>" required />
            </div>
            <div>
                <label for="email"><b>Email</b></label>
                <input type="email" id="email" name="email" class="input" value="<?php echo htmlspecialchars($user['email']); ?>" required />
            </div>
            <div>
                <label for="contactNumber"><b>Phone Number</b></label>
                <input type="tel" id="contactNumber" name="contactNumber" class="input" value="<?php echo htmlspecialchars($user['phone_no']); ?>" required />
            </div>
            <div>
                <label for="profession"><b>Profession</b></label>
                <input type="text" id="profession" name="profession" class="input" value="<?php echo htmlspecialchars($user['profession']); ?>" />
            </div>
            <div>
                <label for="country"><b>Country</b></label>
                <input type="text" id="country" name="country" class="input" value="<?php echo htmlspecialchars($user['country']); ?>" />
            </div>
            <div>
                <label for="state"><b>State</b></label>
                <input type="text" id="state" name="state" class="input" value="<?php echo htmlspecialchars($user['state']); ?>" />
            </div>
            <div>
                <label for="district"><b>District</b></label>
                <input type="text" id="district" name="district" class="input" value="<?php echo htmlspecialchars($user['district']); ?>" />
            </div>
            <div>
                <label for="city"><b>City</b></label>
                <input type="text" id="city" name="city" class="input" value="<?php echo htmlspecialchars($user['city']); ?>" />
            </div>
            <div>
                <label for="landmarks"><b>Landmarks</b></label>
                <input type="text" id="landmarks" name="landmarks" class="input" value="<?php echo htmlspecialchars($user['landmarks']); ?>" />
            </div>
            <div>
                <label for="houseNumber"><b>House Number</b></label>
                <input type="text" id="houseNumber" name="houseNumber" class="input" value="<?php echo htmlspecialchars($user['houseNumber']); ?>" />
            </div>
            <div>
                <label for="bio"><b>Bio</b></label>
                <textarea id="bio" name="bio" class="input" rows="4"><?php echo htmlspecialchars($user['bio']); ?></textarea>
            </div>

            <?php for ($i = 1; $i <= 5; $i++) { ?>
                <div>
                    <label for="mobile<?php echo $i; ?>"><b>Emergency Contact <?php echo $i; ?></b></label>
                    <input type="tel" id="mobile<?php echo $i; ?>" name="mobile<?php echo $i; ?>" class="input"
                           value="<?php echo htmlspecialchars($user["mobile$i"]); ?>"  />
                </div>
                <div>
                    <label for="relation<?php echo $i; ?>"><b>Relation <?php echo $i; ?></b></label>
                    <input type="text" id="relation<?php echo $i; ?>" name="relation<?php echo $i; ?>" class="input"
                           value="<?php echo htmlspecialchars($user["relation$i"]); ?>"  />
                </div>
            <?php } ?>

            <button type="submit" class="button">Save Changes</button>
        </form>
    </div>
</div>

<script>
    function validateForm() {
        const email = document.getElementById('email').value;
        const phone = document.getElementById('contactNumber').value;
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const phoneRegex = /^\d{10}$/;

        if (!emailRegex.test(email)) {
            alert('Invalid email format');
            return false;
        }

        if (!phoneRegex.test(phone)) {
            alert('Phone number must be 10 digits');
            return false;
        }

        return true;
    }
</script>
</body>
</html>
