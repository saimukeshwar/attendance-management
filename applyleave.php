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

if ($id === null) {
    die("Error: Employee ID is required.");
}

// Check if employee exists
$stmt = $conn->prepare("SELECT * FROM employees WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("Error: Employee ID does not exist.");
}
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reason = $_POST['reason'];
    $start = $_POST['start'];
    $end = $_POST['end'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO employee_leave (id, start, end, reason, status) VALUES (?, ?, ?, ?, 'Pending')");
    $stmt->bind_param("isss", $id, $start, $end, $reason);

    if ($stmt->execute()) {
        echo "<script>alert('Leave request submitted successfully!');</script>";
        echo "<script>window.location.href='applyleave.php?id=$empid';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply Leave | Employee Management System</title>
    <link rel="stylesheet" href="styleemplogin.css">
  <style>body {
    margin: 0;
    font-family: Arial, Helvetica, sans-serif;
    background-color: #f2f2f2;
}



.container {
    width: 98% auto;
    max-width: 800px auto;
    margin:  auto;
    padding: 20px ;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.title {
    font-size: 24px;
    font-weight: 700;
    color: #333;
    text-align: center;
    margin-bottom: 20px;
}

form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.input-group {
    display: fixed;
    flex-direction: column;
}

label {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 5px;
}

input[type="text"], input[type="date"] {
    width: 98%;
    padding: 10px ;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
}

button {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 5px;
    background-color: #27ae60;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
}

button:hover {
    background-color: #219150;
}
</style>
</head>
<body>
    <header>
        <h1>Employee Management System</h1>
        <nav>
            <ul>
            <li><a class="homeblack" href="edashboard.php?id=<?php echo $id ?>">HOME</a></li>
        <li><a class="homeblack" href="myprofile.php?id=<?php echo $id ?>">My Profile</a></li>
        <li><a class="homered" href="applyleave.php?id=<?php echo $id ?>">Apply Leave</a></li>
        <li><a class="homeblack" href="elogin.html">Log Out</a></li>
            </ul>
        </nav>
    </header>
    <div class="divider"></div>
    <div class="container">
        <h2 class="title">Apply Leave Form</h2>
        <form action="applyleave.php?id=<?php echo $id ?>" method="POST">
            <div class="input-group">
                <label for="reason">Reason</label>
                <input type="text" id="reason" name="reason" required>
            </div>
            <div class="input-group">
                <label for="start">Start Date</label>
                <input type="date" id="start" name="start" required>
            </div>
            <div class="input-group">
                <label for="end">End Date</label>
                <input type="date" id="end" name="end" required>
            </div>
            <button type="submit">Submit</button>
        </form>
        
        <div class="table-wrapper">
            <h2 class="title">Leave Requests</h2>
            <table>
                <tr>
                    <th>Emp. ID</th>
                    <th>Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Total Days</th>
                    <th>Reason</th>
                    <th>Status</th>
                </tr>
                <?php
                if ($id !== null) {
                    $stmt = $conn->prepare("
                        SELECT e.id, e.firstname, e.lastname, l.start, l.end, l.reason, l.status
                        FROM employees AS e
                        JOIN employee_leave AS l ON e.id = l.id
                        WHERE e.id = ?
                        ORDER BY l.token
                    ");

                    if (!$stmt) {
                        die("Prepare failed: " . $conn->error);
                    }

                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while ($employee = $result->fetch_assoc()) {
                        $date1 = new DateTime($employee['start']);
                        $date2 = new DateTime($employee['end']);
                        $interval = $date1->diff($date2);

                        echo "<tr>";
                        echo "<td>".$employee['id']."</td>";
                        echo "<td>".$employee['firstname']." ".$employee['lastname']."</td>";
                        echo "<td>".$employee['start']."</td>";
                        echo "<td>".$employee['end']."</td>";
                        echo "<td>".$interval->days."</td>";
                        echo "<td>".$employee['reason']."</td>";
                        echo "<td>".$employee['status']."</td>";
                        echo "</tr>";
                    }

                    // Close statement
                    $stmt->close();
                }

                // Close connection
                $conn->close();
                ?>
            </table>
        </div>
    </div>
</body>
</html>
