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
if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password'];

    // Sanitize input
    $user = $conn->real_escape_string($user);
    $email = $conn->real_escape_string($email);
    $pass = $conn->real_escape_string($pass);

    // Check if the email already exists
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Email already exists
        echo json_encode(['status' => 'error', 'message' => 'Email already registered']);
    } else {
        // Hash the password
        $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

        // Insert the new user
        $sql = "INSERT INTO users (username, email, password) VALUES ('$user', '$email', '$hashedPassword')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error occurred during registration']);
        }
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No data received']);
}

$conn->close();
?>
