<?php

/**
 * @Entity @Table(name="orders")
 */
class Order
{
    /**
     * @Id @Column(type="integer") @GeneratedValue
     */
    protected $id;
    /**
     * @Column(type="string")
     */
    protected $orderProducts;
    /**
     * @Column(type="string")
     */
    protected $orderAmount;

    public function getId()
    {
        return $this->id;
    }

    public function getOrderProducts()
    {
        return $this->orderProducts;
    }

    public function getOrderAmount()
    {
        return $this->orderAmount;
    }
}