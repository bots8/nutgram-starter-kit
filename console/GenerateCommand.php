<?php
namespace Console;
 
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
 
class GenerateCommand extends Command
{
    protected function configure()
    {
        $this->setName('make:command')
            ->setDescription('Create a new command class')
            ->addArgument('name', InputArgument::REQUIRED, 'Pass the name class.');
    }
 
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $stub = file_get_contents(__DIR__.'/stub/command.stub');

        $name = $input->getArgument('name');
        $code = str_replace('ClassName', $name, $stub);

        file_put_contents(__DIR__."/../app/Commands/$name.php", $code);

        $output->writeln("\n   <fg=gray;bg=blue>INFO</> Telegram command <fg=white;options=bold>[app/Commands/$name.php]</> created successfully.");

        return Command::SUCCESS;
    }
}