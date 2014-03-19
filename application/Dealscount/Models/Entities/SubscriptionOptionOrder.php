<?php

namespace Dealscount\Models\Entities;

/**
 * @Entity 
 * @Table(name="subscription_options_order")
 */
class SubscriptionOptionOrder {

    /**
     * @Id  @Column(type="integer")
     * @GeneratedValue
     */
    private $id_option_order;

    /**
     * @ManyToOne(targetEntity="Company",inversedBy="option_orders")
     * @JoinColumn(name="id_company", referencedColumnName="id_company" ,onDelete="CASCADE")
     */
    protected $company;

    /**
     * @OneToOne(targetEntity="Invoice",cascade={"persist"})
     * @JoinColumn(name="id_invoice", referencedColumnName="id_invoice")
     */
    protected $invoice;

    /**
     * @ManyToOne(targetEntity="SubscriptionOption")
     * @JoinColumn(name="id_option", referencedColumnName="id_option")
     */
    private $option;

    /**
     * @Column(type="integer") @var string
     */
    protected $quantity;

    /**
     * @Column(type="integer") @var string
     */
    protected $id_option;

    /**
     * @Column(type="string") @var string
     */
    protected $payment_method;

    /**
     * @Column(type="string") @var string
     * statusurile by default sunt: F(finalizat), W(waiting), C(anulat),R(refund)
     */
    protected $payment_status = "W";

    /**
     * @Column(type="string",nullable=true) @var string
     */
    protected $free = 0;

    /**
     * @Column(type="float") @var float
     */
    protected $total;

    /**
     * @Column(type="datetime") @var float
     */
    protected $orderedOn;

    /**
     * @Column(type="string",nullable=true)
     */
    protected $order_number;

    /**
     * @Column(type="datetime",nullable=true) @var string
     */
    protected $used_at;

    /**
     * @Column(type="integer",nullable=true) @var string
     */
    protected $used;

    /**
     * Salvam cum s a folosit aceasta optiune
     * @Column(type="string",nullable=true) @var string
     */
    protected $used_on;

    /**
     * @Column(type="integer",nullable=true) @var string
     */
    protected $id_company;

    public function __construct() {
        $this->orderedOn = new \DateTime("now");
    }

    public function getId_option_order() {
        return $this->id_option_order;
    }

    /**
     * 
     * @return \Dealscount\Models\Entities\Company
     */
    public function getCompany() {
        return $this->company;
    }

    public function getInvoice() {
        return $this->invoice;
    }

    /**
     * 
     * @return \Dealscount\Models\Entities\SubscriptionOption
     */
    public function getOption() {
        return $this->option;
    }

    public function getPayment_method() {
        return $this->payment_method;
    }

    public function getPayment_status() {
        return $this->payment_status;
    }

    public function getFree() {
        return $this->free;
    }

    public function getTotal() {
        return $this->total;
    }

    public function getOrderedOn() {
        return $this->orderedOn;
    }

    public function getOrder_number() {
        return $this->order_number;
    }

    public function setId_option_order($id_option_order) {
        $this->id_option_order = $id_option_order;
        return $this;
    }

    public function setCompany($company) {
        $this->company = $company;
        return $this;
    }

    public function setInvoice($invoice) {
        $this->invoice = $invoice;
        return $this;
    }

    public function setOption($option) {
        $this->option = $option;
        return $this;
    }

    public function setPayment_method($payment_method) {
        $this->payment_method = $payment_method;
        return $this;
    }

    public function setPayment_status($payment_status) {
        $this->payment_status = $payment_status;
        return $this;
    }

    public function setFree($free) {
        $this->free = $free;
        return $this;
    }

    public function setTotal($total) {
        $this->total = $total;
        return $this;
    }

    public function setOrderedOn($orderedOn) {
        $this->orderedOn = $orderedOn;
        return $this;
    }

    public function setOrder_number($order_number) {
        $this->order_number = $order_number;
        return $this;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
        return $this;
    }

    public function getUsed_at() {
        return $this->used_at;
    }

    public function setUsed_at($used_at) {
        $this->used_at = $used_at;
        return $this;
    }

    public function getUsed() {
        return $this->used;
    }

    public function setUsed($used) {
        $this->used = $used;
        return $this;
    }

    public function getUsed_on() {
        return $this->used_on;
    }

    public function setUsed_on($used_on) {
        $this->used_on = $used_on;
        return $this;
    }

    public function getId_option() {
        return $this->id_option;
    }

    public function setId_option($id_option) {
        $this->id_option = $id_option;
        return $this;
    }

    public function getId_company() {
        return $this->id_company;
    }

    public function setId_company($id_company) {
        $this->id_company = $id_company;
        return $this;
    }


}

?>
