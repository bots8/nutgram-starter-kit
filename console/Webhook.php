<?php
namespace Console;
 
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
 
class Webhook extends Command
{
    protected function configure()
    {
        $this->setName('webhook')
            ->setDescription('Set or delete webhook')
            ->addArgument('cmd', InputArgument::REQUIRED, 'Set or delete.');
    }
 
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $cmd = $input->getArgument('cmd');

        $ok = $this->setOrDeleteWebhook($_ENV['WEBHOOK_URL'], $cmd);

        if ($ok) {
            $output->writeln($cmd == 'set' ? 'Webhook has been set successfully!' : 'Webhook has been deleted successfully!');
        } else {
            $output->writeln('Error ' . ($cmd == 'set' ? 'setting' : 'deleting') . ' webhook: ' . $responseArray['description']);
        }

        return Command::SUCCESS;
    }

    // Function to set or delete the webhook
    function setOrDeleteWebhook($url, $cmd)
    {
        $telegramApiUrl = 'https://api.telegram.org/bot' . $_ENV['BOT_TOKEN'] . '/setWebhook';
        
        if ($cmd = 'delete') {
            // If $set is false, change the URL to delete the webhook
            $telegramApiUrl = 'https://api.telegram.org/bot' . $_ENV['BOT_TOKEN'] . '/deleteWebhook';
        }

        $webhookData = [
            'url' => $url,
        ];

        $ch = curl_init($telegramApiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $webhookData);
        $response = curl_exec($ch);
        curl_close($ch);

        $responseArray = json_decode($response, true);

        return $responseArray['ok'];
    }
}