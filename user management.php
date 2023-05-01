<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>User Management</title>
  <!-- CSS Stylesheet -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
   <!-- Font Awesome Icons -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="user_management.css">
</head>
<body>


<h1 class="text-center">User Management</h1>
  <!-- User Table -->
  <div class="container mt-5">
    <table class="table">
      <thead class="thead-light">
        <tr>
          <th scope="col">User ID</th>
          <th scope="col">Username</th>
          <th scope="col">Email</th>
          <th scope="col">Role</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        require_once 'dbconfig.php';

        $sql = "SELECT user_id, username, email, role FROM users";
        $result = $conn->query($sql);
        
        if ($result === false) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        } else {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><th scope='row'>" . $row["user_id"] . "</th><td>" . $row["username"] . "</td><td>" . $row["email"] . "</td><td>" . $row["role"] . "</td><td><a href='edit_user.php?id=". $row["user_id"] . "' class='btn btn-primary mr-2'>Edit</a><a href='delete_user.php?id=". $row["user_id"] . "' class='btn btn-danger'>Delete</a></td></tr>";
                }
            } else {
                echo "0 results";
            }
        }
        
        $conn->close();
          ?>
          </table>
          <a href="download_users.php" class="btn btn-success"><i class="fa fa-download"></i> Download</a>

          <div class="container mt-5">
  <div class="mt-3">
  <a href="admin_dashboard.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back</a> 
  <a href="add_user.php" class="btn btn-primary"><i class="fa fa-plus"></i> Add User</a>
    
  </div>

       
           
            <!-- JavaScript Libraries -->
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
          </body>
          </html>
          
          
          
