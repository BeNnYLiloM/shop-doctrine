<?php

class ListProductCommand extends \ConsoleCommand\CommandWithEntityManager
{
    protected function configure()
    {
        $this->setName('Product:list');
    }

    public function execute()
    {
        $productRepository = $this->em->getRepository('Product');
        $products = $productRepository->findAll();

        foreach($products as $product) {
            echo sprintf("%s (ID product '%d' price of %d rub. Amount product '%d')\n", $product->getName(), $product->getId(), $product->getPrice(), $product->getAmount());
        }
    }
}