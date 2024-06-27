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

// Getting id and token from URL and validating them
if (isset($_GET['id']) && isset($_GET['token'])) {
    $id = intval($_GET['id']);
    $token = intval($_GET['token']);

    // Prepare and execute the query to update the status
    $stmt = $conn->prepare("UPDATE employee_leave SET status = 'Approved' WHERE id = ? AND token = ?");
    $stmt->bind_param("ii", $id, $token);
    if ($stmt->execute()) {
        // Redirecting to the display page (empleave.php)
        header("Location: empleave.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    // Close statement
    $stmt->close();
} else {
    echo "Invalid parameters.";
}

// Close connection
$conn->close();
?>