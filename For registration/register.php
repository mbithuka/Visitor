<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "visitors";

try {
    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $stmt = $conn->prepare("INSERT INTO appointments (first_name, last_name, email, residence, id_no, phone, reason_for_visit, card_no, time_in, time_out) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST["first_name"],
            $_POST["last_name"],
            $_POST["email"],
            $_POST["residence"],
            $_POST["id_no"],
            $_POST["phone"],
            $_POST["reason_for_visit"],
            $_POST["card_no"],
            $_POST["time_in"],
            $_POST["time_out"]
        ]);

        echo "success: Data inserted successfully.";
    } catch (PDOException $e) {
        echo "error: " . $e->getMessage();
    }
} else {
    echo "error: No data received.";
}

$conn = null;
?>
