<?php

namespace App\Conversations;

use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class ExampleConversation extends Conversation {

    public function start(Nutgram $bot)
    {
        $bot->sendMessage('Enter your name');
        $this->next('final');
    }

    public function final(Nutgram $bot)
    {
        $name = $bot->message()->text;

        $bot->sendMessage("Hi $name");
        $this->end();
    }
}
