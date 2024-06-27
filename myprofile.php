<?php
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

$id = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($id === null) {
    die("Error: Employee ID is required.");
}

// Query to fetch employee details
$sql = "SELECT * FROM employees WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Error: Employee ID does not exist.");
}

$employee = $result->fetch_assoc();
$stmt->close();
$conn->close();

// Assign variables from the fetched employee details
$username = $employee['username'];
$firstname = $employee['firstname'];
$lastname = $employee['lastname'];
$gender = $employee['gender'];
$dob=$employee['dob'];
$address = $employee['address'];
$department = $employee['department'];
$phone = $employee['phone'];
$email = $employee['email'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | Employee Management System</title>
    <link rel="stylesheet" href="styleemplogin.css">
    <style>
    body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f2f2f2;
        }

        .divider {
            height: 5px;
        }

        .page-wrapper {
            display: fixed;
            justify-content: center;
            align-items: center;
            height: 100vh;
           
        }

        .wrapper {
            display: fixed;
            width: 680px;
            margin: 0 auto;
        }

        .card {
            display: fixed;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
        }

        .card-heading {
             height: 20px;
            background: #2980b9;
            border-top-left-radius: 10px;
            border-top-right-radius: 20px;
            padding: 20px;
        }

        .card-body {
            padding: 10px;
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
        .divide{
            padding: 10px;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <h1>Employee Management System</h1>
            <ul id="navli">
                <li><a class="homeblack" href="edashboard.php?id=<?php echo $id; ?>">HOME</a></li>
                <li><a class="homered" href="myprofile.php?id=<?php echo $id; ?>">My Profile</a></li>
                <li><a class="homeblack" href="empproject.php?id=<?php echo $id; ?>">My Projects</a></li>
                <li><a class="homeblack" href="applyleave.php?id=<?php echo $id; ?>">Apply Leave</a></li>
                <li><a class="homeblack" href="elogin.html" onClick="return confirm('Are you sure you want to logout?')">Log Out</a></li>
            </ul>
        </nav>
    </header>

    <div class="divider"></div>
    <div class="divide"></div>
    <div class="page-wrapper bg-blue p-t-100 p-b-100 font-robo">
        <div class="wrapper wrapper--w680">
            <div class="card card-1">
                <div class="card-heading"></div>
                <div class="card-body">
                    <h2 class="title">My Info</h2>
                    <form method="POST" action="changepassemp.php?id=<?php echo $id?>" >
                    <div class="input-group">
                            <p>Username</p>
                            <input class="input--style-1" type="email" name="email" value="<?php echo htmlspecialchars($username); ?>" readonly>
                        </div>
                       
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <p>First Name</p>
                                    <input class="input--style-1" type="text" name="firstName" value="<?php echo htmlspecialchars($firstname); ?>" readonly>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <p>Last Name</p>
                                    <input class="input--style-1" type="text" name="lastName" value="<?php echo htmlspecialchars($lastname); ?>" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row row-space">                           
                            <div class="col-2">
                                <div class="input-group">
                                    <p>Gender</p>
                                    <input class="input--style-1" type="text" name="gender" value="<?php echo htmlspecialchars($gender); ?>" readonly>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <p>Date of Birth</p>
                                    <input class="input--style-1" type="text" name="birthday" value="<?php echo htmlspecialchars($dob); ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="input-group">
                            <p>Address</p>
                            <input class="input--style-1" type="text" name="address" value="<?php echo htmlspecialchars($address); ?>" readonly>
                        </div>
                        <div class="input-group">
                            <p>Department</p>
                            <input class="input--style-1" type="text" name="dept" value="<?php echo htmlspecialchars($department); ?>" readonly>
                        </div>
                        <div class="input-group">
                            <p>Contact Number</p>
                            <input class="input--style-1" type="number" name="contact" value="<?php echo htmlspecialchars($phone); ?>" readonly>
                        </div>
                        <div class="input-group">
                            <p>Email</p>
                            <input class="input--style-1" type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly>
                        </div>                      
                        
                        <input type="hidden" name="id" id="textField" value="<?php echo htmlspecialchars($id); ?>" required>
                        <div class="p-t-20">
                            <button class="btn btn--radius btn--green" name="send">Change password</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
