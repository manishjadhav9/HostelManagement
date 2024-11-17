<?php
use PHPUnit\Framework\TestCase;

class RoomManagementTest extends TestCase {
    private $conn;
    
    protected function setUp(): void {
        require_once __DIR__ . '/../includes/dbconn.php';
        $this->conn = $conn;
    }

    public function testAddRoom() {
        // Test adding a new room
        $seater = 2;
        $roomno = "TEST101";
        $fees = 1000;
        
        $query = "INSERT INTO rooms (seater, room_no, fees) 
                 VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('isi', $seater, $roomno, $fees);
        
        $result = $stmt->execute();
        $this->assertTrue($result);
        
        // Clean up
        $this->conn->query("DELETE FROM rooms WHERE room_no = 'TEST101'");
    }

    public function testCheckRoomAvailability() {
        // Add test room
        $this->conn->query("INSERT INTO rooms (seater, room_no, fees) 
                           VALUES (2, 'TEST102', 1000)");
        
        // Test room availability check
        $query = "SELECT * FROM rooms WHERE room_no = 'TEST102'";
        $result = $this->conn->query($query);
        
        $this->assertEquals(1, $result->num_rows);
        
        // Clean up
        $this->conn->query("DELETE FROM rooms WHERE room_no = 'TEST102'");
    }

    public function testUpdateRoom() {
        // Add test room
        $this->conn->query("INSERT INTO rooms (seater, room_no, fees) 
                           VALUES (2, 'TEST103', 1000)");
        
        // Test updating room
        $newFees = 1200;
        $query = "UPDATE rooms SET fees = ? WHERE room_no = ?";
        $stmt = $this->conn->prepare($query);
        $roomno = 'TEST103';
        $stmt->bind_param('is', $newFees, $roomno);
        
        $result = $stmt->execute();
        $this->assertTrue($result);
        
        // Verify update
        $result = $this->conn->query("SELECT fees FROM rooms WHERE room_no = 'TEST103'");
        $row = $result->fetch_assoc();
        $this->assertEquals($newFees, $row['fees']);
        
        // Clean up
        $this->conn->query("DELETE FROM rooms WHERE room_no = 'TEST103'");
    }

    protected function tearDown(): void {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}