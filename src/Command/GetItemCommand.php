<?php

namespace App\Command;

use App\Traits\CommandTrait;
use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GetItemCommand extends Command
{
    use CommandTrait;

    protected static $defaultName = 'api:get';

    protected function configure()
    {
        $this->setDescription('Show one item from the API server');

        $this->addOption('id', null, InputOption::VALUE_REQUIRED, 'The id of the item to be requested.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = new Client();
        $response = $client->request('GET', $this->buildUrl($input));
        $content = json_decode($response->getBody(), true);

        if ($content['success'] === true) {
            $output->writeln([
                'Success!',
                '',
                'We requested an item from the API server: "' . $content['data']['Name'] . '" with a stock of: ' . $content['data']['Amount'],
            ]);
        } else {
            $output->writeln([
                'Houston, mamy sytuacje!',
                '',
                'Something went wrong, this is the error we got: ' . $content['error'],
            ]);
        }
    }
}