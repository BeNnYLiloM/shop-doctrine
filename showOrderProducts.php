<?php

require_once 'main.php';

if(count($argv) == 1) {
    $cart = $entityManager->getRepository('OrderProduct')->getListAllProducts();

    foreach ($cart as $entity) {
        echo 'ID table entry '.$entity->getId().":
  ID of order: ".$entity->getOrder()->getId()."
  Product name: ".$entity->getProduct()->getName()."
  Amount product: ".$entity->getProduct()->getPrice()."
  Count: ".$entity->getCount()."\n\n";
    }
} elseif(count($argv) == 2) {
    $orderId = $argv[1];

    $cart = $entityManager->getRepository('OrderProduct')->getListProductByOrderId($orderId);
    if(!$cart) {
        echo "ID does not exist.\n";
        die;
    }
    foreach ($cart as $entity) {
        echo $entity->getId().' - '.$entity->getProduct()->getName().'. Amount: '.$entity->getProduct()->getPrice()."\n";
    }
}