<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (empty($_SESSION['name'])) {
    header('location:edashboard.php');
    exit();
}

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

$id = $_SESSION['id'];

// Fetch employee shifts - ensure the correct column name is used here
$fetch_query = $conn->query("SELECT shift FROM employees WHERE id='$id'");
if (!$fetch_query) {
    die("Error fetching shifts: " . $conn->error);
}
$shifts = $fetch_query->fetch_assoc();

// Fetch employee details
$fetch_emp = $conn->query("SELECT * FROM employees WHERE id='$id'");
if (!$fetch_emp) {
    die("Error fetching employee details: " . $conn->error);
}
$emp = $fetch_emp->fetch_assoc();
$empid = $emp['employee_id'];
$dept = $emp['department']; // Make sure the column names are correct

date_default_timezone_set('Asia/Kolkata');
$curr_date = date('Y-m-d');
$time = date('H:i:s');

$shifttime = substr($shifts['shift'], 0, 8); // Ensure the correct column name is used
$intime = (strtotime($time) > strtotime($shifttime)) ? "Late" : "On Time";

$outtimeshift = substr($shifts['shift'], -8); // Ensure the correct column name is used
$outtime = (strtotime($time) > strtotime($outtimeshift)) ? "Over Time" : "Early";

if (isset($_REQUEST['turn-it'])) {
    $location = $conn->real_escape_string($_REQUEST['location']);
    $msg = $conn->real_escape_string($_REQUEST['msg']);
    
    $insert_query = $conn->query("INSERT INTO attendance (employee_id, department, shift, location, message, date, check_in, in_status) VALUES ('$empid', '$dept', '{$shifts['shift']}', '$location', '$msg', '$curr_date', '$time', '$intime')");
    
    if ($insert_query) {
        $checkout_status = 1;
    } else {
        echo "Error inserting attendance: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Form</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" type="text/css" href="styleemplogin.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
    <header>
        <nav>
            <h1>EMS</h1>
            <img src="logo.jpg" alt="Logo">
            <ul id="navli">
                <li><a class="homeblack" href="aloginwel.php">HOME</a></li>
                <li><a class="homeblack" href="view_employees.php">View Employee</a></li>
                <li><a class="homeblack" href="add_department.php">Department</a></li>
                <li><a class="homeblack" href="add_shift.php">Shift</a></li>
                <li><a class="homered" href="location.php">Location</a></li>
                <li><a class="homeblack" href="report.php">Report</a></li>
                <li><a class="homeblack" href="empleave.php">Employee Leave</a></li>
                <li><a class="homeblack" href="logout.php" onClick="return confirm('Are you sure you want to logout?')">Log Out</a></li>
            </ul>
        </nav>
    </header>
    <div class="divider"></div>
    <div class="page-wrapper">
        <div class="content">
            <div class="row">
                <div class="col-sm-4">
                    <h4 class="page-title">Attendance Form</h4>
                </div>
            </div>
            <div class="row">
                <?php
                $fetch_attend = $conn->query("SELECT * FROM attendance WHERE date='$curr_date' AND employee_id='$empid'");
                if (!$fetch_attend) {
                    die("Error fetching attendance: " . $conn->error);
                }
                
                if ($fetch_attend->num_rows == 0) {
                ?>
                    <div class="col-lg-8 offset-lg-2">
                        <form method="post">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Shift <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="shifts" value="<?php echo htmlspecialchars($shifts['shift']); ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Location <span class="text-danger">*</span></label>
                                        <select class="select" name="location" required>
                                            <option value="">Select</option>
                                            <?php
                                            $fetch_query = $conn->query("SELECT location FROM tbl_location");
                                            if (!$fetch_query) {
                                                die("Error fetching locations: " . $conn->error);
                                            }
                                            while ($loc = $fetch_query->fetch_assoc()) {
                                            ?>
                                                <option value="<?php echo htmlspecialchars($loc['location']); ?>"><?php echo htmlspecialchars($loc['location']); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Message</label>
                                        <textarea class="form-control" name="msg"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="m-t-20 text-center">
                                <button class="btn btn-primary submit-btn" name="turn-it"><img src="assets/img/login.png" width="40"> Turn It!</button>
                            </div>
                        </form>
                    </div>
                <?php } else {
                    $fetch_checkin = $conn->query("SELECT date FROM attendance WHERE check_out IS NULL AND employee_id='$empid'");
                    if (!$fetch_checkin) {
                        die("Error fetching check-in details: " . $conn->error);
                    }
                    $rows = $fetch_checkin->num_rows;
                    if ($rows > 0) {
                        $data = $fetch_checkin->fetch_assoc();
                        $checkdate = $data['date'];
                    }
                    if (isset($_REQUEST['check-out'])) {
                        $check_out = $time;
                        $update_query = $conn->query("UPDATE attendance SET check_out='$check_out', out_status='$outtime' WHERE employee_id='$empid' AND date='$checkdate'");
                        if ($update_query) {
                            $checkout_status = 0;
                        } else {
                            echo "Error updating checkout: " . $conn->error;
                        }
                    }
                ?>
                    <div class="col-lg-12 offset-lg-2">
                        <div class="row">
                            <div class="col-sm-6">
                                <center><h3>Thank You For Today</h3></center>
                                <form method="post">
                                    <div class="m-t-20 text-center">
                                        <?php
                                        $fetch_checkout = $conn->query("SELECT out_status FROM attendance WHERE date='$curr_date' AND employee_id='$empid'");
                                        if (!$fetch_checkout) {
                                            die("Error fetching checkout status: " . $conn->error);
                                        }
                                        $result = $fetch_checkout->fetch_assoc();
                                        $result = $result['out_status'];
                                        if (empty($result) || $checkout_status == 1) {
                                        ?>
                                            <button class="btn btn-primary submit-btn" name="check-out" onclick="return confirmDelete()"><img src="assets/img/login.png" width="40"> Check Out!</button>
                                        <?php } else { ?>
                                            <button disabled class="btn btn-primary submit-btn" name="check-out"><img src="assets/img/login.png" width="40"> Done!</button>
                                            <h5>See you tomorrow!</h5>
                                        <?php } ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php include('footer.php'); ?>
    <script language="JavaScript" type="text/javascript">
        function confirmDelete() {
            return confirm('Are you sure you want to check out now?');
        }
    </script>
</body>
</html>
