<?php

namespace App\Command;

use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EditItemCommand extends Command
{
    protected static $defaultName = 'api:edit';

    protected function configure()
    {
        $this->setDescription('Edit item from the API server');

        // Arguments
        $this->addArgument('id', InputArgument::REQUIRED, 'The id of the item to be edited.');
        $this->addArgument('name', InputArgument::REQUIRED, 'The name of the item to be changed.');
        $this->addArgument('amount', InputArgument::REQUIRED, 'The amount of the item in stock.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = new Client();
        $response = $client->request('PUT', 'http://127.0.0.1:8000/api/item/' . $input->getArgument('id'), [
            'json' => [
                'name' => $input->getArgument('name'),
                'amount' => $input->getArgument('amount'),
            ],
        ]);

        $content = json_decode($response->getBody(), true);

        if ($content['success'] === true) {
            $output->writeln([
                'Success!',
                '',
                'We have edited an item: "' . $content['data']['Name'] . '" with a stock of: ' . $content['data']['Amount'],
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