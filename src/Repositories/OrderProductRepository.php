<?php

use Doctrine\ORM\EntityRepository;

class OrderProductRepository extends EntityRepository
{
    public function getListProductByOrderId($orderId)
    {
        $dql = "SELECT op FROM OrderProduct op WHERE op.order = $orderId";
        $query = $this->getEntityManager()->createQuery($dql);

        return $query->getResult();
    }

    public function getListAllProducts($max = 30)
    {
        $dql = "SELECT op FROM OrderProduct op";
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setMaxResults($max);

        return $query->getResult();
    }
}