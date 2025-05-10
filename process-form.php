<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the $_POST superglobal array
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Now you can process the data, e.g., send an email
    $to = "hericarenbi@gmail.com";
    $subject = "New message from contact form";
    $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
    $headers = "From: $name <$email>";

    if (mail($to, $subject, $body, $headers)) {
        echo "Location: contact.html";
        // Or redirect to a thank you page: header("Location: thank_you.html");
    } else {
        echo "Failed to send message.";
    }
} else {
    echo "Invalid request method.";
}
?>
