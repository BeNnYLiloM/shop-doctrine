<?php

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity @Table(name="orders")
 */
class Order
{
    /**
     * @Id @Column(name="order_id", type="integer") @GeneratedValue
     */
    protected $order_id;
    /**
     * @Column(type="string")
     * @ManyToOne(targetEntity="Product", inversedBy="product_id")
     */
    protected $orderProducts;
    /**
     * @Column(type="string")
     */
    protected $orderAmount;

    public function __construct()
    {
        $this->orderProducts = new ArrayCollection();
    }

    public function getId()
    {
        return $this->order_id;
    }

    public function getOrderProducts()
    {
        return $this->orderProducts;
    }

    public function setOrderProducts($orderProductsId)
    {
        $this->orderProducts = $orderProductsId;
    }

    public function getOrderAmount()
    {
        return $this->orderAmount;
    }

    public function setOrderAmount($orderProductsPrice)
    {
        $this->orderAmount = $orderProductsPrice;
    }
}