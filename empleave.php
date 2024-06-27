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

// Query to fetch all employees
$sql = "SELECT employees.id, employees.firstname, employees.lastname, employee_leave.start, employee_leave.end, employee_leave.reason, employee_leave.status, employee_leave.token 
        FROM employees 
        JOIN employee_leave ON employees.id = employee_leave.id 
        ORDER BY employee_leave.token";

$result = $conn->query($sql);

// Check for query execution errors
if ($result === false) {
    die("Error fetching data: " . $conn->error);
}

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Leave | Admin Panel | Employee Management System</title>
    <link rel="stylesheet" type="text/css" href="styleemplogin.css">
</head>
<body>
    <header>
        <nav>
            <h1>EMS</h1>
            <ul id="navli">
            <li><a class="homeblack" href="aloginwel.php">HOME</a></li>
                <li><a class="homeblack" href="view_employees.php">View Employee</a></li>
                <li><a class="homeblack" href="add_department.php">Department</a></li>
                <li><a class="homeblack" href="add_shift.php">Shift</a></li>
                <li><a class="homeblack" href="location.php">Location</a></li>
                <li><a class="homeblack" href="report.php">Report</a></li>
                <li><a class="homeblack" href="empleave.php">Employee Leave</a></li>
                <li><a class="homebred" href="logout.php" onClick="return confirm('Are you sure you want to logout?')">Log Out</a></li>
            </ul>
        </nav>
    </header>

    <div class="divider"></div>
    <div id="divimg">
        <table>
            <tr>
                <th>Emp. ID</th>
                <th>Token</th>
                <th>Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Total Days</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Options</th>
            </tr>

            <?php
            if ($result->num_rows > 0) {
                while ($employee = $result->fetch_assoc()) {
                    $date1 = new DateTime($employee['start']);
                    $date2 = new DateTime($employee['end']);
                    $interval = $date1->diff($date2);
                    
                    echo "<tr>";
                    echo "<td>".$employee['id']."</td>";
                    echo "<td>".$employee['token']."</td>";
                    echo "<td>".$employee['firstname']." ".$employee['lastname']."</td>";
                    echo "<td>".$employee['start']."</td>";
                    echo "<td>".$employee['end']."</td>";
                    echo "<td>".$interval->days + 1 ."</td>"; // Including both start and end date
                    echo "<td>".$employee['reason']."</td>";
                    echo "<td>".$employee['status']."</td>";
                    echo "<td><a href=\"approve.php?id=".$employee['id']."&token=".$employee['token']."\" onClick=\"return confirm('Are you sure you want to approve the request?')\">Approve</a> | <a href=\"cancel.php?id=".$employee['id']."&token=".$employee['token']."\" onClick=\"return confirm('Are you sure you want to cancel the request?')\">Cancel</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No leave records found.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>