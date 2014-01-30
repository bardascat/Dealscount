<?php

namespace Dealscount\Models\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity 
 * @Table(name="invoices")
 */
class Invoice extends AbstractEntity {

    /**
     * @Id  @Column(type="integer")
     * @GeneratedValue
     */
    protected $id_invoice;

    /**
     *
     * @Column(type="datetime")
     */
    protected $generate_date;


    /**
     * @Column(type="integer")
     */
    protected $number;

    /**
     * @Column(type="date") @var date 
     */
    protected $term_date;

    /**
     * @Column(type="float") @var string 
     */
    protected $total;
    /**
     * @Column(type="float") @var string 
     */
    protected $shipping_cost;

    /**
     * @Column(type="float") @var string 
     */
    protected $tva;

    /**
     * @Column(type="string") @var string 
     */
    protected $series;

    /**
     * 0 incative
     * 1 active
     * @Column(type="integer") @var string 
     */
    protected $active = 1;

    /**
     * @ManyToOne(targetEntity="User",inversedBy="invoices")
     * @JoinColumn(name="id_user", referencedColumnName="id_user")
     */
    protected $user;

    /**
     *
     * @Column(type="text")
     */
    protected $products;

    function __construct() {
        $this->generate_date = new \DateTime("now");
    }

    public function getId_invoice() {
        return $this->id_invoice;
    }

    public function setId_invoice($id_invoice) {
        $this->id_invoice = $id_invoice;
    }

    public function getGenerate_date() {
        return $this->generate_date;
    }

    public function setGenerate_date($generate_date) {
        $this->generate_date = $generate_date;
    }

    public function getTotal() {
        return $this->total;
    }

    public function setTotal($total) {
        $this->total = $total;
    }

    public function getTva() {
        return $this->tva;
    }

    public function setTva($tva) {
        $this->tva = $tva;
    }

    
    public function getNumber() {
        return $this->number;
    }

    public function setNumber($number) {
        $this->number = $number;
    }

    public function getTerm_date() {
        return $this->term_date;
    }

    public function setTerm_date($term_date) {
        $this->term_date = $term_date;
    }

    public function getSeries() {
        return $this->series;
    }

    public function setSeries($series) {
        $this->series = $series;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function getProducts() {
        return $this->products;
    }

    public function setProducts($products) {
        $this->products = $products;
    }

    public function getActive() {
        return $this->active;
    }

    public function setActive($active) {
        $this->active = $active;
    }
 
    public function getShipping_cost() {
        return $this->shipping_cost;
    }

    public function setShipping_cost($shipping_cost) {
        $this->shipping_cost = $shipping_cost;
    }




}

?>
