<?php

use SergiX44\Nutgram\Nutgram;

it('can get updates', function () {
    $bot = new Nutgram('', [
        'timeout' => 5
    ]);

    $updates = $bot->getUpdates();

    expect($updates)->toBeArray();
});