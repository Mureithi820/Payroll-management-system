<?php 
  session_start();
  if(!isset($_SESSION['username'])){
    header("Location: login.php");
  }

  require_once 'dbconfig.php';
  
  $username = $_SESSION['username'];
  $query = "SELECT role FROM users WHERE username='$username'";
  $result = mysqli_query($conn, $query);
  $user = mysqli_fetch_assoc($result);
  $role = $user['role'];

  if ($role != 'admin') {
    echo "Unauthorized Access";
    exit();
  }

  $employees_query = "SELECT * FROM employees";
  $employees_result = mysqli_query($conn, $employees_query);
  require_once 'dbconfig.php';

//   if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
//   }
//   echo "Connected successfully";
?>


<!DOCTYPE html>
<html>
<head>
  <title>Employees</title>
  <!-- Include bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <!-- Custom CSS -->
  <link rel="stylesheet" type="text/css" href="employees.css">
</head>
<body>
  <div class="container">
    <h1>List of Employees</h1>
    <p>You are logged in as <?php echo $username; ?></p>
    <a href="admin_dashboard.php" class="btn btn-primary">Back to Dashboard</a>
   
    <hr>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Position</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($employee = mysqli_fetch_assoc($employees_result)) { ?>
          <tr>
            <td><?php echo $employee['first_name']; ?></td>
            <td><?php echo $employee['email']; ?></td>
            <td><?php echo $employee['position']; ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</body>
</html>
