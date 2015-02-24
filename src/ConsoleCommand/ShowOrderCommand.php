<?php

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;

class ShowOrderCommand extends \ConsoleCommand\CommandWithEntityManager
{
    protected function configure()
    {
        $this
            ->setName('Order:show')
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
            $orderId = $input->getArgument('order-id');

            $order = $this->em->getRepository('Order')->getOneOrder($orderId);
            if(!$order){
                echo "ID of the order is not found!\n";
                die;
            }
            foreach ($order as $entity) {
                echo "ID of your order: ".$entity->getId().". Amount of your order: ".$entity->getTotal()."\n";
            }
        } else {
            $orders = $this->em->getRepository('Order')->getAllOrders();
            foreach($orders as $entity) {
                echo 'ID of order: '.$entity->getId().'. Amount of order: '.$entity->getTotal()."\n";
            }
        }
    }
}