<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Management System</title>
    <link rel="stylesheet" type="text/css" href="styleemplogin.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }


        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        #departmentsList ul {
            list-style-type: none;
            padding: 0;
        }

        #departmentsList li {
            display: flex; /* Using flexbox */
            justify-content: space-between; /* Space between department name and delete button */
            align-items: center; /* Align items vertically */
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        #departmentsList li:hover {
            background-color: #e9e9e9;
        }

        button {
            padding: 8px 12px;
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        button:hover {
            background-color: #c82333;
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
                <li><a class="homeblack" href="view_employees.php">View Employee</a></li>
                <li><a class="homered" href="add_department.php">Department</a></li>
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
        <h1>Department Management System</h1>
        <!-- Department Form -->
        <form id="departmentForm" action="add_department.php" method="POST">
            <label for="name">Department Name:</label>
            <input type="text" id="name" name="name" required>
            <button type="submit">Add Department</button>
        </form>
        
        <div id="departmentsList">
            <h2>Departments</h2>
            <?php
            // Database connection
            $conn = new mysqli("localhost", "root", "", "db");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Insert new department
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $name = $conn->real_escape_string($_POST['name']);
                $sql = "INSERT INTO departments (name) VALUES ('$name')";
                
                if ($conn->query($sql) === TRUE) {
                    header("Location: add_department.php");
                    exit();
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }

            // Display departments
            $sql = "SELECT * FROM departments";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<ul>";
                while ($row = $result->fetch_assoc()) {
                    echo "<li>";
                    echo htmlspecialchars($row['name']);
                    echo " <form action='department_delete.php' method='POST' style='display: inline;'>";
                    echo "<input type='hidden' name='department_id' value='{$row['id']}'>";
                    echo "<button type='submit' onclick=\"return confirm('Are you sure you want to delete this department?')\">Delete</button>";
                    echo "</form>";
                    echo "</li>";
                }
                echo "</ul>";
            } else {
                echo "No departments found.";
            }

            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
