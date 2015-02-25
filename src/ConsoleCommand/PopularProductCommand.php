<?php

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PopularProductCommand extends \ConsoleCommand\CommandWithEntityManager
{
    protected function configure()
    {
        $this
            ->setName('Product:popular')
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
            $dql = "SELECT op, p, o, count(p) FROM OrderProduct op JOIN op.order o JOIN op.product p WHERE o.created > :dateFrom AND o.created < :dateTo GROUP BY op.product";

            $query = $this->em->createQuery($dql)->setParameter('dateFrom', date('Y-m-d', strtotime($input->getArgument('date-from'))) . ' 00:00:00')
                                                 ->setParameter('dateTo', date('Y-m-d', strtotime($input->getArgument('date-to'))) . ' 23:59:59');
            $result = $query->getResult();

            $popular = 0;
            for ($i = 0; $i <= (count($result) - 1); $i++) {
                if ($result[$i][1] > $popular) {
                    $popular = $i;
                }
            }

            $popularProduct = $result[$popular];
            $output->writeln('<info>The most popular product: ' . $popularProduct[0]->getProduct()->getName() . '</info>');
        } else {
            $qb = $this->em->createQueryBuilder();

            $qb->select('op', 'p', 'o', 'count(p)')
                ->from('OrderProduct', 'op')
                ->join('op.order', 'o')
                ->join('op.product', 'p')
                ->where('o.created > :dateFrom')
                ->andWhere('o.created < :dateTo')
                ->setParameter('dateFrom', date('Y-m-d', strtotime($input->getArgument('date-from'))) . ' 00:00:00')
                ->setParameter('dateTo', date('Y-m-d', strtotime($input->getArgument('date-to'))) . ' 23:59:59')
                ->groupBy('op.product');

            $query = $qb->getQuery();
            $result = $query->getResult();

            $popular = 0;
            for ($i = 0; $i <= (count($result) - 1); $i++) {
                if ($result[$i][1] > $popular) {
                    $popular = $i;
                }
            }

            $popularProduct = $result[$popular];
            $output->writeln('<info>The most popular product: ' . $popularProduct[0]->getProduct()->getName() . '</info>');
        }
    }
}