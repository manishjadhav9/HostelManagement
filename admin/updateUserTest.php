<?php
// Database connection
$connection = new mysqli('localhost', 'root', '', 'hostelmsphp');
if ($connection->connect_error) {
    die('Connection failed: ' . $connection->connect_error);
}

// Function to update user details with hardcoded values
function updateUser($regNo, $newFirstName, $newMiddleName, $newLastName, $newEmail)
{
    global $connection;

    // SQL query to update user details, including middle name
    $query = "UPDATE userregistration 
              SET firstName='$newFirstName', middleName='$newMiddleName', lastName='$newLastName', email='$newEmail' 
              WHERE regNo='$regNo'";

    if ($connection->query($query) === TRUE) {
        echo "User updated successfully.<br>";
    } else {
        echo "Error updating user: " . $connection->error . "<br>";
    }
}

$regNo = '101';
$newFirstName = 'Adwait';
$newMiddleName = 'Shrikant';
$newLastName = 'Shesh';
$newEmail = 'adwait.shesh@gmail.com';

// Call the update function with hardcoded values
updateUser($regNo, $newFirstName, $newMiddleName, $newLastName, $newEmail);
?>