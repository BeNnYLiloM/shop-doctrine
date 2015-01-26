<?php

require_once "main.php";

$productRepository = $entityManager->getRepository('Product');
$products = $productRepository->findAll();

foreach($products as $product) {
    echo sprintf("-%s price of %d rub.\n", $product->getName(), $product->getPrice());
}