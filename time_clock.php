<?php
session_start();

//Check if the user is logged in
if (!isset($_SESSION['username'])) {
  header("Location: user_login.php");
  exit();
}

include 'dbconfig.php';

//Handle form submission
if (isset($_POST['clock_in'])) {
  //Insert a new clock-in record into the database
  $sql_clock_in = "INSERT INTO time_clock (username, clock_in) VALUES ('{$_SESSION['username']}', NOW())";
  $result_clock_in = mysqli_query($conn, $sql_clock_in);

  if (!$result_clock_in) {
    die("Query failed: " . mysqli_error($conn));
  }

  header("Location: time_clock.php");
  exit();
}

if (isset($_POST['clock_out'])) {
  //Get the latest clock-in record for the current user
  $sql_get_clock_in = "SELECT * FROM time_clock WHERE username = '{$_SESSION['username']}' ORDER BY clock_in DESC LIMIT 1";
  $result_get_clock_in = mysqli_query($conn, $sql_get_clock_in);

  if (!$result_get_clock_in) {
    die("Query failed: " . mysqli_error($conn));
  }

  $clock_in_record = mysqli_fetch_assoc($result_get_clock_in);

  //Update the clock-out time for the clock-in record
  $sql_clock_out = "UPDATE time_clock SET clock_out = NOW() WHERE id = {$clock_in_record['id']}";
  $result_clock_out = mysqli_query($conn, $sql_clock_out);

  if (!$result_clock_out) {
    die("Query failed: " . mysqli_error($conn));
  }

  header("Location: time_clock.php");
  exit();
}

//Get the clock-in and clock-out records for the current user
$sql_get_records = "SELECT * FROM time_clock WHERE username = '{$_SESSION['username']}' ORDER BY clock_in DESC";
$result_get_records = mysqli_query($conn, $sql_get_records);

if (!$result_get_records) {
  die("Query failed: " . mysqli_error($conn));
}

$records = mysqli_fetch_all($result_get_records, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Time Clock</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
  <style>
  .clock-in-out-form {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
  }
  </style>
</head>
<body>
  <div class="container">
    <h1 class="text-center my-5">Time Clock</h1>
    <div class="clock-in-out-form">
      <form action="time_clock.php" method="post">
        <input type="submit" name="clock_in" value="Clock In" class="btn btn-primary mr-2">
        <input type="submit" name="clock_out" value="Clock Out" class="btn btn-danger">
      </form>
    </div>
    <h2 class="text-center my-5">Time Clock Records</h2>
    <table class="table">
      <thead>
        <tr>
          <th>Clock In</th>
          <th>Clock Out</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($records as $record) : ?>
          <tr>
            <td><?php echo $record['clock_in']; ?></td>
            <td><?php echo $record['clock_out']; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
