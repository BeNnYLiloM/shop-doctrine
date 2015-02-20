<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;

class ShowOrderProductCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('Show:orderProduct')
            ->addArgument(
                'id-order',
                InputArgument::OPTIONAL,
                'ID of your order.'
            )
        ;
    }

    public function execute(InputInterface $input)
    {
        if(!$input->getArgument('id-order')){
            $cart = $GLOBALS['entityManager']->getRepository('OrderProduct')->getListAllProducts();

            foreach ($cart as $entity) {
                echo "
ID table entry " . $entity->getId() . ":
  ID of order: " . $entity->getOrder()->getId() . "
  Product name: " . $entity->getProduct()->getName() . "
  Amount product: " . $entity->getProduct()->getPrice() . "
  Count: " . $entity->getCount() . "\n\n";
            }
        } else {
            $orderId = $input->getArgument('id-order');

            $cart = $GLOBALS['entityManager']->getRepository('OrderProduct')->getListProductByOrderId($orderId);
            if(!$cart) {
                echo "ID does not exist.\n";
                die;
            }
            foreach ($cart as $entity) {
                echo $entity->getId().' - '.$entity->getProduct()->getName().'. Amount: '.$entity->getProduct()->getPrice()."\n";
            }
        }
    }
}