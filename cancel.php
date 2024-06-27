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

// Validate and retrieve id and token from URL
$id = isset($_GET['id']) ? intval($_GET['id']) : null;
$token = isset($_GET['token']) ? intval($_GET['token']) : null;

if ($id !== null && $token !== null) {
    // Prepare and execute the query to update the status
    $stmt = $conn->prepare("UPDATE employee_leave SET status = 'Cancelled' WHERE id = ? AND token = ?");
    $stmt->bind_param("ii", $id, $token);
    $stmt->execute();
    $stmt->close();
} else {
    echo "Invalid parameters.";
}

// Close connection
$conn->close();

// Redirect to empleave.php
header("Location: empleave.php");
exit();
?>