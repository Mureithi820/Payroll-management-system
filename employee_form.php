<?php

session_start();

require_once 'dbconfig.php';

// Check if the form was submitted
if (isset($_POST['submit'])) {
    // Get form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    
    $position = $_POST['position'];
    $department = $_POST['department'];
    $dob = $_POST['dob'];
    $hire_date = $_POST['hire_date'];

    // Insert new employee into database
    $query = "INSERT INTO employees (first_name, last_name, gender, email, position, department, dob, hire_date) VALUES ('$first_name', '$last_name', '$gender', '$email', '$position', '$department', '$dob', '$hire_date')";

    $result = mysqli_query($conn, $query);

    if ($result) {
        $_SESSION['message'] = 'Employee added successfully!';
    } else {
        $_SESSION['message'] = 'Failed to add employee, try again.';
    }

    // Redirect to dashboard
    header('Location: admin_dashboard.php');
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet"  href="employee_form.css">
    <title>Add Employee</title>
</head>
<body>
    <div class="container my-5">
        <h1>Add Employee</h1>
        <?php if (isset($_SESSION['message'])) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $_SESSION['message']; ?>
            </div>
        <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" required>
            </div>
            <div class="form-group">
    <label for="gender">Gender</label>
    <select class="form-control" id="gender" name="gender" required>
      <option value="">Select Gender</option>
      <option value="male">Male</option>
      <option value="female">Female</option>
      <option value="other">Other</option>
    </select>
  </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email"required>
</div>

<div class="form-group">
<label for="position">Position</label>
<input type="text" class="form-control" id="position" name="position" required>
</div>
<div class="form-group">
<label for="department">Department</label>
<input type="text" class="form-control" id="department" name="department" required>
</div>
<div class="form-group">
<label for="dob">Date of Birth</label>
<input type="date" class="form-control" id="dob" name="dob" required>
</div>
<div class="form-group">
<label for="hire_date">Hire Date</label>
<input type="date" class="form-control" id="hire_date" name="hire_date" required>
</div>
<input type="submit" class="btn btn-primary" name="submit" value="Submit">
</form>
</div>

</body>
</html>