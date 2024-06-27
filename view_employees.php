<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System | View Employees</title>
    <link rel="stylesheet" href="styleemplogin.css">
    <style>
        /* CSS to style the add employee button */
        .add-employee-button {
            position:absolute;
            top: 80px;
            right: 20px;
            z-index: 1000; /* Ensure it appears above other content */
        }

        .add-employee-button a.button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff; /* Blue color for the button */
            color: #ffffff; /* White text color */
            text-decoration: none;
            border-radius: 5px;
        }

        .add-admin-button a.button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        /* CSS to style the add employee button */
        .add-admin-button {
            position:absolute;
            top: 80px;
            right: 200px;
            z-index: 1000; /* Ensure it appears above other content */
        }

        .add-admin-button a.button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff; /* Blue color for the button */
            color: #ffffff; /* White text color */
            text-decoration: none;
            border-radius: 5px;
        }

        .add-admin-button a.button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <h1>EMS</h1>
            <img src="logo.jpg" alt="">
            <ul id="navli">
            <li><a class="homeblack" href="aloginwel.php">HOME</a></li>
                <li><a class="homered" href="view_employees.php">View Employee</a></li>
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
    <div class="container">
    <?php
        // PHP code to display employee details from the database

        // Database connection parameters
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

        // Display employee details in a table
        if ($result->num_rows > 0) {
            echo "<h2>Employee Details</h2>";
            echo "<table border='1'>";
            echo "<tr><th>Emp.ID</th><th>username</th><th>Name</th><th>Date of Birth</th><th>Address</th><th>Department</th><th>Phone</th><th>Email</th><th>Actions</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["username"]   ."</td>";
                echo "<td>" . $row["firstname"] . "  " . $row["lastname"] . "</td>";
                echo "<td>" . $row["dob"] . "</td>";
                echo "<td>" . $row["address"] . "</td>";
                echo "<td>" . $row["department"] . "</td>";
                echo "<td>" . $row["phone"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td><a href=\"edit.php?id=$row[id]\">Edit</a> | <a href=\"delete.php?id=$row[id]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No employees found.";
        }

        // Close connection
        $conn->close();
        ?>
    </div>

    <!-- Add Employee button -->
    <div class="add-employee-button">
        <a href="add_employee.php" class="button">Add New Employee</a>
    </div>
    <div class="add-admin-button">
        <a href="add_admin.php" class="button">Add New Admin</a>
    </div>

</body>
</html>
