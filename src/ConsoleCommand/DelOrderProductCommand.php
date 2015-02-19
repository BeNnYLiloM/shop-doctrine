<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class DelOrderProductCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('Product:del')
            ->addArgument(
                'order-product-id',
                InputArgument::REQUIRED,
                'ID of the record in the table OrderProduct.'
            )
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        if($input->getArgument('order-product-id')){
            $orderProduct = $GLOBALS['entityManager']->find('OrderProduct', $input->getArgument('order-product-id'));
            if($orderProduct){
                $GLOBALS['entityManager']->remove($orderProduct);
                $GLOBALS['entityManager']->flush();
            } else {
                echo "Product with ID `".$input->getArgument('order-product-id')."` was not found in your shopping cart.\n";
                die;
            }
        }
    }
}