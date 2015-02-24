<?php

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class DelOrderProductCommand extends \ConsoleCommand\CommandWithEntityManager
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
            $orderProduct = $this->em->find('OrderProduct', $input->getArgument('order-product-id'));
            if($orderProduct){
                $this->em->remove($orderProduct);
                $this->em->flush();
            } else {
                $output->writeln('<error>Product with ID `'.$input->getArgument('order-product-id').'` was not found in your shopping cart</error>');
                die;
            }
        }
    }
}