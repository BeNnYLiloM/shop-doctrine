<?php

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity @Table(name="products")
 */
class Product
{
    /**
     * @Id @Column(name="product_id", type="integer") @GeneratedValue
     * @OneToMany(targetEntity="Order", mappedBy="order_id")
     */
    protected $product_id;
    /**
     * @Column(type="string")
     */
    protected $name;
    /**
     * @Column(type="integer")
     */
    protected $price;

    public function _construct()
    {
        $this->product_id = new ArrayCollection();
    }

    public function getId()
    {
        return $this->product_id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }
}