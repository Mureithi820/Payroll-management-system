<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <title>Employee Search</title>
</head>
<body>
  <!-- Search Form -->
  <form class="form-inline my-2 my-lg-0" action="search.php" method="get">
    <input class="form-control mr-sm-2" type="text" name="search_term" placeholder="Search for employees...">
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="search">Search</button>
  </form>

  <div class="container mt-5">
    <?php
        // Connect to the database
        require_once "dbconfig.php";

        // Check if the search form has been submitted
        if(isset($_GET['search'])) {
            // Get the search term
            $search_term = mysqli_real_escape_string($conn, $_GET['search_term']);

            // Query the database for any matching results
            $sql = "SELECT * FROM employees WHERE first_name LIKE '%$search_term%' OR last_name LIKE '%$search_term%' OR email LIKE '%$search_term%' OR position LIKE '%$sear_term%'";
            $result = mysqli_query($conn, $sql);

            // If there are no matching results, display an error message
            if(mysqli_num_rows($result) == 0) {
                echo "<p class='text-danger'>No results found for '$search_term'.</p>";
            }
            else {
                // Display the matching results
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<p><b>Name:</b> " . $row['first_name'] . " " . $row['last_name'] . "</p>";
                    echo "<p><b>Email:</b> " . $row['email'] . "</p>";
                    echo "<p><b>Position:</b> " . $row['position'] . "</p>";
                    echo "<br><br>";
                }
            }
        }
    ?>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap
