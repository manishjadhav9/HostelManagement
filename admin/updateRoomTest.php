<?php
// Database connection
$connection = new mysqli('localhost', 'root', '', 'hostelmsphp');
if ($connection->connect_error) {
    die('Connection failed: ' . $connection->connect_error);
}

// Function to test updating a room
function testUpdateRoom($roomNo, $newSeater, $newFees, $expectedResult)
{
    global $connection;

    // SQL query to update room details
    $query = "UPDATE rooms 
              SET seater = '$newSeater', fees = '$newFees' 
              WHERE room_no = '$roomNo'";

    if ($connection->query($query) === TRUE) {
        echo "Test Passed: Room updated successfully.<br>";
    } else {
        echo "Test Failed: " . $connection->error . "<br>";
    }
}

// Run the test cases
echo "<h3>Room Update Testing</h3>";
testUpdateRoom('501', 5, 5500, 'success');
testUpdateRoom('502', 4, 4500, 'success');
testUpdateRoom('503', 3, 3500, 'success');
?>
