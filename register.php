<?php
$host = "db";
$username = "une";
$password = "password";
$database = "visitors";

// Create a connection to the database
$conn = new mysqli($host, $username, $password, $database);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the table exists
$tableExists = $conn->query("SHOW TABLES LIKE 'appointments'")->num_rows > 0;

// Create table if it doesn't exist
if (!$tableExists) {
    $sql = "CREATE TABLE appointments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(50) NOT NULL,
        last_name VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL,
        residence VARCHAR(100) NOT NULL,
        id_no VARCHAR(20) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        reason_for_visit VARCHAR(255) NOT NULL,
        card_no VARCHAR(20) NOT NULL,
        time_in TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        time_out TIMESTAMP NOT NULL
    )";

    if ($conn->query($sql) === FALSE) {
        echo "error: " . $conn->error;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($tableExists) {
        // Prepare and execute INSERT query
        $stmt = $conn->prepare("INSERT INTO appointments (first_name, last_name, email, residence, id_no, phone, reason_for_visit, card_no, time_in, time_out) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
$stmt->bind_param("ssssssss", $_POST["first_name"], $_POST["last_name"], $_POST["email"], $_POST["residence"], $_POST["id_no"], $_POST["phone"], $_POST["reason_for_visit"], $_POST["card_no"]);
$stmt->execute();

        echo "success: Data inserted successfully.";
    } else {
        echo "error: Table 'appointments' does not exist.";
    }
} else {
    echo "error: No data received.";
}

// Close the connection
$conn->close();
?>
