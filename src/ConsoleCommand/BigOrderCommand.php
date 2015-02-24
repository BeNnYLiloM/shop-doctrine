<?php

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

class BigOrderCommand extends \ConsoleCommand\CommandWithEntityManager
{
    protected function configure()
    {
        $this
            ->setName('Order:big')
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
        $qb = $this->em->createQueryBuilder();

        $qb->select('op', 'o', 'p', 'count(p)')
            ->from('OrderProduct', 'op')
            ->join('op.order', 'o')
            ->join('op.product', 'p')
            ->where("o.created > :dateFrom")
            ->andWhere("o.created < :dateTo")
            ->setParameter('dateFrom', date('Y-m-d', strtotime($input->getArgument('date-from'))).' 00:00:00')
            ->setParameter('dateTo', date('Y-m-d', strtotime($input->getArgument('date-to'))).' 23:59:59')
            ->groupBy('op.order');

        $query = $qb->getQuery();
        $result = $query->getResult();

        $big = 0;
        for($i = 0;$i <= (count($result) - 1); $i++){
            if($result[$i][1] > $big){
                $big = $i;
            }
        }

        $bigOrder = $result[$big];
        $output->writeln('<info>ID of big order: '.$bigOrder[0]->getOrder()->getId().'</info>');

        $qbs = $this->em->createQueryBuilder();
        $qbs->select('op')
            ->from('OrderProduct', 'op')
            ->where('op.order = :bigOrderId')
            ->setParameter('bigOrderId', $bigOrder[0]->getOrder()->getId());

        $query = $qbs->getQuery();
        $result = $query->getResult();

         $output->writeln('<info>List of order product:</info>');
        foreach ($result as $entity) {
            $output->writeln('<info> - '.$entity->getProduct()->getName().'</info>');
        }
    }
}