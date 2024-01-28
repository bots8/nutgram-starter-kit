<?php

namespace App;

use Symfony\Component\Console\Application;

/**
 * Kernel bot
 */
class Kernel
{
	protected function initConsole()
	{
		$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__.'/..');
		$dotenv->load();

		$app = new Application();

		return $app;
	}
	
	public function loadCommands($dir)
	{
		$app = $this->initConsole();

		if(!file_exists($dir)) {
			throw new \Exception("Folder command not found", 1);
			
		}

		$files = glob($dir . '/*.php');

		foreach ($files as $file) {
		    require_once $file;

		    // Assuming your class names match file names
		    $className = basename($file, '.php');
		    $fullClassName = 'Console\\' . $className;

		    if (class_exists($fullClassName)) {
		        $instance = new $fullClassName();
		        $app->add($instance);
		    }
		}


		return $app;
	}
}