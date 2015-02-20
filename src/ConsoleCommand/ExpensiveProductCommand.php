<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;

class ExpensiveProductCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('Product:expensive')
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

    public function execute(InputInterface $input)
    {
        if($input->getArgument('date-from') && $input->getArgument('date-to')){
            $qb = $GLOBALS['entityManager']->createQueryBuilder();
            $qb->select('o')
                ->from('Order', 'o');
//                ->where('o.created > '.date('Y-m-d H:i:s', strtotime($input->getArgument('date-from'))))
//                ->andWhere('o.created < '.date('Y-m-d H:i:s', strtotime($input->getArgument('date-to'))));

            $dql = $qb->getDQL();
            $query = $GLOBALS['entityManager']->createQuery($dql);
            $result = $query->getResult();
            echo 'True';
        } else {

        }
    }
}