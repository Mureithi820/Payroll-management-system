<?php
    // Connect to the database
    require_once 'dbconfig.php';

    // If the user is not an admin, redirect to a different page
    session_start();
    if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
        header("Location: unauthorized.php");
        exit;
    }

    // Get the ID of the login record to delete from the URL query string
    $id = $_GET['id'];

    // Query to delete the login record with the specified ID
    $query = "DELETE FROM logins WHERE id = $id";
    $result = mysqli_query($conn, $query);

    // If the query was successful, redirect back to the login log page
    if ($result) {
        header("Location: logins.php");
        exit;
    } else {
        echo "Error deleting login record: " . mysqli_error($conn);
    }
?>
