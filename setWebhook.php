<?php

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Telegram API endpoint for setting the webhook
$telegramApiUrl = 'https://api.telegram.org/bot' . $_ENV['BOT_TOKEN'] . '/setWebhook';

// Set up the data to send to the Telegram API
$webhookData = [
    'url' => $_ENV['WEBHOOK_URL'],
];

// Use cURL to make the request to set the webhook
$ch = curl_init($telegramApiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $webhookData);
$response = curl_exec($ch);
curl_close($ch);

$responseArray = json_decode($response, true);

// Check if the request was successful
if ($responseArray['ok']) {
    echo 'Webhook has been set successfully!';
} else {
    echo 'Error setting webhook: ' . $responseArray['description'];
}
