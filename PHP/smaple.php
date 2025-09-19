<!-- CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    mobile VARCHAR(20),
    age INT,
    gender VARCHAR(10),
    address TEXT,
    birth_date DATE,
    boarding VARCHAR(50),
    destination VARCHAR(50),
    travel_date DATE,
    price INT,
    payment_id VARCHAR(100),
    status VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
); -->

<?php
session_start();
include 'config.php'; // MySQL connection
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login first!'); window.location.href='../login.html';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $birth_date = $_POST['birth_date'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $boarding = $_POST['boarding'];
    $destination = $_POST['destination'];
    $travel_date = '2025-12-25';
    $price = $_POST['price'];
    $payment_id = $_POST['payment_id'] ?? null;
    $status = $_POST['status'] ?? 'failed';

    $stmt = $conn->prepare("INSERT INTO bookings 
    (name, email, mobile, age, gender, address, birth_date, boarding, destination, travel_date, price, payment_id, status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssisissssiss", $name, $email, $mobile, $age, $gender, $address, $birth_date, $boarding, $destination, $travel_date, $price, $payment_id, $status);

    if ($stmt->execute()) {
        echo "success";
    } else {
        http_response_code(500);
        echo "failed";
    }

    $stmt->close();
    $conn->close();
}
?>

