<?php

/**
 * @Entity(repositoryClass="OrderRepository")
 * @Table(name="check_order")
 */
class Order
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @Column(type="decimal", scale=2, options={"default":0})
     */
    protected $total = 0;

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
     * Set total
     *
     * @param total $total
     * @return Order
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
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
