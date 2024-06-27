<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "db";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Enable error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Fetch departments from the database
$departments = [];
$sql = "SELECT id, name FROM departments";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $departments[] = $row;
    }
}

// Fetch shifts from the database
$shifts = [];
$sql_shifts = "SELECT id, shift_name, start_time, end_time FROM shifts";
$result_shifts = $conn->query($sql_shifts);

if ($result_shifts->num_rows > 0) {
    while ($row = $result_shifts->fetch_assoc()) {
        $shifts[] = $row;
    }
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data using $_POST
    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $department = $_POST['department'];
    $shift = $_POST['shifts'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Use password hashing

    // Prepare SQL statement to insert employee record using prepared statements
    $sql = "INSERT INTO employees (username, firstname, lastname, gender, dob, address, department, shift, phone, email, password) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Check if prepare() succeeded
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters and execute SQL statement
    $stmt->bind_param("ssssssssss", $username, $firstname, $lastname, $gender, $dob, $address, $department, $shift, $phone, $email, $password);

    if ($stmt->execute()) {
        // Redirect to view_employees.php after successful insertion
        echo "<script>alert('Employee added successfully');</script>";
        echo "<script>window.location.href='view_employees.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
    <link rel="stylesheet" href="styleemplogin.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            display: absolute;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 400px; /* Adjust width as needed */
            margin: 50px auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        input, select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
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

        <h2>Add Employee</h2>
        <div >
            <a href="view_employees.php" class="btn btn-primary btn-rounded float-right">Back</a>
        </div>
        <form id="addEmployeeForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="text" name="firstname" placeholder="First Name" required><br>
            <input type="text" name="lastname" placeholder="Last Name" required><br>
            <select name="gender" required>
                <option disabled selected value="">GENDER</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select><br>
            <input type="date" name="dob" required><br>
            <input type="text" name="address" placeholder="Address" required><br>
            <select name="department" required>
                <option disabled selected value="">Select Department</option>
                <?php
                foreach ($departments as $department) {
                    echo "<option value='" . $department['name'] . "'>" . $department['name'] . "</option>";
                }
                ?>
            </select><br>
            <select name="shifts" required>
                <option disabled selected value="">Select Shift</option>
                <?php
                foreach ($shifts as $shift) {
                    echo "<option value='" . $shift['shift_name'] . "'>" . $shift['shift_name'] . " (" . $shift['start_time'] . " - " . $shift['end_time'] . ")</option>";
                }
                ?>
            </select><br>
            <input type="text" name="phone" placeholder="Phone Number" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit">Add Employee</button>
        </form>
    </div>
</body>
</html>
