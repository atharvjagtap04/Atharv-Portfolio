<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode([
        "status" => "error",
        "message" => "Please login first!"
    ]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id    = (int)$_SESSION['user_id'];
    $name       = $_POST['name'];
    $mobile     = $_POST['mobile'];
    $email      = $_POST['email'];
    $birth_date = $_POST['birth_date'];
    $age        = (int)$_POST['age'];
    $gender     = $_POST['gender'];
    $address    = $_POST['address'];
    $boarding   = $_POST['boarding'];
    $destination= $_POST['destination'];
    $travel_date= $_POST['travel_date'];
    $price      = (int)$_POST['price'];
    $payment_id = $_POST['payment_id'] ?? null;
    $status     = $_POST['status'] ?? 'pending'; 

    
    $stmt = $conn->prepare("INSERT INTO bookings 
        (user_id, name, email, mobile, age, gender, address, birth_date, boarding, destination, travel_date, price, payment_id, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

  $stmt->bind_param(
        "isssisssssssis", 
        $user_id, $name, $email, $mobile, $age, $gender, $address,
        $birth_date, $boarding, $destination, $travel_date,
        $price, $payment_id, $status
    );

   if ($stmt->execute()) {
    echo "success";
}  else {
        http_response_code(500);
        echo json_encode([
            "status" => "error",
            "message" => "Insert failed: " . $stmt->error
        ]);
    }
$stmt->close();
$conn->close();
}
?>


<!-- //if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login first!'); window.location.href='../login.html';</script>";
    exit();
} -->
