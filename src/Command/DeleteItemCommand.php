<?php

namespace App\Command;

use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteItemCommand extends Command
{
    protected static $defaultName = 'api:delete';

    protected function configure()
    {
        $this->setDescription('Delete one item from the API server');

        // Arguments
        $this->addArgument('id', InputArgument::REQUIRED, 'The id of the item to be deleted.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = new Client();
        $response = $client->request('DELETE', 'http://127.0.0.1:8000/api/item/' . $input->getArgument('id'));
        $content = json_decode($response->getBody(), true);

        if ($content['success'] === true) {
            $output->writeln([
                'Success!',
                '',
                'We deleted an item from the API server: ' . $input->getArgument('id'),
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