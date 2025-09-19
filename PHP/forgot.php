<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $result = $conn->query("SELECT * FROM users WHERE email='$email' LIMIT 1");

    if ($result->num_rows > 0) {
        $_SESSION['reset_email'] = $email;  // save email in session
        header("Location: ../reset.html"); // go to reset password page
        exit();
    } else {
        echo "<script>alert('Email not found! Please sign up.'); window.location.href='../create.html';</script>";
    }
}
$conn->close();
?>