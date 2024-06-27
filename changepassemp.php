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

if (isset($_POST['update'])) {
    $id = $conn->real_escape_string($_POST['id']);
    $old = $conn->real_escape_string($_POST['oldpass']);
    $new = $conn->real_escape_string($_POST['newpass']);

    // Retrieve the current password for the given user ID
    $sql = "SELECT `password` FROM `employees` WHERE `id` = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $employee = $result->fetch_assoc();

    if ($employee) {
        // Debugging statement
        echo "Old Password (from DB): " . $employee['password'] . "<br>";
        echo "Old Password (input): " . $old . "<br>";

        if ($old == $employee['password']) {
            // Update the password
            $sql = "UPDATE `employees` SET `password` = ? WHERE `id` = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                die("Error preparing statement: " . $conn->error);
            }

            $stmt->bind_param("si", $new, $id);
            if ($stmt->execute()) {
                echo ("<SCRIPT LANGUAGE='JavaScript'>
                    window.alert('Password Updated')
                    window.location.href='myprofile.php?id=$id';
                    </SCRIPT>");
            } else {
                echo ("<SCRIPT LANGUAGE='JavaScript'>
                    window.alert('Failed to Update Password')
                    window.location.href='javascript:history.go(-1)';
                    </SCRIPT>");
            }
        } else {
            echo ("<SCRIPT LANGUAGE='JavaScript'>
                window.alert('Old Password is incorrect')
                window.location.href='javascript:history.go(-1)';
                </SCRIPT>");
        }
    } else {
        echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('User not found')
            window.location.href='javascript:history.go(-1)';
            </SCRIPT>");
    }

    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Change Password | Employee Management System</title>
    <link rel="stylesheet" href="styleemplogin.css">
</head>
<body>
  <header>
    <nav>
      <h1>Employee Management System</h1>
      <ul id="navli">
        <li><a class="homeblack" href="edashboard.php?id=<?php echo $id ?>">HOME</a></li>
        <li><a class="homered" href="myprofile.php?id=<?php echo $id ?>">My Profile</a></li>
        <li><a class="homeblack" href="applyleave.php?id=<?php echo $id ?>">Apply Leave</a></li>
        <li><a class="homeblack" href="elogin.html">Log Out</a></li>
      </ul>
    </nav>
  </header>
  
  <div class="divider"></div>
  
  <div class="page-wrapper bg-blue p-t-100 p-b-100 font-robo">
    <div class="wrapper wrapper--w680">
      <div class="card card-1">
        <div class="card-heading"></div>
        <div class="card-body">
          <h2 class="title">Update Password</h2>
          <form id="registration" action="changepassemp.php" method="POST">
            <div class="row row-space">
              <div class="col-2">
                <div class="input-group">
                  <p>Old Password</p>
                  <input class="input--style-1" type="password" name="oldpass" required>
                </div>
              </div>
              <div class="col-2">
                <div class="input-group">
                  <p>New Password</p>
                  <input class="input--style-1" type="password" name="newpass" required>
                </div>
              </div>
            </div>
            <input type="hidden" name="id" id="textField" value="<?php echo $_GET['id']; ?>" required>
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
