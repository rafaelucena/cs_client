<?php

namespace App\Traits;

use Symfony\Component\Console\Input\InputInterface;

trait CommandTrait
{
    /**
     * @param InputInterface $input
     *
     * @return string
     */
    protected function buildUrl(InputInterface $input): string
    {
        $query = $this->buildQuery($input);
        if (empty($query) === false) {
            $url = getenv('API_URL') . '?' . $query;
        } elseif($input->hasOption('id')) {
            $url = getenv('API_URL') . '/' . $input->getOption('id');
        } else {
            $url = getenv('API_URL');
        }

        return $url;
    }

    /**
     * @param InputInterface $input
     *
     * @return string
     */
    private function buildQuery(InputInterface $input): string
    {
        $query = [];
        if ($input->hasOption('stock') && empty($input->getOption('stock')) === false) {
            $query['has_stock'] = $input->getOption('stock');
        }

        if ($input->hasOption('more') && empty($input->getOption('more')) === false) {
            $query['has_more_than'] = $input->getOption('more');
        }

        return http_build_query($query);
    }
}