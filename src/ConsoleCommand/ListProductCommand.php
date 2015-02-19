<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class ListProductCommand extends Command
{
    protected function configure()
    {
        $this->setName('Product:list');
    }

    public function execute()
    {
        $productRepository = $GLOBALS['entityManager']->getRepository('Product');
        $products = $productRepository->findAll();

        foreach($products as $product) {
            echo sprintf("%s (ID product '%d' price of %d rub. Amount product '%d')\n", $product->getName(), $product->getId(), $product->getPrice(), $product->getAmount());
        }
    }
}