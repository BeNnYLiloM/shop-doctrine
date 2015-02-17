<?php

use Doctrine\ORM\EntityRepository;

class OrderRepository extends EntityRepository
{
    public function getOneOrder($id)
    {
        $dql = "SELECT o FROM Order o WHERE o.id = :id";
        $query = $this->getEntityManager()->createQuery($dql)->setParameter('id', $id);

        return $query->getResult();
    }

    public function getAllOrders($max = 15)
    {
        $dql = "SELECT o FROM Order o";
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setMaxResults($max);

        return $query->getResult();
    }
}
