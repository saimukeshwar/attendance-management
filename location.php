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

// Create tbl_location table if it doesn't exist
$createTableQuery = "CREATE TABLE IF NOT EXISTS location (
    id INT(11) NOT NULL AUTO_INCREMENT,
    location VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

if (!$conn->query($createTableQuery)) {
    die("Error creating table: " . $conn->error);
}

// Handle deletion
if (isset($_GET['ids'])) {
    $id = $_GET['ids'];
    
    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM location WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
    
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    <link rel="stylesheet" type="text/css" href="styleemplogin.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f2f2f2;
        }

        .page-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;

            padding: 20px;
        }

        .content {
            width: 100%;
            max-width: 1000px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .page-title {
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
        }

        .btn-rounded {
            border-radius: 50px;
        }

        .table-responsive {
            margin-top: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #3498db;
            color: white;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .dropdown-action {
            position: relative;
            display: inline-block;
        }

        .action-icon {
            cursor: pointer;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            background-color: #fff;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-menu a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-menu a:hover {
            background-color: #ddd;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }
    </style>
    <script language="JavaScript" type="text/javascript">
        function confirmDelete(){
            return confirm('Are you sure want to delete this Location?');
        }
    </script>
</head>
<body>
</head>
<body>
    <header>
        <nav>
            <h1>EMS</h1>
            <img src="logo.jpg" alt="">
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
                <div class="col-sm-4 col-3">
                    <h4 class="page-title">Location</h4>
                </div>
                <div class="col-sm-8 col-9 text-right m-b-20">
                    <a href="add-location.php"><i class="fa fa-plus"></i> Add Location</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="datatable table table-stripped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Location</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $fetch_query = $conn->query("SELECT * FROM location");
                        while ($row = $fetch_query->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['location']); ?></td>
                            <td>
                               
                                    <div >
                                        <a class="dropdown-item" href="edit-location.php?id=<?php echo htmlspecialchars($row['id']); ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>|
                                        <a class="dropdown-item" href="location.php?ids=<?php echo htmlspecialchars($row['id']); ?>" onclick="return confirmDelete()"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                    </div>
                             
                            </td>
                        </tr>
                        <?php
                        }
                        $fetch_query->free();
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
 </body>
</html>