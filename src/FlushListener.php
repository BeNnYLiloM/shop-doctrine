<?php

class FlushListener
{
    public function onFlush(\Doctrine\ORM\Event\OnFlushEventArgs $eventArgs)
    {
        $em = $eventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();
        $total = 0;
        $classMetadata = new \Doctrine\ORM\Mapping\ClassMetadata($em);

        foreach($uow->getScheduledEntityInsertions() as $entity) {
            $e = $entity->getUserId()->getId();
            $dql = "SELECT u FROM UserOrder u WHERE u.userId = '".$entity->getUserId()->getId()."'";
            $query = $em->createQuery($dql);
            $result = $query->getResult();
            foreach ($result as $userOrder) {
                $total += $userOrder->getTotal();
            }
            $uow->recomputeSingleEntityChangeSet($classMetadata, new UserOrder());
        }
    }
}