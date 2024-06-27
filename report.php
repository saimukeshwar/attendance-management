<?php
// Start session
session_start();

// Define database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db";

// Create connection
$connection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>
<head>
    <title>Admin Panel | Employee Management System</title>
    <link rel="stylesheet" type="text/css" href="styleemplogin.css">
   </head>
<header>
        <nav>
            <h1>EMS</h1>
            <img src="logo.jpg" alt="">
            <ul id="navli">
                <li><a class="homeblack" href="aloginwel.php">HOME</a></li>
                <li><a class="homeblack" href="view_employees.php">View Employee</a></li>
                <li><a class="homeblack" href="add_department.php">Department</a></li>
                <li><a class="homeblack" href="add_shift.php">Shift</a></li>
                <li><a class="homeblack" href="location.php">Location</a></li>
                <li><a class="homered" href="report.php">Report</a></li>
                <li><a class="homeblack" href="empleave.php">Employee Leave</a></li>
                <li><a class="homeblack" href="logout.php" onClick="return confirm('Are you sure you want to logout?')">Log Out</a></li>
            </ul>
        </nav>
    </header>
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-sm-4 col-3">
                <h4 class="page-title">Report</h4>
            </div>
        </div>

        <form method="post">
            <div class="form-group row" style="padding: 20px;">
                <label class="col-lg-0 col-form-label-report" for="from">From</label>
                <div class="col-lg-3">
                    <input type="text" class="form-control" id="datetimepicker5" name="from_date" placeholder="Select Date" required>
                </div>

                <label class="col-lg-0 col-form-label" for="to">To</label>
                <div class="col-lg-3">
                    <input type="text" class="form-control" id="datetimepicker6" name="to_date" placeholder="Select Date" required>
                </div>

                <div class="col-lg-3">
                    <select class="form-control" id="department" name="department" required>
                        <option value="">Select Department</option>
                        <?php 
                        $fetch_department = mysqli_query($connection, "SELECT * FROM departments");
                        while($row = mysqli_fetch_array($fetch_department)){
                        ?>
                        <option value="<?php echo $row['name']; ?>"><?php echo $row['id']; ?> - <?php echo $row['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-2">
                    <button type="submit" name="srh-btn" class="btn btn-primary search-button">Search</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="datatable table table-stripped ">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Date</th>
                        <th>Shift</th>
                        <th>Check In</th>
                        <th>Notes</th>
                        <th>In Status</th>
                        <th>Check Out</th>
                        <th>Out Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($_REQUEST['srh-btn'])) {
                        $from_date = $_POST['from_date']; 
                        $to_date = $_POST['to_date'];
                        $dept = $_POST['department'];
                        $from_date = date('Y-m-d', strtotime($from_date));
                        $to_date = date('Y-m-d', strtotime($to_date));

                        $search_query = mysqli_query($connection, 
                            "SELECT employees.firstname, employees.lastname, employees.department, attendance.date, attendance.shift, attendance.check_in, attendance.message, attendance.in_status, attendance.check_out, attendance.out_status 
                            FROM employees 
                            INNER JOIN attendance ON attendance.employees_id=employees.id 
                            WHERE attendance.department='$dept' AND DATE(attendance.date) BETWEEN '$from_date' AND '$to_date'");

                        while ($row = mysqli_fetch_array($search_query)) {
                    ?>
                    <tr>
                        <td><?php echo $row['firstname']." ".$row['lastname']; ?></td>
                        <td><?php echo $row['department']; ?></td>
                        <td><?php echo $row['date']; ?></td>
                        <td><?php echo $row['shift']; ?></td>
                        <td><?php echo $row['check_in']; ?></td>
                        <td><?php echo $row['message']; ?></td>
                        <td><?php echo $row['in_status']; ?></td>
                        <td><?php echo $row['check_out']; ?></td>
                        <td><?php echo $row['out_status']; ?></td>
                    </tr>
                    <?php } } else {
                        $fetch_query = mysqli_query($connection, 
                            "SELECT employees.firstname, employees.lastname, employees.department, attendance.date, attendance.shift, attendance.check_in, attendance.message, attendance.in_status, attendance.check_out, attendance.out_status 
                            FROM employees 
                            INNER JOIN attendance ON attendance.employees_id=employees.id");

                        while ($row = mysqli_fetch_array($fetch_query)) {
                    ?>
                    <tr>
                        <td><?php echo $row['firstname']." ".$row['lastname']; ?></td>
                        <td><?php echo $row['department']; ?></td>
                        <td><?php echo $row['date']; ?></td>
                        <td><?php echo $row['shift']; ?></td>
                        <td><?php echo $row['check_in']; ?></td>
                        <td><?php echo $row['message']; ?></td>
                        <td><?php echo $row['in_status']; ?></td>
                        <td><?php echo $row['check_out']; ?></td>
                        <td><?php echo $row['out_status']; ?></td>
                    </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
<script language="JavaScript" type="text/javascript">
function confirmDelete(){
    return confirm('Are you sure want to delete this Employee?');
}
</script>
