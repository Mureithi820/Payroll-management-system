<?php
session_start();

// Connect to the database
require_once 'dbconfig.php';

 // If the user is not an admin, redirect to a different page
 if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: unauthorized.php");
    exit;
}

$query = "SELECT * FROM direct_deposit";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Bank Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="mt-4 mb-4">View Bank Details</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Employee Name</th>
                            <th>Bank Name</th>
                            <th>Routing Number</th>
                            <th>Account Number</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['employee_name']; ?></td>
                                <td><?php echo $row['bank_name']; ?></td>
                                <td><?php echo $row['routing_number']; ?></td>
                                <td><?php echo $row['account_number']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
