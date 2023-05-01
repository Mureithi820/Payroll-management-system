<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: user_login.php');
    exit;
}

$username = $_SESSION['username'];

// Step 1: Establish a MySQL database connection
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "payroll";

// Create connection
$conn = mysqli_connect($servername, $username_db, $password_db, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Step 2: Retrieve user's profile picture from the users table
$sql = "SELECT profile_picture FROM users WHERE username='$username'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $profile_picture = $row['profile_picture'];
} else {
    $profile_picture = "";
}
// Count the number of employees in the database
$sql = "SELECT COUNT(*) as total_employees FROM employees";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$total_employees = $row['total_employees'];
// Count the number of users in the database
$sql = "SELECT COUNT(*) as total_users FROM users";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$total_users = $row['total_users'];
// Calculate the total payroll
$sql = "SELECT SUM(net_pay) as total_payroll FROM payroll";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$total_payroll = $row['total_payroll'];

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- <link rel="stylesheet" type="text/css" href="admin_dashboard.css"> -->

    <style>
        /* Add custom styles here */
        .profile-picture {
            width: 75px;
            height: 75px;
        }
        #wrapper {
    display: flex;
  }

  .sidebar-wrapper {
    flex: 0 0 200px; /* Set the width of the sidebar */
  }

  .page-content-wrapper {
    flex: 1; /* Take up remaining space */
    padding-left: 20px; /* Add some spacing between the sidebar and page content */
  }
     
    </style>
</head>
<body>
<div class="container-fluid bg-primary py-1">
    <div class="row">
        <div class="col-md-9">
            <h1 class="text-white pl-4">Bleach Pay</h1>
        </div>
        <div class="col-md-3">
            <div class="d-flex justify-content-end align-items-center">
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" id="profileDropdown" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img src="<?php echo $profile_picture; ?>" alt="Profile Picture" class="rounded-circle mr-2" style="width: 75px; height: 75px;">

                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
                        <a class="dropdown-item" href="admin_profile.php">My Profile</a>
                        <a class="dropdown-item" href="employee_bank_details.php">Bank Details</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="wrapper">
<div class="sidebar-wrapper">
           <!-- Sidebar -->
           <div class="bg-light border-right" id="sidebar-wrapper">
        <div class="sidebar-heading text-center py-2">Admin Dashboard</div>
        <div class="list-group list-group-flush">
            <a href="dashboard.php" class="list-group-item list-group-item-action bg-light">Dashboard</a>
            <a href="employee_management.php" class="list-group-item list-group-item-action bg-light">Employee Management</a>
            <a href="user management.php" class="list-group-item list-group-item-action bg-light">User Management</a>
            <a href="payroll_admin_dashboard.php" class="list-group-item list-group-item-action bg-light">Payroll Management</a>
            <a href="view_attendance_records.php" class="list-group-item list-group-item-action bg-light">Time and Attendance Tracking</a>
            <a href="leave_types.php" class="list-group-item list-group-item-action bg-light">Leave Policies</a>
            <a href="logins.php" class="list-group-item list-group-item-action bg-light">Logins</a>
            <a href="admin_profile.php" class="list-group-item list-group-item-action bg-light">Admin Profile</a>
            <a href="admin_view_bank_details.php" class="list-group-item list-group-item-action bg-light">Bank Details</a>
        </div>
    </div>
</div>
    <!-- Page Content -->
    <div class="page-content-wrapper">
        
            <h1 class="mb-4">Admin Dashboard</h1>
            <p>Welcome to the admin dashboard! Here you can manage your employees, track time and attendance, set leave policies, manage payroll, and more.</p>
            <div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Employees</h5>
                    <p class="card-text"><?php echo $total_employees; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text"><?php echo $total_users; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Payroll</h5>
                    <p class="card-text"><?php echo $total_payroll; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

    </div>
</div>
<!-- /#page-content-wrapper -->
</div>
<!-- /#wrapper -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>
</body>
</html>