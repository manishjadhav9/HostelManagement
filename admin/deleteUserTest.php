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

    // SQL query to delete user
    $query = "DELETE FROM userregistration WHERE regNo='$regNo'";

    if ($connection->query($query) === TRUE) {
        echo "User with Registration Number $regNo deleted successfully.<br>";
    } else {
        echo "Error deleting user: " . $connection->error . "<br>";
    }
}

// Hardcoded test case (delete the user with regNo '101')
$regNo = '102';

// Call the delete function with the hardcoded regNo
deleteUser($regNo);
?>
