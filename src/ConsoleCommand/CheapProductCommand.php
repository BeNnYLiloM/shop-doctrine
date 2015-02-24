<?php

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class CheapProductCommand extends \ConsoleCommand\CommandWithEntityManager
{
    protected function configure()
    {
        $this
            ->setName('Product:cheap')
            ->addArgument(
                'date-from',
                InputArgument::REQUIRED,
                'The date from which you want to display data.'
            )
            ->addArgument(
                'date-to',
                InputArgument::REQUIRED,
                'The date to which you want to display data.'
            )
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        if($input->getArgument('date-from') && $input->getArgument('date-to')){
            $qb = $this->em->createQueryBuilder();

            $qb->select('op', 'o', 'p')
                ->from('OrderProduct', 'op')
                ->join('op.order', 'o')
                ->join('op.product', 'p')
                ->where("o.created > '".date('Y-m-d', strtotime($input->getArgument('date-from')))." 00:00:00'")
                ->andWhere("o.created < '".date('Y-m-d', strtotime($input->getArgument('date-to')))." 23:59:59'")
                ->orderBy('p.price', 'asc')
                ->setMaxResults(10);

            $query = $qb->getQuery();
            $result = $query->getResult();

            $output->writeln('<info>List cheap to product:</info>');
            foreach ($result as $product) {
                $output->writeln('<info>Name: '.$product->getProduct()->getName().'. Price: '.$product->getProduct()->getPrice().'</info>');
            }
        } else {

        }
    }
}