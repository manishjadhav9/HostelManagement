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

    // Check if any required field is empty
    if (empty($roomNo) || empty($newSeater) || empty($newFees)) {
        echo "Error: All fields (roomNo, newSeater, newFees) are required to update the room.<br>";
        return;
    }

    // SQL query to update room details
    $query = "UPDATE rooms 
              SET seater = '$newSeater', fees = '$newFees' 
              WHERE room_no = '$roomNo'";

    if ($connection->query($query) === TRUE) {
        // If update is successful, check if the expected result is 'success'
        if ($expectedResult === 'success') {
            echo "Test Passed: Room updated successfully.<br>";
        } else {
            echo "Test Failed: Expected failure but room was updated successfully.<br>";
        }
    } else {
        // If there is an error, check if the expected result is 'failure'
        if ($expectedResult === 'failure') {
            echo "Test Passed: Failure as expected (update error).<br>";
        } else {
            echo "Test Failed: Expected success but update failed.<br>";
        }
    }
}

// Run the test cases
echo "<h3>Room Update Testing</h3>";

// Valid room update tests
testUpdateRoom('501', 5, 5500, 'success');
testUpdateRoom('502', 4, 4500, 'success');
testUpdateRoom('503', 3, 3500, 'success');

testUpdateRoom('', 4, 4500, 'failure'); // Expected failure due to empty roomNo
testUpdateRoom('504', '', 3500, 'failure'); // Expected failure due to empty seater
testUpdateRoom('505', 4, '', 'failure'); // Expected failure due to empty fees
?>
