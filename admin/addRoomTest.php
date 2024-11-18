<?php
// Database connection
$connection = new mysqli('localhost', 'root', '', 'hostelmsphp');
if ($connection->connect_error) {
    die('Connection failed: ' . $connection->connect_error);
}

// Function to test adding a room
function testAddRoom($roomNo, $seater, $fees, $expectedResult)
{
    global $connection;

    // SQL query to insert room details
    $query = "INSERT INTO rooms (room_no, seater, fees) 
              VALUES ('$roomNo', '$seater', '$fees')";

    if ($connection->query($query) === TRUE) {
        echo "Test Passed: Room added successfully.<br>";
    } else {
        echo "Test Failed: " . $connection->error . "<br>";
    }
}

// Run the test cases
echo "<h3>Room Management Testing</h3>";
testAddRoom('501', 4, 5000, 'success');
testAddRoom('502', 3, 4000, 'success');
testAddRoom('503', 2, 3000, 'success');
?>
