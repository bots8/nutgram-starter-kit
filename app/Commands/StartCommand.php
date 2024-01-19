<?php

namespace App\Commands;

use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;

class StartCommand extends Command
{
    protected string $command = 'start';

    protected ?string $description = 'Start bot';

    public function handle(Nutgram $bot): void
    {
        $username = $bot->message()->from->username;

        $bot->sendMessage(
            text: "Welcome *$username*",
            parse_mode: ParseMode::MARKDOWN,
        );
    }
}

