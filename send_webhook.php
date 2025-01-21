<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Webhook URL
$webhookUrl = "https://example.com/webhook";

// Payload data
$data = [
    "event" => "new_announcement",
    "timestamp" => date('c'),
    "announcement" => "This is a test announcement."
];

// Convert data to JSON
$jsonPayload = json_encode($data);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo "JSON encoding error: " . json_last_error_msg();
    exit();
}

// Initialize cURL
$ch = curl_init($webhookUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPayload);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Content-Length: ' . strlen($jsonPayload)
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute cURL and check for errors
$response = curl_exec($ch);
if ($response === false) {
    echo "cURL error: " . curl_error($ch);
    curl_close($ch);
    exit();
}

// Close cURL and output response
curl_close($ch);
echo "Webhook sent successfully: " . $response;
?>
