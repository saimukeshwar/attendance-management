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

$id = $_GET['id'];

// Fetch the current location
if ($stmt = $conn->prepare("SELECT location FROM location WHERE id = ?")) {
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($location);
    $stmt->fetch();
    $stmt->close();
}

if (isset($_POST['save-location'])) {
    $location = $conn->real_escape_string($_POST['location']);
    
    // Update location
    if ($stmt = $conn->prepare("UPDATE location SET location = ? WHERE id = ?")) {
        $stmt->bind_param("si", $location, $id);
        if ($stmt->execute()) {
            echo$msg = "Location updated successfully";
         
            // Refresh the location after update
            $stmt->close();
            if ($stmt = $conn->prepare("SELECT location FROM location WHERE id = ?")) {
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $stmt->bind_result($location);
                $stmt->fetch();
                $stmt->close();
            }
        } else {
            $msg = "Error updating location: " . $stmt->error;
        }
        //$stmt->close();
    } else {
        $msg = "Error preparing statement: " . $conn->error;
    }
}

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Location</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" type="text/css" href="styleemplogin.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
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
                    <h4 class="page-title">Edit Location</h4>
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
                            <input class="form-control" type="text" name="location" value="<?php echo htmlspecialchars($location); ?>" required>
                        </div>
                        <div class="m-t-20 text-center">
                            <button class="btn btn-primary submit-btn" name="save-location">Save</button>
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
