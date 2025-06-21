<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the input value from the form
    $query = isset($_POST['query']) ? trim($_POST['query']) : '';

    // Discord webhook URL
    $webhookUrl = 'https://discord.com/api/webhooks/1386027994556141618/dzvAPcOU_ALxasTPSVgdB3I4Qaag00GZyhPW-63knER_y77IT4KKUqHmDJwcDHzcP2jz';

    // Validate the input (e.g., check if it's an email)
    $isValid = filter_var($query, FILTER_VALIDATE_EMAIL);
    $error = $isValid ? null : 'Invalid email address';

    // Prepare the data to send to Discord
    $timestamp = date('Y-m-d H:i:s');
    $data = [
        'content' => "New submission received:\n" .
                     "**Query:** `{$query}`\n" .
                     "**Valid:** " . ($isValid ? '✅ Yes' : '❌ No') . "\n" .
                     "**Error:** " . ($error ?? 'None') . "\n" .
                     "**Timestamp:** `{$timestamp}`"
    ];

    // Initialize cURL session
    $ch = curl_init($webhookUrl);

    // Set cURL options
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the request (silently, no output to user)
    curl_exec($ch);

    // Close cURL session
    curl_close($ch);

    // Redirect the user back to the original page
    header('Location: index.html'); // Replace with your HTML file name
    exit;
}

// If not a POST request, redirect to the original page
header('Location: index.html');
exit;
?>
