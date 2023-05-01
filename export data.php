<?php
// Export Data to CSV or Excel

// Connect to the database
include_once 'dbconfig.php';

// Check if the export button is clicked
if (isset($_POST['export'])) {
    // Get the data from the database
    $query = "SELECT * FROM employees";
    $result = mysqli_query($conn, $query);

    // Check if there is any data in the database
    if (mysqli_num_rows($result) > 0) {
        // Define the column headers
        $column_headers = array('ID', 'First Name', 'Last Name', 'Position', 'Salary', 'Hire Date');

        // Define the file name
        $file_name = 'employee_data_' . date('Y-m-d') . '.csv';

        // Open the file for writing
        $file = fopen('php://output', 'w');

        // Add the column headers to the file
        fputcsv($file, $column_headers);

        // Loop through the data and write it to the file
        while ($row = mysqli_fetch_assoc($result)) {
            fputcsv($file, $row);
        }

        // Close the file
        fclose($file);

        // Set the header to download the file
        header("Content-Type: application/csv");
        header("Content-Disposition: attachment; filename=$file_name");

        // Export the data
        readfile($file);
        exit;
    } else {
        echo "No data found in the database.";
    }
}

// Close the database connection
mysqli_close($conn);
?>
<!-- Export Data Form -->
<form action="export data.php" method="post">
    <input type="submit" name="export" value="Export Data" class="btn btn-primary">
</form>
