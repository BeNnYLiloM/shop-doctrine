<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;

class AddOrderProductCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('Product:order')
            ->addArgument(
                'product-id',
                InputArgument::REQUIRED,
                'Product ID you want to add to your cart.'
            )
            ->addArgument(
                'amount',
                InputArgument::REQUIRED,
                'Amount of goods.'
            )
            ->addArgument(
                'order-id',
                InputArgument::OPTIONAL,
                'ID of your order.'
            )
        ;
    }

    public function execute(InputInterface $input)
    {
        if($input->getArgument('order-id')){
            $order = $GLOBALS['entityManager']->find('Order', $input->getArgument('order-id'));
            if($order){
                $product = $GLOBALS['entityManager']->find('Product', $input->getArgument('product-id'));

                $cart = new OrderProduct();
                $cart->setOrder($order);
                $cart->setProduct($product);
                $cart->setCount($input->getArgument('amount'));

                $GLOBALS['entityManager']->persist($cart);
                $GLOBALS['entityManager']->flush();
            } else {
                echo "Order with ID: '".$input->getArgument('order-id')."' not found!\n";
                die;
            }
        } else {
            $newOrder = new Order();
            $newOrder->setCreated(new DateTime('now'));

            $GLOBALS['entityManager']->persist($newOrder);
            $GLOBALS['entityManager']->flush();

            $orderId = $newOrder->getId();

            $product = $GLOBALS['entityManager']->find('Product', $input->getArgument('product-id'));
            if($product == false){
                echo 'Not found product by id `'.$input->getArgument('product-id')."\n";
                die;
            }

            $cart = new OrderProduct();
            $cart->setOrder($newOrder);
            $cart->setProduct($product);
            $cart->setCount($input->getArgument('amount'));

            $GLOBALS['entityManager']->persist($cart);
            $GLOBALS['entityManager']->flush();
        }
    }
}