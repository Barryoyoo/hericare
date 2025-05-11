<?php
// Enable error reporting temporarily
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "Request method: " . $_SERVER['REQUEST_METHOD'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<br>Received a POST request.";
    // Check if any POST data is received
    if (!empty($_POST)) {
        echo "<br>POST data received:";
        print_r($_POST); // Print the contents of the $_POST array
    } else {
        echo "<br>POST request received, but no data was sent.";
    }
} else {
    echo "<br>This script expects a POST request.";
}
?>
