<?php
// Start session
session_start();

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

// Check if update button was clicked
if (isset($_POST['update'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Update query using prepared statements
    $stmt = $conn->prepare("UPDATE `employees` SET `email` = ?, `phone` = ?, `address` = ? WHERE id = ?");
    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }

    $stmt->bind_param("sssi", $email, $phone, $address, $id);

    if ($stmt->execute()) {
        echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Successfully Updated');
            window.location.href='myprofile.php?id=$id';
        </SCRIPT>");
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
}

// Ensure $id is retrieved correctly
$id = isset($_GET['id']) ? intval($_GET['id']) : '';
if ($id === 0) {
    die("Invalid employee ID.");
}

$sql = "SELECT * FROM `employees` WHERE id = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error preparing the statement: " . $conn->error);
}

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Error: Employee ID does not exist.");
}

$employee = $result->fetch_assoc();
$username = $employee['username'];
$firstname = $employee['firstname'];
$lastname = $employee['lastname'];
$gender = $employee['gender'];
$dob=$employee['dob'];
$address = $employee['address'];
$department = $employee['department'];
$phone = $employee['phone'];
$email = $employee['email'];
$stmt->close();
$conn->close();
?>

<html>
<head>
    <title>Update Profile | Employee Management System</title>
    <!-- Icons font CSS-->
    <link rel="stylesheet" href="styleemplogin.css">
    <style>
    body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f2f2f2;
        }

        .divider {
            height: 20px;
        }

        .page-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #3498db;
        }

        .wrapper {
            width: 680px;
            margin: 0 auto;
        }

        .card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
        }

        .card-heading {
            background: #2980b9;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            padding: 20px;
        }

        .card-body {
            padding: 20px;
        }

        .title {
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input--style-1 {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #27ae60;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
        }

        .btn:hover {
            background-color: #219150;
        }

        .row {
            display: flex;
            justify-content: space-between;
        }

        .col-2 {
            width: 48%;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <h1>Employee Management System</h1>
            <ul id="navli">
                <li><a class="homeblack" href="eloginwel.php?id=<?php echo htmlspecialchars($id); ?>">HOME</a></li>
                <li><a class="homered" href="myprofile.php?id=<?php echo htmlspecialchars($id); ?>">My Profile</a></li>
                <li><a class="homeblack" href="applyleave.php?id=<?php echo htmlspecialchars($id); ?>">Apply Leave</a></li>
                <li><a class="homeblack" href="elogin.html" onclick="return confirm('Are you sure you want to logout?')">Log Out</a></li>
            </ul>
        </nav>
    </header>
    <div class="divider"></div>
    <div class="page-wrapper bg-blue p-t-100 p-b-100 font-robo">
        <div class="wrapper wrapper--w680">
            <div class="card card-1">
                <div class="card-heading"></div>
                <div class="card-body">
                    <h2 class="title">Update Employee Info</h2>
                    <form id="registration" action="myprofileup.php" method="POST">
                        <div class="input-group">
                            <p>Email</p>
                            <input class="input--style-1" type="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                        </div>
                        <div class="input-group">
                            <p>Contact</p>
                            <input class="input--style-1" type="number" name="contact" value="<?php echo htmlspecialchars($phone); ?>">
                        </div>
                        <div class="input-group">
                            <p>Address</p>
                            <input class="input--style-1" type="text" name="address" value="<?php echo htmlspecialchars($address); ?>">
                        </div>
                        <input type="hidden" name="id" id="textField" value="<?php echo htmlspecialchars($id); ?>" required>
                        <div class="p-t-20">
                            <button class="btn btn--radius btn--green" type="submit" name="update">Submit</button>
                        </div>
                    </form>
                    <br>
                    <button class="btn btn--radius btn--green" onclick="window.location.href = 'changepassemp.php?id=<?php echo htmlspecialchars($id); ?>';">Change Password</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
