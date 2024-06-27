<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if department ID is provided via POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['department_id'])) {
    $department_id = $conn->real_escape_string($_POST['department_id']);

    // SQL query to delete department
    $sql = "DELETE FROM departments WHERE id='$department_id'";

    if ($conn->query($sql) === TRUE) {
               header("Location: add_department.php");
        exit();
    } else {
        echo "Error deleting department: " . $conn->error;
    }
}

$conn->close();
?>
