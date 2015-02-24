<?php

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;

class AddProductCommand extends \ConsoleCommand\CommandWithEntityManager
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

        $this->em->persist($product);
        $this->em->flush();
    }
}