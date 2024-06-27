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

$id = isset($_GET['id']) ? intval($_GET['id']) : null;

$sql1 = "SELECT * FROM `employees` where id = '$id'";
$result1 = mysqli_query($conn, $sql1);
$employees = mysqli_fetch_array($result1);
$empName = ($employees['firstname']);

$sql = "SELECT id, firstname, lastname,  points FROM employees, rank WHERE rank.eid = employees.id order by rank.points desc";
// Query to fetch leaderboard
$sql1 = "SELECT * FROM employees ORDER BY points DESC";
$result1 = mysqli_query($conn, $sql1);

// Query to fetch due projects
$sql2 = "SELECT * FROM projects WHERE emp_id = $id AND status = 'Due'";
$result2 = mysqli_query($conn, $sql2);

// Query to fetch salary details
$sql3 = "SELECT * FROM salary WHERE emp_id = $id";
$result3 = mysqli_query($conn, $sql3);

// Query to fetch leave details
$sql4 = "SELECT * FROM employee_leave WHERE emp_id = $id";
$result4 = mysqli_query($conn, $sql4);

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Panel | Employee Management System</title>
    <link rel="stylesheet" type="text/css" href="styleemplogin.css">
    
</head>
<body>
    <header>
    <nav>
    <h1>Employee Management System</h1>
    <ul id="navli">
         
            <li><a class="homered" href="edashboard.php?id=<?php echo $id; ?>"">HOME</a></li>
            <li><a class="homeblack" href="myprofile.php?id=<?php echo $id; ?>"">My Profile</a></li>
            <li><a class="homeblack" href="empproject.php?id=<?php echo $id; ?>"">My Projects</a></li>
            <li><a class="homeblack" href="applyleave.php?id=<?php echo $id; ?>"">Apply Leave</a></li>
        
        <li><a class="homeblack" href="elogin.html" onClick="return confirm('Are you sure you want to logout?')">Log Out</a></li>
    </ul>
</nav>

    </header>

    <div class="divider"></div>
    <div id="divimg">
        <h2>Employee Leaderboard</h2>
        <table>
            <tr>
                <th align="center">Emp. ID</th>
                <th align="center">Name</th>               
            </tr>
            <?php
            $seq ;
            while ($employees = $result1->fetch_assoc()) {
                echo "<tr>";
               
                echo "<td>" . $employees['id'] . "</td>";
                echo "<td>" . $employees['firstName'] . " " . $employees['lastName'] . "</td>";
                echo "</tr>";
                $seq++;
            }
            ?>
        </table>

        <h2>Due Projects</h2>
        <table>
            <tr>
                <th align="center">Project Name</th>
                <th align="center">Due Date</th>
            </tr>
            <?php
            while ($project = $result2->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $project['pname'] . "</td>";
                echo "<td>" . $project['duedate'] . "</td>";
                echo "</tr>";
            }
            ?>
        </table>

        <h2>Salary Status</h2>
        <table>
            <tr>
                <th align="center">Base Salary</th>
                <th align="center">Bonus</th>
                <th align="center">Total Salary</th>
            </tr>
            <?php
            while ($salary = $result3->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $salary['base'] . "</td>";
                echo "<td>" . $salary['bonus'] . " %</td>";
                echo "<td>" . $salary['total'] . "</td>";
                echo "</tr>";
            }
            ?>
        </table>

        <h2>Leave Status</h2>
        <table>
            <tr>
                <th align="center">Start Date</th>
                <th align="center">End Date</th>
                <th align="center">Total Days</th>
                <th align="center">Reason</th>
                <th align="center">Status</th>
            </tr>
            <?php while ($leave = $result4->fetch_assoc()) : ?>
                <?php
                // Calculate the total days of leave
                $date1 = new DateTime($leave['start']);
                $date2 = new DateTime($leave['end']);
                $interval = $date1->diff($date2);
                ?>
                <tr>
                    <td><?php echo $leave['start']; ?></td>
                    <td><?php echo $leave['end']; ?></td>
                    <td><?php echo $interval->days; ?></td>
                    <td><?php echo $leave['reason']; ?></td>
                    <td><?php echo $leave['status']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
