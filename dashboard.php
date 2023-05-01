<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: user_login.php');
    exit;
}

$username = $_SESSION['username'];

// Connect to the database
require_once 'dbconfig.php';

// Retrieve user's profile picture from the users table
$sql = "SELECT profile_picture FROM users WHERE username='$username'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $profile_picture = $row['profile_picture'];
} else {
    $profile_picture = "";
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Bleach Pay</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
        crossorigin="anonymous">
       <style>
         /* Add custom styles here */
         .profile-picture {
            width: 75px;
            height: 75px;
        }
       </style>
</head>
<body>
<div class="container-fluid bg-primary py-3">
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
                        <a class="dropdown-item" href="profile.php">My Profile</a>
                        <a class="dropdown-item" href="employee_bank_details.php">Bank Details</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="container mt-5">
        <h1 class="text-center text-primary">Welcome to the Dashboard</h1>
        <p class="text-center">You are logged in as <?php echo $username; ?></p>
        
        <div class="row mt-5">
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Time and Attendance Tracking</h5>
                        <p class="card-text">Track your work hours and attendance using our reliable and accurate system.</p>
                        <a href="time_and_attendance_tracking.php" class="btn btn-primary">Go to Time and Attendance</a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Payroll Information</h5>
                        <p class="card-text">View your salary, benefits, and other payroll-related information here.</p>
                        <a href="employee_payroll.php" class="btn btn-primary">Go to Payroll Information</a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Time Off Requests</h5>
                        <p class="card-text">Request time off and manage your vacation days with ease.</p>
                        <a href="leave_days.php" class="btn btn-primary">Go to Time Off Requests</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"></script>
    </body>
</html>