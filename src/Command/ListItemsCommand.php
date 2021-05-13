<?php

namespace App\Command;

use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ListItemsCommand extends Command
{
    protected static $defaultName = 'api:list';

    protected function configure()
    {
        $this->setDescription('List items from the API server');

        $this->addOption('stock', null, InputOption::VALUE_OPTIONAL, 'To define with true|false if the results should be with stock available or not.');
        $this->addOption('more', null, InputOption::VALUE_OPTIONAL, 'To define a number where the stock should be bigger than it.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $query = [];
        if (empty($input->getOption('stock')) === false) {
            $query['has_stock'] = $input->getOption('stock');
        }
        if (empty($input->getOption('more')) === false) {
            $query['has_more_than'] = $input->getOption('more');
        }
        $builtQuery = http_build_query($query);

        $client = new Client();
        $response = $client->request('GET', 'http://127.0.0.1:8000/api/item?' . $builtQuery);
        $content = json_decode($response->getBody(), true);

        if ($content['success'] === true) {
            $output->writeln([
                'Success!',
                '',
                'We have found ' . $content['data']['quantity'] . ' items.',
            ]);

            foreach ($content['data']['list'] as $item) {
                $output->writeln([
                    'id: ' . $item['Id'],
                    'name: ' . $item['Name'],
                    'amount: ' . $item['Amount'],
                    '',
                ]);
            }
        } else {
            $output->writeln([
                'Houston, mamy sytuacje!',
                '',
                'Something went wrong, this is the error we got: ' . $content['error'],
            ]);
        }
    }
}