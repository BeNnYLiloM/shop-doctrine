<?php

/**
 * @Entity(repositoryClass="OrderProductRepository")
 * @Table(name="orderProduct")
 */
class OrderProduct
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="Order")
     */
    protected $order;

    /**
     * @ManyToOne(targetEntity="Product")
     */
    protected $product;

    /**
     * @Column(type="integer")
     */
    protected $count;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set order
     *
     * @param \Order $order
     * @return OrderProduct
     */
    public function setOrder(\Order $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \Order 
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set product
     *
     * @param \Product $product
     * @return OrderProduct
     */
    public function setProduct(\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Product 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set amount
     *
     * @param integer $amount
     * @return OrderProduct
     */
    public function setCount($count)
    {
        $this->amount = $count;

        return $this;
    }

    /**
     * Get amount
     *
     * @return integer 
     */
    public function getCount()
    {
        return $this->count;
    }
}
