<?php

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class AddOrderProductCommand extends \ConsoleCommand\CommandWithEntityManager
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

    public function execute(InputInterface $input, OutputInterface $output)
    {
        if($input->getArgument('order-id')){
            $order = $this->em->find('Order', $input->getArgument('order-id'));
            if($order){
                $product = $this->em->find('Product', $input->getArgument('product-id'));

                $cart = new OrderProduct();
                $cart->setOrder($order);
                $cart->setProduct($product);
                $cart->setCount($input->getArgument('amount'));

                $this->em->persist($cart);
                $this->em->flush();
            } else {
                $output->writeln('<error>Order with ID: '.$input->getArgument('order-id').' not found!</error>');
                die;
            }
        } else {
            $product = $this->em->find('Product', $input->getArgument('product-id'));
            if($product == false){
                $output->writeln('<error>Not found product by id `'.$input->getArgument('product-id').'`</error>');
                die;
            }

            $newOrder = new Order();
            $newOrder->setCreated(new DateTime('now'));

            $this->em->persist($newOrder);
            $this->em->flush();

            $cart = new OrderProduct();
            $cart->setOrder($newOrder);
            $cart->setProduct($product);
            $cart->setCount($input->getArgument('amount'));

            $this->em->persist($cart);
            $this->em->flush();
        }
    }
}