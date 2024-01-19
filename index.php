<?php

require 'vendor/autoload.php';

use SergiX44\Nutgram\Nutgram;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;
use SergiX44\Nutgram\Configuration;


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$psr6Cache = new FilesystemAdapter();
$psr16Cache = new Psr16Cache($psr6Cache);

$bot = new Nutgram($_ENV['BOT_TOKEN'], new Configuration(
    cache: $psr16Cache
));

require 'handler.php';

$bot->registerMyCommands();
$bot->run();
