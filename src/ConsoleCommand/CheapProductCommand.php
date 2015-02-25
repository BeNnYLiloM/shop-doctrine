<?php

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
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
            ->addOption(
                'dql',
                null,
                InputOption::VALUE_NONE,
                'DQL query'
            )
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        if($input->getOption('dql')){
            $dql = "SELECT op, o, p FROM OrderProduct op JOIN op.order o JOIN op.product p WHERE o.created > :dateFrom AND o.created < :dateTo ORDER BY p.price ASC";

            $query = $this->em->createQuery($dql)->setParameter('dateFrom', date('Y-m-d', strtotime($input->getArgument('date-from'))).' 00:00:00')
                ->setParameter('dateTo', date('Y-m-d', strtotime($input->getArgument('date-to'))).' 23:59:59')
                ->setMaxResults(10);
            $result = $query->getResult();

            $output->writeln('<info>List expensive to product:</info>');
            $nameProduct = '';
            foreach ($result as $product) {
                if($nameProduct == $product->getProduct()->getName()){
                    continue;
                }
                $nameProduct = $product->getProduct()->getName();
                $output->writeln('<info>Name: '.$product->getProduct()->getName().'. Price: '.$product->getProduct()->getPrice().'</info>');
            }
        } else {
            $qb = $this->em->createQueryBuilder();

            $qb->select('op', 'o', 'p')
                ->from('OrderProduct', 'op')
                ->join('op.order', 'o')
                ->join('op.product', 'p')
                ->where('o.created > :dateFrom')
                ->andWhere('o.created < :dateTo')
                ->setParameter('dateFrom', date('Y-m-d', strtotime($input->getArgument('date-from'))).' 00:00:00')
                ->setParameter('dateTo', date('Y-m-d', strtotime($input->getArgument('date-to'))).' 23:59:59')
                ->orderBy('p.price', 'asc')
                ->setMaxResults(10);

            $query = $qb->getQuery();
            $result = $query->getResult();

            $output->writeln('<info>List cheap to product:</info>');
            $nameProduct = '';
            foreach ($result as $product) {
                if($nameProduct == $product->getProduct()->getName()){
                    continue;
                }
                $nameProduct = $product->getProduct()->getName();
                $output->writeln('<info>Name: '.$product->getProduct()->getName().'. Price: '.$product->getProduct()->getPrice().'</info>');
            }
        }
    }
}