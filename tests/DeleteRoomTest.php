<?php
use PHPUnit\Framework\TestCase;

class DeleteRoomTest extends TestCase
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

        // Insert a default room for testing
        $seater = 5;
        $roomno = 103;
        $fees = 9000;
        $query = "INSERT INTO rooms (seater, room_no, fees) VALUES (?, ?, ?)";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('iii', $seater, $roomno, $fees);
        $stmt->execute();
    }

    protected function tearDown(): void
    {
        // Do not truncate or delete rows; we want data to persist for other tests
        $this->mysqli->close();
    }

    // Test: Deleting an existing room
    public function testDeleteRoom()
    {
        $roomno = 101;  // Room to be deleted

        // Delete the room
        $deleteQuery = "DELETE FROM rooms WHERE room_no = ?";
        $deleteStmt = $this->mysqli->prepare($deleteQuery);
        $deleteStmt->bind_param('i', $roomno);

        // Assert that the room is deleted successfully
        $this->assertTrue($deleteStmt->execute(), "Room should be deleted successfully.");

        // Verify that the room was deleted
        $result = $this->mysqli->query("SELECT * FROM rooms WHERE room_no = $roomno");
        $this->assertNull($result->fetch_assoc(), "Room should no longer exist in the database.");
    }

    // Test: Deleting a non-existent room
    public function testDeleteNonExistentRoom()
    {
        $roomNo = 999;  // Non-existent room number

        // Attempt to delete a non-existent room
        $deleteQuery = "DELETE FROM rooms WHERE room_no = ?";
        $deleteStmt = $this->mysqli->prepare($deleteQuery);
        $deleteStmt->bind_param('i', $roomNo);

        // Assert that the deletion fails for non-existent room
        $this->assertFalse($deleteStmt->execute(), "The room deletion should fail for non-existent room.");
    }

    // Test: Deleting a room with invalid data (e.g., invalid room number format)
    public function testDeleteRoomWithInvalidData()
    {
        $roomNo = 'invalid';  // Invalid room number format (string)

        // Attempt to delete with invalid data
        $deleteQuery = "DELETE FROM rooms WHERE room_no = ?";
        $deleteStmt = $this->mysqli->prepare($deleteQuery);
        
        // We can't bind a string to an integer, so the test should fail at this point
        $this->expectException(mysqli_sql_exception::class);

        $deleteStmt->bind_param('i', $roomNo); // Attempt to bind invalid data (string) to an integer field
        $deleteStmt->execute();
    }
}
?>
