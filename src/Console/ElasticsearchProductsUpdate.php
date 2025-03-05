<?php

namespace App\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Command\Command;
use App\Helpers\ElasticsearchProductsHelper;

class ElasticsearchProductsUpdate extends Command
{
    private $elasticsearchProductsHelper;

    public function __construct(ElasticsearchProductsHelper $esh)
    {
        $this->elasticsearchProductsHelper = $esh;
        parent::__construct('app:elasticsearch_products_update');
    }

    /*
     * run
     * php bin/console app:elasticsearch_products_update
     * */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        try {
            $this->elasticsearchProductsHelper->updateProductsElastic();
            $io->success('success');
        } catch (\Throwable $e) {
            $io->error('error: '.$e->getMessage().'   '.$e->getTraceAsString());
        }

        return Command::SUCCESS;
    }


    public function __destruct()
    {
        exit(0);
    }
}