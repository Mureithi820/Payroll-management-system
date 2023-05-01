<?php
session_start();

//Check if the user is logged in
if (!isset($_SESSION['username'])) {
  header("Location: user_login.php");
  exit();
}

include 'dbconfig.php';

//Select the data from the users table
$sql_users = "SELECT * FROM users WHERE username = '{$_SESSION['username']}'";
$result_users = mysqli_query($conn, $sql_users);

if (!$result_users) {
  die("Query failed: " . mysqli_error($conn));
}

$user = mysqli_fetch_assoc($result_users);

//Select the data from the employees table
$sql_employees = "SELECT first_name, last_name FROM employees WHERE username = '{$_SESSION['username']}'";
$result_employees = mysqli_query($conn, $sql_employees);

if (!$result_employees) {
  die("Query failed: " . mysqli_error($conn));
}

$employee = mysqli_fetch_assoc($result_employees);

//Set full name to "Admin" if session username is "admin"
if($_SESSION['username'] == 'admin') {
  $employee['full_name'] = 'Admin';
} else {
  $employee['full_name'] = $employee['first_name'] . ' ' . $employee['last_name'];
}

//Handle form submission
if (isset($_POST['update'])) {
  $about_me = mysqli_real_escape_string($conn, $_POST['about_me']);
  $skills = mysqli_real_escape_string($conn, $_POST['skills']);

  // Handle profile picture upload
  if(isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES['profile_picture']['name']);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');

    if(in_array($imageFileType, $allowedTypes)) {
      if(move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
        $profile_picture = mysqli_real_escape_string($conn, $target_file);
      } else {
        die("Error uploading profile picture.");
      }
    } else {
      die("Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.");
    }
  } else {
    $profile_picture = mysqli_real_escape_string($conn, $user['profile_picture']);
  }

  $sql_update_users = "UPDATE users SET about_me = '$about_me', skills = '$skills', profile_picture = '$profile_picture' WHERE username = '{$_SESSION['username']}'";
  $result_update_users = mysqli_query($conn, $sql_update_users);

  if (!$result_update_users) {
    die("Query failed: " . mysqli_error($conn));
  }

  header("Location: profile.php");
  exit();
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Edit Profile</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
  <header>
    <div class="container">
      <h1 class="text-center mt-5">Edit Profile</h1>
      <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <form action="edit_profile.php" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="full_name">Full Name</label>
            <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo $employee['full_name'] ?>" readonly>
          </div>
          <div class="form-group">
            <label for="about_me">About Me</label>
            <textarea class="form-control" id="about_me" name="about_me"><?php echo $user['about_me'] ?></textarea>
          </div>
          <div class="form-group">
            <label for="skills">Skills</label>
            <textarea class="form-control" id="skills" name="skills"><?php echo $user['skills'] ?></textarea>
          </div>
          <div class="form-group">
            <label for="profile_picture">Profile Picture</label>
            <input type="file" class="form-control-file" id="profile_picture" name="profile_picture">
          </div>
          <button type="submit" class="btn btn-primary" name="update">Update</button>
        </form>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
