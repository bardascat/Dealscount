<?php

namespace Dealscount\Models\Entities;

/**
 * @Entity 
 * @Table(name="neocart")
 */
class NeoCart {

    /**
     *
     * @Id  @Column(type="integer")
     * @GeneratedValue
     */
    private $id_cart;

    /**
     * @Column(type="string") @var string 
     */
    private $hash;

    /**
     *
     * @Column(type="datetime") @var float
     */
    private $createdDate;

    /**
     * @OneToMany(targetEntity="CartItem",mappedBy="NeoCart",cascade={"persist"})
     * @var Collection
     * @OrderBy({"id" = "desc"})
     */
    private $CartItems;

    public function __construct() {
        $this->createdDate = new \DateTime("now");
        $this->CartItems = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getCreatedDate() {
        return $this->createdDate->format("d-m-Y");
    }

    public function getId_cart() {
        return $this->id_cart;
    }

    public function setId_cart($id_cart) {
        $this->id_cart = $id_cart;
    }

    public function getHash() {
        return $this->hash;
    }

    public function setHash($hash) {
        $this->hash = $hash;
    }

    /**
     * 
     * @return \Dealscount\Models\Entities\CartItem
     */
    public function getCartItems() {
        return $this->CartItems;
    }

    public function addCartItem(CartItem $CartItems) {
        $CartItems->setNeoCart($this);
        $this->CartItems->add($CartItems);
    }

}

?>
