<?php

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Function to set or delete the webhook
function setOrDeleteWebhook($url, $set = true)
{
    $telegramApiUrl = 'https://api.telegram.org/bot' . $_ENV['BOT_TOKEN'] . '/setWebhook';
    
    if (!$set) {
        // If $set is false, change the URL to delete the webhook
        $telegramApiUrl = 'https://api.telegram.org/bot' . $_ENV['BOT_TOKEN'] . '/deleteWebhook';
    }

    $webhookData = [
        'url' => $url,
    ];

    $ch = curl_init($telegramApiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $webhookData);
    $response = curl_exec($ch);
    curl_close($ch);

    $responseArray = json_decode($response, true);

    if ($responseArray['ok']) {
        echo $set ? 'Webhook has been set successfully!' : 'Webhook has been deleted successfully!';
    } else {
        echo 'Error ' . ($set ? 'setting' : 'deleting') . ' webhook: ' . $responseArray['description'];
    }
}

// Check if the script is called with an argument
if ($argc > 1) {
    $argument = $argv[1];
    
    if ($argument === 'delete') {
        // Call the function to delete the webhook
        setOrDeleteWebhook('', false);
    } else if ($argument === 'set') {
        // Call the function to set the webhook
        setOrDeleteWebhook($_ENV['WEBHOOK_URL']);
    } else {
        echo "Invalid argument.\n";
    }
} else {
    echo "Use 'set' or 'delete'\n";
}
