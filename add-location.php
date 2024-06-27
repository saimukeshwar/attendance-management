<?php
// Start session
session_start();

// Define database credentials
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

if (isset($_POST['add-location'])) {
    $location = $conn->real_escape_string($_POST['location']);
    
    $insert_query = $conn->query("INSERT INTO location (location) VALUES ('$location')");

    if ($insert_query) {
        $msg = "Location created successfully";
    } else {
        $msg = "Error!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Location</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" type="text/css" href="styleemplogin.css">
<!--body {
    margin: 0;
    font-family: Arial, Helvetica, sans-serif;
    background-color: #f2f2f2;
}

.page-wrapper {
    padding: 20px;
}

.content {
    max-width: 800px;
    margin: 0 auto;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.page-title {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    background-color: #27ae60;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
    text-align: center;
    margin: 0 10px;
}

.btn-primary {
    background-color: #3498db;
}

.btn-primary:hover {
    background-color: #2980b9;
}

.submit-btn {
    background-color: #27ae60;
}

.submit-btn:hover {
    background-color: #219150;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
}

.form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.text-center {
    text-align: center;
}
-->
</head>
<body>
    <header>
        <nav>
            <h1>EMS</h1>
            <img src="logo.jpg" alt="Logo">
            <ul id="navli">
            <li><a class="homeblack" href="aloginwel.php">HOME</a></li>
                <li><a class="homeblack" href="view_employees.php">View Employee</a></li>
                <li><a class="homeblack" href="add_department.php">Department</a></li>
                <li><a class="homeblack" href="add_shift.php">Shift</a></li>
                <li><a class="homered" href="location.php">Location</a></li>
                <li><a class="homeblack" href="report.php">Report</a></li>
                <li><a class="homeblack" href="empleave.php">Employee Leave</a></li>
                <li><a class="homeblack" href="logout.php" onClick="return confirm('Are you sure you want to logout?')">Log Out</a></li>
            </ul>
        </nav>
    </header>
     
    <div class="divider"></div>
    <div class="page-wrapper">
        <div class="content">
            <div class="row">
                <div class="col-sm-4">
                    <h4 class="page-title">Add Location</h4>
                </div>
                <div class="col-sm-8 text-right m-b-20">
                    <a href="location.php" class="btn btn-primary btn-rounded float-right">Back</a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <form method="post">
                        <div class="form-group">
                            <label>Location Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="location" required>
                        </div>
                        <div class="m-t-20 text-center">
                            <button class="btn btn-primary submit-btn" name="add-location">Add Location</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        <?php if (isset($msg)) { echo 'swal("' . $msg . '");'; } ?>
    </script>
</body>
</html>
