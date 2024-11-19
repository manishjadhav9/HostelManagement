<?php
use PHPUnit\Framework\TestCase;

class AddRoomsTest extends TestCase
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
    }

    protected function tearDown(): void
    {
        // No truncation needed for stateful tests (data should persist)
        $this->mysqli->close();
    }

    public function testAddNewRoom()
    {
        $seater = 2;
        $roomno = 101;  // New room number
        $fees = 5000;

        // Prepare the insert statement
        $query = "INSERT INTO rooms (seater, room_no, fees) VALUES (?, ?, ?)";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('iii', $seater, $roomno, $fees);

        // Execute the statement and assert success
        $this->assertTrue($stmt->execute(), "Room should be added successfully.");
    }

    public function testAddExistingRoom()
    {
        // Insert a room first for testing the 'existing room' case
        $this->mysqli->query("INSERT INTO rooms (seater, room_no, fees) VALUES (2, 101, 5000)");

        // Attempt to add the same room again
        $seater = 3;
        $roomno = 101;  // Existing room number
        $fees = 6000;

        // Prepare the insert statement with existing room number
        $query = "INSERT INTO rooms (seater, room_no, fees) VALUES (?, ?, ?)";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('iii', $seater, $roomno, $fees);

        // Assert that the insert operation fails due to unique constraint violation
        $this->assertFalse($stmt->execute(), "Room with the same room number should not be added.");
        
        // Ensure the number of rows in the table is still 1 (i.e., the original room)
        $result = $this->mysqli->query("SELECT COUNT(*) AS count FROM rooms WHERE room_no = 101");
        $row = $result->fetch_assoc();
        $this->assertEquals(1, $row['count'], "The number of rooms with room_no 101 should be 1.");
    }

    public function testInvalidRoomData()
    {
        $seater = -1;  // Invalid seater number
        $roomno = 0;   // Invalid room number (room_no should be a positive integer)
        $fees = 0;     // Invalid fees (should not be 0)

        // Prepare the insert statement with invalid data
        $query = "INSERT INTO rooms (seater, room_no, fees) VALUES (?, ?, ?)";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('iii', $seater, $roomno, $fees);

        // Assert that the insert operation fails due to invalid data
        $this->assertFalse($stmt->execute(), "Room data should not be accepted.");
    }
}
