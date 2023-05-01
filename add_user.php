<?php
// PHP code
session_start();
require_once "dbconfig.php";

if (isset($_POST['submit'])) {
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
  $email = $_POST['email'];
  $role = $_POST['role'];
  $id = $_POST['employee_id'];

  mysqli_begin_transaction($conn);

  $query = "INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, "ssss", $username, $password, $email, $role);
  mysqli_stmt_execute($stmt);

  $query_select_employee = "SELECT * FROM employees WHERE employee_id = ?";
  $stmt_select_employee = mysqli_prepare($conn, $query_select_employee);
  mysqli_stmt_bind_param($stmt_select_employee, "i", $id);
  mysqli_stmt_execute($stmt_select_employee);
  $result_select_employee = mysqli_stmt_get_result($stmt_select_employee);
  $num_rows = mysqli_num_rows($result_select_employee);
  mysqli_free_result($result_select_employee);

  if ($num_rows > 0) {
    $query_update_employee = "UPDATE employees SET username = ? WHERE employee_id = ?";
    $stmt_update_employee = mysqli_prepare($conn, $query_update_employee);
    mysqli_stmt_bind_param($stmt_update_employee, "si", $username, $id);
    mysqli_stmt_execute($stmt_update_employee);
  }

  $query_admin_login = "INSERT INTO admin_login (username, password) VALUES (?, ?)";
  $stmt_admin_login = mysqli_prepare($conn, $query_admin_login);
  mysqli_stmt_bind_param($stmt_admin_login, "ss", $username, $password);
  mysqli_stmt_execute($stmt_admin_login);

  if (mysqli_stmt_affected_rows($stmt) > 0 && mysqli_stmt_affected_rows($stmt_admin_login) > 0 && ($num_rows == 0 || mysqli_stmt_affected_rows($stmt_update_employee) > 0)) {
    mysqli_commit($conn);
    $_SESSION['message'] = "User added successfully.";
    header("Location: admin_dashboard.php");
    exit;
  } else {
    mysqli_rollback($conn);
    $_SESSION['message'] = "Error adding user: " . mysqli_error($conn);
    header("Location: add_user.php");
    exit;
  }
  mysqli_stmt_close($stmt);
  mysqli_stmt_close($stmt_admin_login);
  mysqli_stmt_close($stmt_select_employee);
  mysqli_stmt_close($stmt_update_employee);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add User</title>
 <!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <h1 class="text-center">Add User</h1>
        <?php if (isset($_SESSION['message'])) : ?>
          <div class="alert alert-<?=$_SESSION['type']?>">
          <?= $_SESSION['message']?>
        </div>
        <?php unset($_SESSION['message']); unset($_SESSION['type']); endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
          <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" required>
          </div>
          <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <div class="form-group">
            <label for="role">Role:</label>
            <select class="form-control" id="role" name="role" required>
              <option value="">Select Role</option>
              <option value="admin">Admin</option>
              <option value="employee">Employee</option>
            </select>
          </div>
          <div class="form-group">
            <label for="employee_id">Employee ID:</label>
            <input type="number" class="form-control" id="employee_id" name="employee_id" required>
          </div>
          <button type="submit" class="btn btn-primary" name="submit">Add User</button>
        </form>
      </div>
    </div>
    <div class="mt-3">
  <a href="user management.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back</a>
</div>

  </div>

  <!-- JavaScript -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2.all.min.js"></script>
</body>
</html>
