<?php

// --- Error Reporting (for development) ---
// Enable display of errors for debugging. REMOVE or COMMENT OUT in production!
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// ---------------------------------------

// Set the content type to JSON
header('Content-Type: application/json');

$response = array(); // Prepare the array for our JSON response

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if all expected fields were sent
    if (isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['email']) && isset($_POST['message'])) {

        // Retrieve and sanitize data
        $firstName = htmlspecialchars(trim($_POST['firstName']));
        $lastName = htmlspecialchars(trim($_POST['lastName']));
        $email = htmlspecialchars(trim($_POST['email']));
        $message = htmlspecialchars(trim($_POST['message']));

        $fullName = $firstName . " " . $lastName;

        // Basic Server-side Validation
        if (empty($firstName) || empty($lastName) || empty($email) || empty($message)) {
             $response['status'] = 'error';
             $response['message'] = 'All fields are required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['status'] = 'error';
            $response['message'] = 'Invalid email format.';
        } else {
            // --- Email Sending Logic ---
            $to = "bodoro2017@gmail.com"; // <<< --- Replace with the actual recipient email
            $subject = "New Message from Website Contact Form";
            $body = "Name: $fullName\n";
            $body .= "Email: $email\n\n";
            $body .= "Message:\n$message";

            // Set email headers for better deliverability
            // Using a 'noreply' address for From and sender's email in Reply-To is best practice
            $headers = "From: Website Contact Form <noreply@yourdomain.com>\r\n"; // <<< --- Replace with a valid email on your domain
            $headers .= "Reply-To: $fullName <$email>\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/plain; charset=UTF-8\r\n";

            // Attempt to send the email
            if (mail($to, $subject, $body, $headers)) {
                $response['status'] = 'success';
                $response['message'] = 'Your message was sent successfully! We will get back to you soon.';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Sorry, there was a problem sending your message. Please try again later.';
                // Log mail errors on the server for debugging
                error_log("Failed to send contact form email. Recipient: $to");
            }
            // --- End of Email Sending Logic ---
        }

    } else {
        // If the request is POST but expected fields are missing
        $response['status'] = 'error';
        $response['message'] = 'Incomplete form submission.';
    }

} else {
    // If the request method is not POST (e.g., someone tries to access process-form.php directly)
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
}

// Output the JSON response
echo json_encode($response);

// --- Production Error Handling ---
// In a production environment, you would want more sophisticated error handling
// that doesn't display errors to the user but logs them securely on the server.
// You would also remove the ini_set and error_reporting lines at the top.
// -----------------------------------

?>
