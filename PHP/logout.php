<?php
session_start();
include 'config.php';

if (isset($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];

    // Delete session record from DB
    $conn->query("DELETE FROM active_sessions WHERE user_id='$uid'");

    session_unset();
    session_destroy();
}
header("Location: ../index.html");
exit();
?>
