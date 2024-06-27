<?php
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

if(isset($_POST['update'])) {
    $id = $_POST['id'];
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    $sql = "UPDATE employees SET username='$username',firstname='$firstname', lastname='$lastname', gender='$gender', dob='$dob', address='$address', department='$department', phone='$phone', email='$email', password='$password' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Record updated successfully');</script>";
        echo "<script>window.location.href='view_employees.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$id = isset($_GET['id']) ? $_GET['id'] : '';
$sql = "SELECT * FROM employees WHERE id=$id";
$result = $conn->query($sql);

if ($result === false) {
    die("Error: " . $conn->error);
}

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $username=$row['username'];
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $gender = $row['gender'];
    $dob = $row['dob'];
    $address = $row['address'];
    $department = $row['department'];
    $phone = $row['phone'];
    $email = $row['email'];
    $password = $row['password'];
} else {
    echo "0 results";
}

$conn->close();
?>

<html>
<head>
    <title>View Employee | Admin Panel | Employee Management System</title>
    <link rel="stylesheet" type="text/css" href="styleemplogin.css">
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

    <div class="page-wrapper bg-blue p-t-100 p-b-100 font-robo">
        <div class="wrapper wrapper--w680">
            <div class="card card-1">
                <div class="card-heading"></div>
                <div class="card-body">
                    <h2 class="title">Update Employee Info</h2>
                    <form id="registration" action="edit.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="input-group">
                        <input class="input--style-1" type="text" name="username" placeholder="username" value="<?php echo $username; ?>" required>

                        </div>
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <input class="input--style-1" type="text" name="firstname" placeholder="firstname" value="<?php echo $firstname; ?>" required>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <input class="input--style-1" type="text" name="lastname" placeholder="lastname" value="<?php echo $lastname; ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="input-group">
                            <select class="input--style-1" name="gender" required>
                            <option disabled value="">GENDER</option>
                            <option value="Male" <?php if ($gender == "Male") echo "selected"; ?>>Male</option>
                            <option value="Female" <?php if ($gender == "Female") echo "selected"; ?>>Female</option>
                            <option value="Other" <?php if ($gender == "Other") echo "selected"; ?>>Other</option>
                            </select>   
                        </div>
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <input class="input--style-1" type="text" name="dob" placeholder="dob" value="<?php echo $dob; ?>" required>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <input class="input--style-1" type="text" name="address" placeholder="address" value="<?php echo $address; ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="input-group">
                            <input class="input--style-1" type="text" name="department" placeholder="department" value="<?php echo $department; ?>" required>
                        </div>

                        <div class="input-group">
                            <input class="input--style-1" type="number" name="phone" placeholder="phone" value="<?php echo $phone; ?>" required>
                        </div>

                        <div class="input-group">
                            <input class="input--style-1" type="text" name="email" placeholder="email" value="<?php echo $email; ?>" required>
                        </div>
                        <div class="input-group">
                            <input class="input--style-1" type="password" name="password" placeholder="password" value="<?php echo $password; ?>" required>
                        </div>

                        <div class="p-t-20">
                            <button class="btn btn--radius btn--green" type="submit" name="update">Submit</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
