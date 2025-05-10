<?php

// Set these for temporary error reporting during development
// Remove or comment out in production
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are present
    if (isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['email']) && isset($_POST['message'])) {

        // Retrieve and sanitize data from the $_POST superglobal array
        $firstName = htmlspecialchars(trim($_POST['firstName']));
        $lastName = htmlspecialchars(trim($_POST['lastName']));
        $email = htmlspecialchars(trim($_POST['email']));
        $message = htmlspecialchars(trim($_POST['message']));

        // Combine names
        $fullName = $firstName . " " . $lastName;

        // Basic email validation (more robust validation can be added)
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Handle invalid email case
            echo "Invalid email format.";
            exit; // Stop script execution
        }

        // Set up email details
        $to = "hericarenbi@gmail.com"; // Replace with the actual recipient email
        $subject = "New Message from Website Contact Form";
        $body = "Name: $fullName\n";
        $body .= "Email: $email\n\n";
        $body .= "Message:\n$message";

        // Set email headers
        // Using the sender's email in the From header can sometimes cause issues.
        // A safer approach is often to use a fixed email for the 'From' and
        // put the sender's email in the Reply-To header.
        $headers = "From: Website Contact Form <noreply@yourdomain.com>\r\n"; // Use a noreply address
        $headers .= "Reply-To: $fullName <$email>\r\n"; // Put sender's info here
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/plain; charset=UTF-8\r\n";


        // Attempt to send the email
        if (mail($to, $subject, $body, $headers)) {
            // Email sent successfully - Redirect to a thank you page
            // Make sure thank_you.html exists
            header("Location: contact.html");
            exit; // Stop script execution after redirecting
        } else {
            // Email failed to send
            // You might want to log this error on the server side
            echo "Oops! Something went wrong and we couldn't send your message. Please try again later.";
        }

    } else {
        // Not all required fields were submitted
        echo "Error: All form fields are required.";
    }

} else {
    // Not a POST request - prevent direct access to the script
    echo "Invalid request method. Please submit the form.";
}
?>
