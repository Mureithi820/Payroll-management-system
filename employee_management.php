<?php

require_once 'dbconfig.php';

// If the submit button for add employee is clicked
if (isset($_POST['add_employee'])) {
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $email = $_POST['email'];
  $position = $_POST['position'];

  // Insert the employee information into the database
  $query = "INSERT INTO employees (first_name, last_name, email, position) VALUES ('$first_name', '$last_name', '$email', '$position')";
  mysqli_query($conn, $query);
  header("Location: login.php");
}

// If the submit button for edit employee is clicked
if (isset($_POST['edit_employee'])) {
  $employee_id = $_POST['employee_id'];
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $email = $_POST['email'];
  $position = $_POST['position'];

  // Update the employee information in the database
  $query = "UPDATE employees SET first_name='$first_name', last_name='$last_name', email='$email', position='$position' WHERE employee_id=$employee_id";
  mysqli_query($conn, $query);
  header("Location: employee_management.php");
}

// If the delete button is clicked
if (isset($_GET['delete_id'])) {
  $employee_id = $_GET['delete_id'];

  // Delete the employee information from the database
  $query = "DELETE FROM employees WHERE employee_id=$employee_id";
  mysqli_query($conn, $query);
  header("Location: employee_management.php");
}

// Get all the employee information from the database
$employees = mysqli_query($conn, "SELECT * FROM employees");
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Employee Management</title>
  <!-- CSS Stylesheet -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
   <!-- Font Awesome Icons -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="employee_management.css">
</head>

<body>
  <div class="container my-5">
    <h1 class="text-center mb-5">Employee Management</h1>
    <div class="d-flex justify-content-between mb-3">
      <a href="employee_form.php" class="btn btn-primary">Add Employee</a>
    </div>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Employee ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Position</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($employee = mysqli_fetch_array($employees)) { ?>
            <tr>
              <td><?php echo $employee['employee_id']; ?></td>
              <td><?php echo $employee['first_name']; ?></td>
              <td><?php echo $employee['last_name']; ?></td>
              <td><?php echo $employee['email']; ?></td>
              <td><?php echo $employee['position']; ?></td>
              <td>
            <a href="edit_employee.php?edit_id=<?php echo $employee['employee_id']; ?>" class="btn btn-primary btn-sm">Edit</a>
            <a href="delete_employee.php?delete_id=<?php echo $employee['employee_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<a href="download_employees.php" class="btn btn-success"><i class="fa fa-download"></i> Download</a>

<div class="mt-3">
  <a href="admin_dashboard.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back</a>
     </div>
</div>
  <!-- JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNSLZV9" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>



