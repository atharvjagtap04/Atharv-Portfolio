<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['reset_email'])) {
        echo "<script>alert('Session expired! Try again.'); window.location.href='../forgot.html';</script>";
        exit();
    }

    $email = $_SESSION['reset_email'];
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    if ($password !== $confirm) {
        echo "<script>alert('Passwords do not match!'); window.location.href='../reset.html';</script>";
        exit();
    }

    $hashed = password_hash($password, PASSWORD_BCRYPT);
    $sql = "UPDATE users SET password='$hashed' WHERE email='$email'";

    if ($conn->query($sql) === TRUE) {
        unset($_SESSION['reset_email']); // clear session
        echo "<script>alert('Password updated successfully! Please login.'); window.location.href='../login.html';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
$conn->close();
?>
