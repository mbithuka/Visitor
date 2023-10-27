<?php
// Establish a database connection
$host = "localhost";  // MySQL server host
$username = "root"; // MySQL username
$password = ""; // MySQL password
$database = "visitors"; // Database name

try {
    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Process the form data if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $residence = $_POST["residence"];
    $id_no = $_POST["id_no"];
    $phone = $_POST["phone"];
    $reason_for_visit = $_POST["reason_for_visit"];
    $card_no = $_POST["card_no"];
    $time_in = $_POST["time_in"];
    $time_out = $_POST["time_out"];

    // Use a prepared statement to insert data securely
    $sql = "INSERT INTO appointments (first_name, last_name, email, residence, id_no, phone, reason_for_visit, card_no, time_in, time_out) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error in the prepared statement: " . $conn->errorInfo());
    }

    // Bind parameters and execute the statement
    $stmt->execute([$first_name, $last_name, $email, $residence, $id_no, $phone, $reason_for_visit, $card_no, $time_in, $time_out]);

    echo "Data inserted successfully.";

    // Close the statement
    $stmt = null;
}

// Close the database connection
$conn = null;
?>
