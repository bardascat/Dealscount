<?php

namespace Dealscount\Models\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity 
 * @Table(name="item_variants")
 */
class ItemVariant {

    /**
     *
     * @Id  @Column(type="integer")
     * @GeneratedValue
     */
    private $id_variant;

    /**
     * @Column(type="integer")
     */
    private $id_item;

    /**
     *
     * @Column(type="integer",nullable=true)
     */
    protected $voucher_max_limit;

    /**
     *
     * @Column(type="integer",nullable=true)
     */
    protected $voucher_max_limit_user;

    /**
     * @Column(type="float")
     */
    private $price;

    /**
     * @Column(type="text")
     */
    private $description;

    /**
     * @Column(type="float")
     */
    private $sale_price = 0;

    /**
     * @Column(type="float")
     */
    private $voucher_price;

    /**
     * @Column(type="integer",nullable=true)
     */
    private $active = 1;

    /** @ManyToOne(targetEntity="Item", inversedBy="ItemVariant")
     *  @JoinColumn(name="id_item", referencedColumnName="id_item",onDelete="CASCADE") 
     */
    protected $item;

    /** @OneToMany(targetEntity="AttributeValue", mappedBy="ItemVariant",cascade={"persist"}) */
    protected $attributesValue;

    function __construct() {
        $this->attributesValue = new ArrayCollection();
    }

    public function getId_variant() {
        return $this->id_variant;
    }

    public function setId_variant($id_variant) {
        $this->id_variant = $id_variant;
    }

    public function getId_item() {
        return $this->id_item;
    }

    public function setId_item($id_item) {
        $this->id_item = $id_item;
    }

    public function getActive() {
        return $this->active;
    }

    public function setActive($active) {
        $this->active = $active;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function getVoucher_max_limit() {
        return $this->voucher_max_limit;
    }

    public function getVoucher_max_limit_user() {
        return $this->voucher_max_limit_user;
    }

    public function getSale_price() {
        return $this->sale_price;
    }

    public function setVoucher_max_limit($voucher_max_limit) {
        $this->voucher_max_limit = $voucher_max_limit;
        return $this;
    }

    public function setVoucher_max_limit_user($voucher_max_limit_user) {
        $this->voucher_max_limit_user = $voucher_max_limit_user;
        return $this;
    }

    public function setSale_price($sale_price) {
        $this->sale_price = $sale_price;
        return $this;
    }

    /**
     * Intoarce atributele simple, toate in afara de pret si stoc
     * @return \NeoMvc\Models\Entity\AttributeValue
     */
    function getSimpleAttributes() {
        return $this->attributesValue;
    }

    /**
     * 
     * @return \Dealscount\Models\Entities\AttributeValue
     */
    public function getAttributes() {
        return $this->attributesValue;
    }

    public function addAtributeValue(AttributeValue $attributeValues) {
        $this->attributesValue->add($attributeValues);
        $attributeValues->setItemVariant($this);
    }

    public function getItem() {
        return $this->item;
    }

    public function setItem($item) {
        $this->item = $item;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function getPercentageDiscount() {
        return round(100 - ($this->getVoucher_price() * 100 ) / $this->getPrice());
    }
    public function getVoucher_price() {
        return $this->voucher_price;
    }

    public function setVoucher_price($voucher_price) {
        $this->voucher_price = $voucher_price;
        return $this;
    }



}

?>
