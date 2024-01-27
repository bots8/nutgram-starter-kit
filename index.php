<?php

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Webhook;
use SergiX44\Nutgram\RunningMode\Polling;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;
use SergiX44\Nutgram\Configuration;


$psr6Cache = new FilesystemAdapter();
$psr16Cache = new Psr16Cache($psr6Cache);

$bot = new Nutgram($_ENV['BOT_TOKEN'], [
    'cache' => $psr16Cache
]);

// Running mode
if($_ENV['ENV'] == 'development') {
	$bot->setRunningMode(Polling::class);
} else {
	$bot->setRunningMode(Webhook::class);
}

require 'handler.php';

$bot->registerMyCommands();
$bot->run();
