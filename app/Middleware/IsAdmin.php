<?php

namespace App\Middleware;

use SergiX44\Nutgram\Nutgram;

/**
 * Middleware for checking if user is admin
 * 
 * This is example code to create Middleware
 */
class IsAdmin {

	function __invoke(Nutgram $bot, $next)
	{
		if($bot->message()->from->username == 'myusername') {
			$next($bot);
		} 

		$bot->sendMessage('You are not an admin');
	}
}