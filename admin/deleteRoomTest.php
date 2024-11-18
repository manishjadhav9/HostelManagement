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

    // Check if the roomNo is empty
    if (empty($roomNo)) {
        echo "Error: Room number is required to delete a room.<br>";
        return;
    }

    // SQL query to delete a room
    $query = "DELETE FROM rooms WHERE room_no = '$roomNo'";

    if ($connection->query($query) === TRUE) {
        // If deletion is successful, check if the expected result is 'success'
        if ($expectedResult === 'success') {
            echo "Test Passed: Room deleted successfully.<br>";
        } else {
            echo "Test Failed: Expected failure but room was deleted successfully.<br>";
        }
    } else {
        // If there is an error, check if the expected result is 'failure'
        if ($expectedResult === 'failure') {
            echo "Test Passed: Failure as expected (deletion error).<br>";
        } else {
            echo "Test Failed: Expected success but deletion failed.<br>";
        }
    }
}

// Run the test cases
echo "<h3>Room Deletion Testing</h3>";

// Valid room deletion tests
testDeleteRoom('501', 'success');
testDeleteRoom('502', 'success');

testDeleteRoom('', 'failure'); // Expected failure due to empty roomNo
?>
