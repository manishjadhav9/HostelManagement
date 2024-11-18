<?php
// Database connection
$connection = new mysqli('localhost', 'root', '', 'hostelmsphp');
if ($connection->connect_error) {
    die('Connection failed: ' . $connection->connect_error);
}

// Function to delete user based on regNo
function deleteUser($regNo)
{
    global $connection;

    // Check if regNo is empty
    if (empty($regNo)) {
        echo "Error: Registration Number is required to delete the user.<br>";
        return;
    }

    // SQL query to delete user
    $query = "DELETE FROM userregistration WHERE regNo='$regNo'";

    if ($connection->query($query) === TRUE) {
        echo "User with Registration Number $regNo deleted successfully.<br>";
    } else {
        echo "Error deleting user: " . $connection->error . "<br>";
    }
}

$regNo = '102'; // Change this to an empty string to test the validation

deleteUser($regNo);
?>
