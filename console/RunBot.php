<?php

namespace Console;
 
use App\Middleware\Log;
use SergiX44\Nutgram\RunningMode\Polling;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
 
class RunBot extends Command
{
    protected function configure()
    {
        $this->setName('run')->setDescription('Run bot in polling mode');
    }
 
    protected function execute(InputInterface $input, OutputInterface $output)
    {
    	$app = require_once __DIR__.'/../bootstrap.php';
		
		$app->setRunningMode(Polling::class);

        $app->middleware(Log::class);

		$app->registerMyCommands();
		$app->run();
    }
}