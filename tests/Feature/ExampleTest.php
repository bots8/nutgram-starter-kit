<?php

use SergiX44\Nutgram\Nutgram;

it('can get updates', function () {
    $bot = new Nutgram('6602958787:AAHsKBA4GsD9zr1vyojG8xbviLf6giV7Jjc', [
        'timeout' => 5
    ]);

    $updates = $bot->getUpdates();

    expect($updates)->toBeArray();
});