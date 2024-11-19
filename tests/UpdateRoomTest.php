<?php
use PHPUnit\Framework\TestCase;

class UpdateRoomTest extends TestCase
{
    private $mysqli;

    protected function setUp(): void
    {
        // Establish database connection
        $this->mysqli = new mysqli('localhost', 'root', '', 'hostelmsphp');

        // Create the rooms table if it doesn't already exist
        $this->mysqli->query("CREATE TABLE IF NOT EXISTS rooms (
            id INT AUTO_INCREMENT PRIMARY KEY,
            seater INT NOT NULL,
            room_no INT NOT NULL UNIQUE,
            fees INT NOT NULL
        )");

        // Insert a default room for use in tests
        $seater = 2;
        $roomno = 504;
        $fees = 10000;
        $query = "INSERT INTO rooms (seater, room_no, fees) VALUES (?, ?, ?)";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('iii', $seater, $roomno, $fees);
        $stmt->execute();
    }

    protected function tearDown(): void
    {
        // Do not truncate or delete any rows; we want the data to persist for other tests
        $this->mysqli->close();
    }

    // Test: Updating room details with valid data
    public function testUpdateRoom()
    {
        $roomno = 504;  // Room to be updated
        $newFees = 15000;

        // Update room details
        $updateQuery = "UPDATE rooms SET fees = ? WHERE room_no = ?";
        $updateStmt = $this->mysqli->prepare($updateQuery);
        $updateStmt->bind_param('ii', $newFees, $roomno);

        // Assert that the room is updated successfully
        $this->assertTrue($updateStmt->execute(), "Room fees should be updated successfully.");
        
        // Verify the update was successful
        $result = $this->mysqli->query("SELECT fees FROM rooms WHERE room_no = $roomno");
        $row = $result->fetch_assoc();
        $this->assertEquals($newFees, $row['fees'], "Room fees should be updated in the database.");
    }

    // Test: Attempting to update a non-existent room
    public function testUpdateNonExistentRoom()
    {
        $roomNo = 999;  // Non-existent room number
        $newFees = 7000;

        $updateQuery = "UPDATE rooms SET fees = ? WHERE room_no = ?";
        $updateStmt = $this->mysqli->prepare($updateQuery);
        $updateStmt->bind_param('ii', $newFees, $roomNo);

        // Assert that the update fails for non-existent room
        $this->assertFalse($updateStmt->execute(), "The room update should fail for non-existent room.");
    }

    // Test: Updating with invalid data (e.g., negative fees)
    public function testUpdateRoomWithInvalidData()
    {
        $roomNo = 101;
        $newFees = -5000;  // Invalid fees (negative)

        $updateQuery = "UPDATE rooms SET fees = ? WHERE room_no = ?";
        $updateStmt = $this->mysqli->prepare($updateQuery);
        $updateStmt->bind_param('ii', $newFees, $roomNo);

        // Assert that the room update fails with invalid data
        $this->assertFalse($updateStmt->execute(), "The room update should fail with invalid data.");
        
        // Verify the update did not change the room's fees
        $result = $this->mysqli->query("SELECT fees FROM rooms WHERE room_no = $roomNo");
        $row = $result->fetch_assoc();
        $this->assertEquals(5000, $row['fees'], "The room fees should remain unchanged.");
    }


}
