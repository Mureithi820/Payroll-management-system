<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Employee List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>

<div class="container-fluid">
    <h1 class="mt-4">Employee List</h1>

    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Department</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
              require_once 'dbconfig.php';
                // Retrieve data from the database
                $sql = "SELECT * FROM employees";
                $result = mysqli_query($conn, $sql);

                // Loop through the data and display it in a table
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["department"] . "</td>";
                        echo "<td><a href='edit_employee.php?id=" . $row["id"] . "'>Edit</a> | <a href='delete_employee.php?id=" . $row["id"] . "'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No data found</td></tr>";
                }

                // Close the connection
                mysqli_close($conn);
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
