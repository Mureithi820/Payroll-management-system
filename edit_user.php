<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
 <!-- Font Awesome Icons -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="profile.css">
        </head>
<body>

<?php
// Connect to the database
require_once 'dbconfig.php';

if (isset($_GET["id"])) {
    $user_id = $_GET["id"];

    if (isset($_POST["submit"])) {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $role = $_POST["role"];

        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, role = ? WHERE user_id = ?");
        $stmt->bind_param("sssi", $username, $email, $role, $user_id);
        if ($stmt->execute() === true) {
            echo '<div class="alert alert-success" role="alert">User updated successfully.</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Error updating user: ' . $conn->error . '</div>';
        }
    }        
    $sql = "SELECT * FROM users WHERE user_id = $user_id";
    $result = $conn->query($sql);

    if ($result === false) {
        echo '<div class="alert alert-danger" role="alert">Error: ' . $sql . '<br>' . $conn->error . '</div>';
    } else {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $username = $row["username"];
            $email = $row["email"];
            $role = $row["role"];
        } else {
            echo '<div class="alert alert-danger" role="alert">User not found.</div>';
        }
    }
}

$conn->close();
?>

<div class="container mt-5">
    <h1>Edit User</h1>
    <form method="post">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" value="<?php echo $email; ?>">
        </div>
        <div class="form-group">
            <label for="role">Role:</label>
            <select class="form-control" name="role">
                <option value="admin" <?php if ($role == "admin") echo "selected"; ?>>Admin</option>
                <option value="employee" <?php if ($role == "employee") echo "selected"; ?>>Employee</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" name="submit">Save Changes</button>
    </form>
</div>
<div class="mt-3">
  <a href="user management.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back</a>
     </div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7ab