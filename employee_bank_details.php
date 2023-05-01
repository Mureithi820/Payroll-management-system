<?php
session_start();

// Connect to the database
require_once 'dbconfig.php';

// If the user is not an employee, redirect to a different page
if (!isset($_SESSION['username'])) {
    header("Location: unauthorized.php");
    exit;
}

if (isset($_POST['submit'])) {
    $bank_name = mysqli_real_escape_string($conn, $_POST['bank_name']);
    $routing_number = mysqli_real_escape_string($conn, $_POST['routing_number']);
    $account_number = mysqli_real_escape_string($conn, $_POST['account_number']);
    $employee_id = $_SESSION['user_id'];

    $query = "INSERT INTO direct_deposit (employee_id, bank_name, routing_number, account_number) VALUES ('$employee_id', '$bank_name', '$routing_number', '$account_number')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header("Location: success.php");
        exit;
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enter Bank Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="mt-4 mb-4">Enter Bank Details</h2>
                <form method="post">
                    <div class="form-group">
                        <label for="bank_name">Bank Name</label>
                        <input type="text" class="form-control" id="bank_name" name="bank_name" required>
                    </div>
                    <div class="form-group">
                        <label for="routing_number">Routing Number</label>
                        <input type="text" class="form-control" id="routing_number" name="routing_number" required>
                    </div>
                    <div class="form-group">
                        <label for="account_number">Account Number</label>
                        <input type="text" class="form-control" id="account_number" name="account_number" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
