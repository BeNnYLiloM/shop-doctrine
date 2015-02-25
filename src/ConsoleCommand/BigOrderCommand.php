<?php

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
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
            $dql = "SELECT op, o, count(op) FROM OrderProduct op JOIN op.order o WHERE o.created > :dateFrom AND o.created < :dateTo GROUP BY op.order";

            $query = $this->em->createQuery($dql)->setParameter('dateFrom', date('Y-m-d', strtotime($input->getArgument('date-from'))) . ' 00:00:00')
                                                 ->setParameter('dateTo', date('Y-m-d', strtotime($input->getArgument('date-to'))) . ' 23:59:59');
            $result = $query->getResult();

            $big = 0;
            for ($i = 0; $i <= (count($result) - 1); $i++) {
                if ($result[$i][1] > $big) {
                    $big = $i;
                }
            }

            $bigOrder = $result[$big];
            $output->writeln('<info>ID of big order: ' . $bigOrder[0]->getOrder()->getId() . '</info>');

            $dql = "SELECT op FROM OrderProduct op WHERE op.order = :bigOrderId";

            $query = $this->em->createQuery($dql)->setParameter('bigOrderId', $bigOrder[0]->getOrder()->getId());
            $result = $query->getResult();

            $output->writeln('<info>List of order product:</info>');
            foreach ($result as $entity) {
                $output->writeln('<info> - ' . $entity->getProduct()->getName() . '</info>');
            }
        } else {
            $qb = $this->em->createQueryBuilder();

            $qb->select('op', 'o', 'count(op)')
                ->from('OrderProduct', 'op')
                ->join('op.order', 'o')
                ->where('o.created > :dateFrom')
                ->andWhere('o.created < :dateTo')
                ->setParameter('dateFrom', date('Y-m-d', strtotime($input->getArgument('date-from'))) . ' 00:00:00')
                ->setParameter('dateTo', date('Y-m-d', strtotime($input->getArgument('date-to'))) . ' 23:59:59')
                ->groupBy('op.order');

            $query = $qb->getQuery();
            $result = $query->getResult();

            $big = 0;
            for ($i = 0; $i <= (count($result) - 1); $i++) {
                if ($result[$i][1] > $big) {
                    $big = $i;
                }
            }

            $bigOrder = $result[$big];
            $output->writeln('<info>ID of big order: ' . $bigOrder[0]->getOrder()->getId() . '</info>');

            $qbs = $this->em->createQueryBuilder();
            $qbs->select('op')
                ->from('OrderProduct', 'op')
                ->where('op.order = :bigOrderId')
                ->setParameter('bigOrderId', $bigOrder[0]->getOrder()->getId());

            $query = $qbs->getQuery();
            $result = $query->getResult();

            $output->writeln('<info>List of order product:</info>');
            foreach ($result as $entity) {
                $output->writeln('<info> - ' . $entity->getProduct()->getName() . '</info>');
            }
        }
    }
}