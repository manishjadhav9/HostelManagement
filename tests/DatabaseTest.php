<?php
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase {
    private $conn;
    
    protected function setUp(): void {
        require_once __DIR__ . '/../includes/dbconn.php';
        $this->conn = $conn;
    }

    public function testDatabaseConnection() {
        $this->assertNotNull($this->conn);
        $this->assertTrue($this->conn instanceof mysqli);
    }

    public function testDatabaseSelection() {
        $result = mysqli_select_db($this->conn, 'hostelmsphp');
        $this->assertTrue($result);
    }

    protected function tearDown(): void {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}