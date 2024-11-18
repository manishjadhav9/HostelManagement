<?php
// Database connection
$connection = new mysqli('localhost', 'root', '', 'hostelmsphp');
if ($connection->connect_error) {
    die('Connection failed: ' . $connection->connect_error);
}

// Function to test deleting a room
function testDeleteRoom($roomNo, $expectedResult)
{
    global $connection;

    // SQL query to delete a room
    $query = "DELETE FROM rooms WHERE room_no = '$roomNo'";

    if ($connection->query($query) === TRUE) {
        echo "Test Passed: Room deleted successfully.<br>";
    } else {
        echo "Test Failed: " . $connection->error . "<br>";
    }
}

// Run the test cases
echo "<h3>Room Deletion Testing</h3>";
testDeleteRoom('501', 'success');
testDeleteRoom('502', 'success');
?>
