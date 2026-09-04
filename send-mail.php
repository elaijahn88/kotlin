<?php
// Fugie Prints contact form mail handler.
// This file must be hosted on a PHP-enabled server (GitHub Pages alone cannot run PHP).

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit("Method Not Allowed");
}

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$message = trim($_POST["message"] ?? "");

if ($name === "" || $message === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    exit("Please provide a valid name, email address, and message.");
}

// Prevent header injection.
$name = str_replace(["\r", "\n"], "", $name);
$email = str_replace(["\r", "\n"], "", $email);
$phone = str_replace(["\r", "\n"], "", $phone);

$to = "elajahn@gmail.com";
$subject = "New Fugie Prints website message from " . $name;

$body = "New message from the Fugie Prints website\n\n";
$body .= "Name: " . $name . "\n";
$body .= "Email: " . $email . "\n";
$body .= "Phone: " . ($phone ?: "Not provided") . "\n\n";
$body .= "Message:\n" . $message . "\n";

$headers = [];
$headers[] = "From: Fugie Prints Website <noreply@" . ($_SERVER["HTTP_HOST"] ?? "localhost") . ">";
$headers[] = "Reply-To: " . $email;
$headers[] = "Content-Type: text/plain; charset=UTF-8";

if (mail($to, $subject, $body, implode("\r\n", $headers))) {
    echo "Message sent successfully. Thank you for contacting Fugie Prints.";
} else {
    http_response_code(500);
    echo "Sorry, the message could not be sent. Please try again later.";
}
?>
