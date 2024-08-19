<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Function to clean input
  function clean_input($data)
  {
    $data = strip_tags($data);             // Strip HTML and PHP tags
    $data = htmlspecialchars($data);       // Convert special characters to HTML entities
    $data = trim($data);                   // Remove whitespace from both sides
    $data = stripslashes($data);           // Remove backslashes
    return $data;
  }

  // Clean and sanitize inputs
  $name = clean_input($_POST["name"]);
  $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
  $subject = clean_input($_POST["subject"]);
  $message = clean_input($_POST["message"]);

  // Check data
  if (empty($name) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo "Please complete the form and try again.";
    exit;
  }

  // Recipient email
  $recipient = "navid.jafartash@yahoo.com"; // Replace with your email address

  // Email content
  $email_content = "Name: $name\n";
  $email_content .= "Email: $email\n\n";
  $email_content .= "Subject: $subject\n\n";
  $email_content .= "Message:\n$message\n";

  // Email headers
  $email_headers = "From: $name <$email>";

  // Send email
  if (mail($recipient, $subject, $email_content, $email_headers)) {
    http_response_code(200);
    echo "Thank you! Your message has been sent.";
  } else {
    http_response_code(500);
    echo "Oops! Something went wrong, we couldn't send your message.";
  }
} else {
  http_response_code(403);
  echo "There was a problem with your submission, please try again.";
}
