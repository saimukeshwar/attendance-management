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
$sql = "SELECT * FROM employees";
$result = $conn->query($sql);

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel | Employee Management System</title>
    <link rel="stylesheet" type="text/css" href="styleemplogin.css">
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this employee?');
        }
    </script>
</head>
<body>
    <header>
        <nav>
            <h1>EMS</h1>
            <img src="logo.jpg" alt="">
            <ul id="navli">
                <li><a class="homered" href="aloginwel.php">HOME</a></li>
                <li><a class="homeblack" href="view_employees.php">View Employee</a></li>
                <li><a class="homeblack" href="add_department.php">Department</a></li>
                <li><a class="homeblack" href="add_shift.php">Shift</a></li>
                <li><a class="homeblack" href="location.php">Location</a></li>
                <li><a class="homeblack" href="report.php">Report</a></li>
                <li><a class="homeblack" href="empleave.php">Employee Leave</a></li>
                <li><a class="homeblack" href="logout.php" onClick="return confirm('Are you sure you want to logout?')">Log Out</a></li>
            </ul>
        </nav>
    </header>
     
    <div class="divider"></div>
    <div id="divimg">
        <h2 style="font-family: 'Montserrat', sans-serif; font-size: 25px; text-align: center;">Employee Leaderboard</h2>
        <table>
            <tr bgcolor="#000">
                <th align="center">Emp. ID</th>
                <th align="center">Name</th>
                <th align="center">Date of Birth</th>
                <th align="center">Address</th>
                <th align="center">Department</th>
                <th align="center">Phone</th>
                <th align="center">Email</th>
            </tr>

            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . htmlspecialchars($row["firstname"]) . " " . htmlspecialchars($row["lastname"]) . "</td>";

                    echo "<td>" . htmlspecialchars($row["dob"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["address"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["department"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["phone"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
 
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No employees found.</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
