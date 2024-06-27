<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Shift Timing</title>
    <link rel="stylesheet" href="4styles.css">
    <link rel="stylesheet" type="text/css" href="styleemplogin.css">
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
                <li><a class="homered" href="add_shift.php">Shift</a></li>
                <li><a class="homeblack" href="location.php">Location</a></li>
                <li><a class="homeblack" href="report.php">Report</a></li>
                <li><a class="homeblack" href="empleave.php">Employee Leave</a></li>
                <li><a class="homeblack" href="logout.php" onClick="return confirm('Are you sure you want to logout?')">Log Out</a></li>
            </ul>
        </nav>
    </header>
    <div class="divider"></div>
    <div class="container">
        <div class="left-panel">
            <h2>Add Shift Timing</h2>
            <?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind parameters
    $shift_name = $conn->real_escape_string($_POST['shift_name']);
    $start_time = $conn->real_escape_string($_POST['start_time']);
    $end_time = $conn->real_escape_string($_POST['end_time']);

    // SQL query to insert shift timing
    $sql = "INSERT INTO shifts (shift_name, start_time, end_time) VALUES ('$shift_name', '$start_time', '$end_time')";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Shift timing added successfully!</p>";
        // Redirect to a different page after successful insertion
        header("Location: add_shift.php"); // Replace 'shift_list.php' with your actual shift list page
        exit(); // Stop further execution after redirection
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>


            <!-- Shift Timing Form -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <label for="shift_name">Shift Name:</label>
                <input type="text" id="shift_name" name="shift_name" required><br><br>
                <label for="start_time">Start Time:</label>
                <input type="time" id="start_time" name="start_time" required><br><br>
                <label for="end_time">End Time:</label>
                <input type="time" id="end_time" name="end_time" required><br><br>
                <input type="submit" value="Add Shift">
            </form>
        </div>

        <div class="right-panel">
            <div class="shift">
                <h2>Shift Timings</h2>

                <?php
                // Reconnect to the database
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // SQL query to fetch all shift timings
                $sql = "SELECT * FROM shifts";
                $result = $conn->query($sql);

                // Display shift timings in a table
                if ($result->num_rows > 0) {
                    echo '<table>';
                    echo '<tr>';
                    echo '<th>Shift Name</th>';
                    echo '<th>Start Time</th>';
                    echo '<th>End Time</th>';
                    echo '<th>Action</th>';
                    echo '</tr>';

                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row["shift_name"]) . '</td>';
                        echo '<td>' . htmlspecialchars($row["start_time"]) . '</td>';
                        echo '<td>' . htmlspecialchars($row["end_time"]) . '</td>';
                        echo '<td><a href="deleted.php?id=' . $row["id"] . '" onClick="return confirm(\'Are you sure you want to delete?\')">Delete</a></td>';
                        echo '</tr>';
                    }

                    echo '</table>';
                } else {
                    echo "No shift timings found.";
                }

                // Close connection
                $conn->close();
                ?>
            </div>
        </div>
    </div>
</body>
</html>
