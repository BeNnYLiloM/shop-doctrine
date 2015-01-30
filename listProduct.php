<?php

require_once "main.php";

$productRepository = $entityManager->getRepository('Product');
$products = $productRepository->findAll();

foreach($products as $product) {
    echo sprintf("%s (ID product '%d' price of %d rub. Amount product '%d')\n", $product->getName(), $product->getId(), $product->getPrice(), $product->getAmount());
}