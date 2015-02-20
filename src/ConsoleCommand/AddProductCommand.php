<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;

class AddProductCommand extends Command
{

    protected function configure()
    {
        $this
            ->setName('Product:add')
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'Name of product'
            )
            ->addArgument(
                'price',
                InputArgument::REQUIRED,
                'Price of product'
            )
            ->addArgument(
                'amount',
                InputArgument::REQUIRED,
                'Amount of product'
            )
        ;
    }

    protected function execute(InputInterface $input)
    {
        $name = $input->getArgument('name');
        $price = $input->getArgument('price');
        $amount = $input->getArgument('amount');

        $product = new Product();
        $product->setName($name);
        $product->setPrice($price);
        $product->setAmount($amount);

        $GLOBALS['entityManager']->persist($product);
        $GLOBALS['entityManager']->flush();
    }
}