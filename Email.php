<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize input
    $name = strip_tags(trim($_POST["name"] ?? ''));
    $email = filter_var(trim($_POST["email"] ?? ''), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"] ?? ''));
    $message = trim($_POST["message"] ?? '');

    // Validate
    if (empty($name) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Please fill out the form correctly.";
        exit;
    }

    // Email setup
    $to = "bafanamahase.bm@gmail.com";
    $email_subject = "New message from: $name - $subject";
    $email_body = "From: $name\nEmail: $email\n\nMessage:\n$message\n";
    $headers = "From: $name <$email>";

    // Send mail
    if (mail($to, $email_subject, $email_body, $headers)) {
        http_response_code(200);
        echo "Thank you! Your message has been sent.";
    } else {
        http_response_code(500);
        echo "Oops! Mail sending failed. Try again later.";
    }
} else {
    http_response_code(403);
    echo "Access denied.";
}
