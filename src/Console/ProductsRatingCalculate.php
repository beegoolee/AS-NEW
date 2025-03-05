<?php

namespace App\Console;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Command\Command;
use App\Helpers\ProductReviewsHelper;

class ProductsRatingCalculate extends Command
{
    private $productReviewsHelper;

    public function __construct(ProductReviewsHelper $prh)
    {
        $this->productReviewsHelper = $prh;
        parent::__construct('app:products_rating_calculate');
    }

    /*
     * run
     * php bin/console app:products_rating_calculate
     * */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        try {
            $this->productReviewsHelper->updateProductsRating();
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