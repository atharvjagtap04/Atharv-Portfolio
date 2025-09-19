<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "travel_booking";

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get POST data
$name = $_POST['name'];
$number = $_POST['number'];
$email = $_POST['email'];
$boarding = $_POST['boarding'];
$destination = $_POST['destination'];
$date = $_POST['date'];

// Server-side validation
if (!preg_match('/^[0-9]{10}$/', $number)) {
  header("Location: booknow.php?error=❌ Invalid mobile number. Must be exactly 10 digits.");
  exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  header("Location: booknow.php?error=❌ Invalid email format.");
  exit();
}

// Insert data using prepared statement
$stmt = $conn->prepare("INSERT INTO bookings (name, number, email, boarding, destination, date) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $name, $number, $email, $boarding, $destination, $date);

if ($stmt->execute()) {
  header("Location: successful.html");
  exit();
} else {
  header("Location: booknow.php?error=" . urlencode("❌ Database error: " . $stmt->error));
  exit();
}

$stmt->close();
$conn->close();
?>
