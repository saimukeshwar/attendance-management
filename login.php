<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve username and password from form submission (assuming you are using POST method)
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL query to retrieve user with matching credentials
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    
    // Execute SQL query
    $result = $conn->query($sql);

    // Check if query execution was successful
    if ($result === false) {
        die("Error executing query: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        // Valid credentials, redirect to dashboard or home page
        header("Location: aloginwel.php");
        exit();
    } else {
        // Invalid credentials, display error message
        echo "<script>alert('Invalid username or password.');</script>";
        echo "<script>window.location.href='login.html';</script>";
    }
} else {
    // Error: Username or password not provided
    echo "<script>alert('Please provide both username and password.');</script>";

}

$conn->close();
?>
