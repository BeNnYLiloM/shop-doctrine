<?php

/**
 * @Entity
 * @Table(name="userOrder")
 * @HasLifecycleCallbacks
 */
class UserOrder
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="id")
     */
    protected $userId;

    /**
     * @ManyToOne(targetEntity="Product")
     */
    protected $product;

    /**
     * @Column(type="integer")
     */
    protected $amount;

    /**
     * @Column(type="decimal", scale=2)
     */
    protected $total;

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
     * Set amount
     *
     * @param integer $amount
     * @return UserOrder
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return integer 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set userId
     *
     * @param \User $userId
     * @return UserOrder
     */
    public function setUserId(\User $userId = null)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return \User 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set product
     *
     * @param \Product $product
     * @return UserOrder
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
     * Set total
     *
     * @param string $total
     * @return UserOrder
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @PrePersist
     */
    public function doStuffOnPrePersist($total)
    {
        $dql = "SELECT u, t FROM UserOrder u ";
        $this->total = $total;
    }

    /**
     * Get total
     *
     * @return string 
     */
    public function getTotal()
    {
        return $this->total;
    }
}
