<?php

namespace App\Commands;

use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use App\Models\User;

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

        $bot->sendMessage(
            text: "Welcome *$username*",
            parse_mode: ParseMode::MARKDOWN,
        );
    }

    function registerUser($from) {
        $user = new User();
        $user->telegramId = $from->id;
        $user->username = $from->username;
        $user->name = $from->first_name.' '.$from->last_name;

        $GLOBALS['em']->persist($user);
        $GLOBALS['em']->flush();
    }

    public function isUsernameExists($username)
    {
        return $GLOBALS['em']->createQueryBuilder()
            ->select('COUNT(u.id)')
            ->from('App\Models\User', 'u')
            ->where('u.username = :username')
            ->setParameter('username', $username)
            ->getQuery()
            ->getSingleScalarResult() > 0;
    }
}

