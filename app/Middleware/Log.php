<?php

namespace App\Middleware;

use SergiX44\Nutgram\Nutgram;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * This is example code to create Middleware
 */
class Log extends ConsoleOutput {

	function __invoke(Nutgram $bot, $next)
	{
		$date = date('Y-m-d');
		$time = date('H:i:s');
		
		$msg = $bot->message();
		$username = $msg->from->username;
		$message_id = $msg->message_id;
		$type = $this->getType($msg);
		$bgType = $this->getColorType($type);

		if($type == "COMMAND") {
			$dots = $this->echoDot("$date $time $type $username $message_id {$msg->text}");
			$this->writeln("\n  <fg=gray>{$date}</> {$time} <fg=white;bg=$bgType;options=bold> {$type} </> <fg=cyan>{$msg->text}</> {$dots} [<fg=white;options=bold>@$username</> | <fg=cyan>$message_id</>]");
		} else {
			$dots = $this->echoDot("$date $time $type $username $message_id");
			$this->writeln("\n  <fg=gray>{$date}</> {$time} <fg=white;bg=$bgType;options=bold> {$type} </> {$dots} [<fg=white;options=bold>@$username</> | <fg=cyan>$message_id</>]");
		}

		$next($bot);
	}

	public function echoDot($char)
	{
		$cols = $this->getCols();
		$min = strlen($char) + 10;

		$dots = "";
		for($i=0;$i<$cols - $min;$i++) {
			$dots .= ".";
		}

		return $dots;
	}

	public function getCols()
	{
		if (PHP_OS_FAMILY === 'Windows') {
            $a1 = exec('mode con');
            $arr = explode("\n", $a1);
            $col = trim(explode(':', $arr[4])[1]);
            return $col;
        } 

		return exec('tput cols');
	}

	public function getType($msg)
	{
		switch ($msg) {
			case $msg->isCallbackQuery():
				$result = "CALLBACK QUERY";
				break;

			case !empty($msg->text) && $msg->text[0] == '/':
				$result = "COMMAND";
				break;

			case !empty($msg->text):
				$result = "TEXT";
				break;

			case !empty($msg->photo):
				$result = "PHOTO";
				break;

			case !empty($msg->document):
				$result = "DOCUMENT";
				break;

			case !empty($msg->audio):
				$result = "AUDIO";
				break;

			case !empty($msg->video):
				$result = "VIDEO";
				break;

			case !empty($msg->sticker):
				$result = "STICKER";
				break;

			case !empty($msg->contact):
				$result = "CONTACT";
				break;

			case !empty($msg->voice):
				$result = "VOICE";
				break;

			case !empty($msg->location):
				$result = "LOCATION";
				break;

			case !empty($msg->poll):
				$result = "POLL";
				break;
			
			default:
				$result = "???";
				break;
		}

		return $result;
	}

	public function getColorType($type)
	{
		$colors = [
			'TEXT' => 'blue',
			'COMMAND' => 'blue',
			'PHOTO' => '#dba716',
			'DOCUMENT' => '#dba716',
			'AUDIO' => '#dba716',
			'VIDEO' => '#dba716',
			'STICKER' => '#26b017',
			'CONTACT' => '#26b017',
			'VOICE' => '#26b017',
			'LOCATION' => '#26b017',
			'CALLBACK QUERY' => 'red',
			'???' => 'magenta'
		];

		return $colors[$type];
	}
}