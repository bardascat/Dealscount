<?php

namespace Dealscount\Models\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity 
 * @Table(name="orders_items")
 */
class OrderItem extends AbstractEntity {

    /**
     *
     * @Id  @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     *
     * @Column(type="integer")
     */
    protected $id_order;

    /**
     *
     * @Column(type="integer")
     */
    protected $id_item;

    /**
     * @ManyToOne(targetEntity="Order",inversedBy="orderItems")
     * @JoinColumn(name="id_order", referencedColumnName="id_order" ,onDelete="CASCADE")
     */
    private $order;

    /**
     * @ManyToOne(targetEntity="Item")
     * @JoinColumn(name="id_item", referencedColumnName="id_item")
     */
    private $item;

    /** @OneToMany(targetEntity="OrderVoucher", mappedBy="orderItem",cascade={"persist"}) */
    private $vouchers;

    /**
     * @Column(type="integer")
     */
    protected $quantity;

    /**
     * @Column(type="integer")
     */
    protected $total;

    /**
     * W = wating
     * F = finalizat
     * C - anulat
     * @Column(type="string")
     */
    protected $status = "F";


    function __construct() {
        $this->vouchers = new ArrayCollection();
    }

    public function setOrder(Order $order) {
        $this->order = $order;
    }

    /**
     * 
     * @return \NeoMvc\Models\Entity\Order
     */
    public function getOrder() {
        return $this->order;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function setTotal($total) {
        $this->total = $total;
    }

    public function getTotal() {
        return $this->total;
    }

    public function setItem(Item $item) {
        $this->item = $item;
    }

    /**
     * 
     * @return \Dealscount\Models\Entities\Item
     */
    public function getItem() {
        return $this->item;
    }

    public function addVoucher(OrderVoucher $voucher) {
        $this->vouchers->add($voucher);
        $voucher->setOrderItem($this);
    }

    /**
     * 
     * @return \Dealscount\Models\Entities\OrderVoucher
     */
    public function getVouchers() {
        return $this->vouchers;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }


    public function getId_order() {
        return $this->id_order;
    }

    public function setId_order($id_order) {
        $this->id_order = $id_order;
    }

    public function getId_item() {
        return $this->id_item;
    }

    public function setId_item($id_item) {
        $this->id_item = $id_item;
    }

   
}

?>
