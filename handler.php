<?php

use App\Commands\StartCommand;
use App\Conversations\ExampleConversation;


$bot->registerCommand(StartCommand::class);

$bot->onCommand('input', ExampleConversation::class);