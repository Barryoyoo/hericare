<?php
// Disable default error display for production, handle errors gracefully
// ini_set('display_errors', 0);
// ini_set('display_startup_errors', 0);
// error_reporting(0);

header('Content-Type: application/json'); // Tell the browser the response is JSON

$response = array(); // Initialize an array for the JSON response

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['email']) && isset($_POST['message'])) {

        $firstName = htmlspecialchars(trim($_POST['firstName']));
        $lastName = htmlspecialchars(trim($_POST['lastName']));
        $email = htmlspecialchars(trim($_POST['email']));
        $message = htmlspecialchars(trim($_POST['message']));

        $fullName = $firstName . " " . $lastName;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['status'] = 'error';
            $response['message'] = 'Invalid email format.';
        } else {
            $to = "hericarenbi@gmail.com"; // Replace with the actual recipient email
            $subject = "New Message from Website Contact Form";
            $body = "Name: $fullName\nEmail: $email\n\nMessage:\n$message";
            $headers = "From: Website Contact Form <noreply@yourdomain.com>\r\n";
            $headers .= "Reply-To: $fullName <$email>\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/plain; charset=UTF-8\r\n";

            if (mail($to, $subject, $body, $headers)) {
                $response['status'] = 'success';
                $response['message'] = 'Your message was sent successfully!';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Failed to send message. Please try again later.';
                // Log the mail error on the server side for debugging
                error_log("Mail failed to send from contact form.");
            }
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error: All form fields are required.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
}

// Output the JSON response
echo json_encode($response);
?>
