<?php
// send-mail.php — PAP Weld Core Automation contact form handler

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

$to      = 'weldcoreautomation@gmail.com';
$name    = isset($_POST['name'])        ? strip_tags(trim($_POST['name']))        : '';
$email   = isset($_POST['email'])       ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
$subject = isset($_POST['msg_subject']) ? strip_tags(trim($_POST['msg_subject'])) : 'Website Enquiry';
$message = isset($_POST['message'])     ? strip_tags(trim($_POST['message']))     : '';

if ($name === '' || $email === '' || $message === '') {
    http_response_code(400);
    exit('Please fill all required fields.');
}

$body  = "New enquiry from papweld.com\n\n";
$body .= "Name: $name\n";
$body .= "Email: $email\n";
$body .= "Subject: $subject\n\n";
$body .= "Message:\n$message\n";

$headers  = "From: PAP Weld Core Website <noreply@papweld.com>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

if (mail($to, $subject, $body, $headers)) {
    header('Location: contact.html?sent=1');
    exit;
} else {
    http_response_code(500);
    exit('Could not send. Please email weldcoreautomation@gmail.com directly.');
}