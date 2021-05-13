<?php

namespace App\Command;

use App\Traits\CommandTrait;
use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteItemCommand extends Command
{
    use CommandTrait;

    protected static $defaultName = 'api:delete';

    protected function configure()
    {
        $this->setDescription('Delete one item from the API server');

        // Options
        $this->addOption('id', null, InputOption::VALUE_REQUIRED, 'The id of the item to be deleted.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = new Client();
        $response = $client->request('DELETE', $this->buildUrl($input));
        $content = json_decode($response->getBody(), true);

        if ($content['success'] === true) {
            $output->writeln([
                'Success!',
                '',
                'We deleted an item from the API server: ' . $input->getOption('id'),
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