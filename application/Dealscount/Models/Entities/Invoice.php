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
     * @Column(type="date",nullable=true) @var date 
     */
    protected $term_date;

    /**
     * @Column(type="float") @var string 
     */
    protected $total;

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
     * @ManyToOne(targetEntity="Company",inversedBy="invoices")
     * @JoinColumn(name="id_company", referencedColumnName="id_company")
     */
    protected $company;

    /**
     *
     * @Column(type="text")
     */
    protected $products;

    /**
     *
     * @Column(type="text")
     */
    protected $comapany_info;

    /**
     *
     * @Column(type="text")
     */
    protected $supplier_info;

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

    /**
     * 
     * @return \Dealscount\Models\Entities\Company
     */
    public function getCompany() {
        return $this->company;
    }

    public function setCompany($company) {
        $this->company = $company;
        return $this;
    }

    public function getComapany_info() {
        return $this->comapany_info;
    }

    public function getSupplier_info() {
        return $this->supplier_info;
    }

    public function setComapany_info($comapany_info) {
        $this->comapany_info = $comapany_info;
        return $this;
    }

    public function setSupplier_info($supplier_info) {
        $this->supplier_info = $supplier_info;
        return $this;
    }

}

?>
