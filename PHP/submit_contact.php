<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form fields
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    // Your email address
    $to = "karanbarge762@gmail.com";
    $subject = "New Contact Form Message from $name";

    // Email body
    $body = "You have received a new message from the contact form.\n\n";
    $body .= "Name: $name\n";
    $body .= "Email: $email\n";
    $body .= "Message:\n$message\n";

    // Headers
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Send email
    if (mail($to, $subject, $body, $headers)) {
        echo "<h2>✅ Message Sent Successfully!</h2><p>We will get back to you soon.</p>";
    } else {
        echo "<h2>❌ Sorry, something went wrong. Please try again later.</h2>";
    }
} else {
    echo "Invalid request.";
}
?>
