<?php

namespace App\Command;

use App\Traits\CommandTrait;
use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class EditItemCommand extends Command
{
    use CommandTrait;

    protected static $defaultName = 'api:edit';

    protected function configure()
    {
        $this->setDescription('Edit item from the API server');

        // Options
        $this->addOption('id', null, InputOption::VALUE_REQUIRED, 'The id of the item to be edited.');

        // Arguments
        $this->addArgument('name', InputArgument::REQUIRED, 'The name of the item to be changed.');
        $this->addArgument('amount', InputArgument::REQUIRED, 'The amount of the item in stock.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = new Client();
        $response = $client->request('PUT', $this->buildUrl($input), [
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