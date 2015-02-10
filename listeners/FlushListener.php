<?php

class FlushListener
{
    public function onFlush(\Doctrine\ORM\Event\OnFlushEventArgs $eventArgs)
    {
        $em = $eventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();

        foreach($uow->getScheduledEntityInsertions() as $entity) {
            if($entity instanceof OrderProduct) {
                $order = $em->find('Order', $entity->getOrder()->getId());
                $total = $order->getTotal();
                $sum = $total + $entity->getProduct()->getPrice();
                $order->setTotal($sum);
                $em->persist($order);
                $uow->computeChangeSet($em->getClassMetadata('Order'), $order);
            }
        }

        foreach ($uow->getScheduledEntityDeletions() as $entity) {
            if($entity instanceof OrderProduct) {
                $order = $em->find('Order', $entity->getOrder()->getId());
                $total = $order->getTotal();
                $sum = $total - $entity->getProduct()->getPrice();
                $order->setTotal($sum);
                $em->persist($order);
                $uow->computeChangeSet($em->getClassMetadata('Order'), $order);
            }
        }

    }
}