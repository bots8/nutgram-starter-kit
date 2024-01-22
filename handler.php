<?php

use App\Commands\StartCommand;
use App\Conversations\ExampleConversation;

use App\Middleware\IsAdmin;

// Global middleware
// $bot->middleware(IsAdmin::class);

$bot->registerCommand(StartCommand::class);

$bot->onCommand('input', ExampleConversation::class);