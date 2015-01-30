<?php

require_once "main.php";

$nameProduct = $argv[1];
$priceProduct = $argv[2];
$amountProduct = $argv[3];

$product = new Product();
$product->setName($nameProduct);
$product->setPrice($priceProduct);
$product->setAmount($amountProduct);

$entityManager->persist($product);
$entityManager->flush();

echo "Product by name: ".$product->getName()." was created. Product id: "
    .$product->getId().". Product price: ".$product->getPrice().". Amount product: ".$product->getAmount()."\n";