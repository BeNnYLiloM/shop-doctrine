<?php

/**
 * @Entity
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
     * @OneToMany(targetEntity="Order", mappedBy="id")
     */
    protected $orderId;

    /**
     * @ManyToOne(targetEntity="Product")
     */
    protected $productId;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->orderId = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Add orderId
     *
     * @param \Order $orderId
     * @return OrderProduct
     */
    public function addOrderId(\Order $orderId)
    {
        $this->orderId[] = $orderId;

        return $this;
    }

    /**
     * Remove orderId
     *
     * @param \Order $orderId
     */
    public function removeOrderId(\Order $orderId)
    {
        $this->orderId->removeElement($orderId);
    }

    /**
     * Get orderId
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Set productId
     *
     * @param \Product $productId
     * @return OrderProduct
     */
    public function setProductId(\Product $productId = null)
    {
        $this->productId = $productId;

        return $this;
    }

    /**
     * Get productId
     *
     * @return \Product 
     */
    public function getProductId()
    {
        return $this->productId;
    }
}
