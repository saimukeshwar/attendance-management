<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the database connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID parameter is provided and is a valid integer
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the DELETE query using a prepared statement to prevent SQL injection
    $sql = "DELETE FROM employees WHERE id=?";


    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Check if the statement is prepared successfully
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind the parameter to the statement (using "i" for integer type)
    $stmt->bind_param("i", $id);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to the display page after successful deletion
        header("Location: view_employees.php");

        exit(); // Stop further execution after redirection
    } else {
        echo "Error deleting record: " . $stmt->error;
    }

    // Close the statement (not necessary if using PDO)
    $stmt->close();
} else {
    echo "Invalid employee ID.";
}

// Close the connection (not necessary if using PDO)
$conn->close();
?>
