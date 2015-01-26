<?php

require_once "main.php";

$nameProduct = $argv[1];
$priceProduct = $argv[2];

$product = new Product();
$product->setName($nameProduct);
$product->setPrice($priceProduct);

$entityManager->persist($product);
$entityManager->flush();

echo "Product by name: ".$product->getName()." was created. Product id: ".$product->getId().". Product price: ".$product->getPrice().".\n";