<?php
session_start();
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
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    // SQL query to retrieve user with matching credentials
    $sql = "SELECT id FROM employees WHERE username='$username' AND password='$password'";

    // Execute SQL query
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $employees = $result->fetch_assoc();
        $empid = $employees['id'];
        
        // Store the user ID in the session
        $_SESSION['empid'] = $empid;

        // Redirect to the employee dashboard
        header("Location: edashboard.php?id=$empid");
        exit();
    } else {
        // If credentials are incorrect
        echo ("<SCRIPT LANGUAGE='JavaScript'>
        window.alert('Invalid Email or Password')
        window.location.href='javascript:history.go(-1)';
        </SCRIPT>");
    }
}

// Close the connection
$conn->close();
?>
