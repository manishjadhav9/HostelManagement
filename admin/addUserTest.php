<?php
// Database connection
$connection = new mysqli('localhost', 'root', '', 'hostelmsphp');
if ($connection->connect_error) {
    die('Connection failed: ' . $connection->connect_error);
}

// Function to test user registration
function testAddUser($regNo, $firstName, $middleName, $lastName, $gender, $contactNo, $email, $password, $expectedResult)
{
    global $connection;

    // SQL query to insert user details
    $query = "INSERT INTO userregistration (regNo, firstName, middleName, lastName, gender, contactNo, email, password) 
              VALUES ('$regNo', '$firstName', '$middleName', '$lastName', '$gender', $contactNo, '$email', '$password')";

    if ($connection->query($query) === TRUE) {
        echo "Test Passed: User added successfully.<br>";
    } else {
        echo "Test Failed: " . $connection->error . "<br>";
    }
}

// Run the test cases
echo "<h3>User Registration Testing</h3>";
testAddUser('101', 'Manish', 'Shashikant', 'Jadhav', 'Male', 9876543210, 'manish.jadhav@gmail.com', 'manish', 'success');
testAddUser('102', 'Mayur', 'Krishna', 'Solankar', 'Male', 9876543211, 'mayur.solankar@gmail.com', 'mayur', 'success');
testAddUser('103', 'Apurva', 'Krishna', 'Pawar', 'Female', 9876543212, 'apurva.pawar@gmail.com', 'apurva', 'success');
?>
