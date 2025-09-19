<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email='$email' LIMIT 1");

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];

            // Save active session in DB
            $uid = $row['id'];
            $conn->query("INSERT INTO active_sessions (user_id) VALUES ('$uid')");

            header("Location: ../index2.html");
            exit();
        } else {
            echo "<script>alert('Invalid password'); window.location.href='../login.html';</script>";
        }
    } else {
        echo "<script>alert('User not found'); window.location.href='../login.html';</script>";
    }
}
$conn->close();
?>
