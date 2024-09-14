<?php
$servername = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "mydb"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if POST data exists
if (isset($_POST['username']) && isset($_POST['password'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Sanitize input
    $user = $conn->real_escape_string($user);

    // Check if the user exists
    $sql = "SELECT * FROM users WHERE username='$user' OR email='$user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, now check password
        $row = $result->fetch_assoc();
        if (password_verify($pass, $row['password'])) {
            // Password is correct, return success response
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Incorrect password']);
        }
        
    } else {
        // User not found
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No data received']);
}

$conn->close();
?>
