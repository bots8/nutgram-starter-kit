<?php

namespace App\Commands;

use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Attributes\ParseMode;
use App\QueryBuilder;

class StartCommand extends Command
{
    protected string $command = 'start';

    protected ?string $description = 'Start bot';

    public function handle(Nutgram $bot): void
    {
        $username = $bot->message()->from->username;

        if(!$this->isUsernameExists($username)) {
            $this->registerUser($bot->message()->from);
        }

        $bot->sendMessage("Welcome *$username*", [
            'parse_mode' => ParseMode::MARKDOWN
        ]);
    }

    public function registerUser($from) 
    {
        $qb = new QueryBuilder();

        $qb->table('users')->insert([
            'telegramId' => $from->id,
            'username' => $from->username,
            'name' => $from->first_name.' '.$from->last_name,
        ]);
    }

    public function isUsernameExists($username)
    {
        $qb = new QueryBuilder();

        $id = $qb->table('users')
            ->select('id')
            ->where('username', '=', $username)
            ->first();

        return !empty($id);
    }
}

