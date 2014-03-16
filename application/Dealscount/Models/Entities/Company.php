<?php

namespace Dealscount\Models\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity 
 * @Table(name="company")
 */
class Company extends AbstractEntity {

    /**
     * @Id  @Column(type="integer")
     * @GeneratedValue
     */
    protected $id_company;

    /**
     *
     * @Column(type="string",nullable=true)
     */
    protected $description;

    /**
     *
     * @Column(type="string",nullable=false)
     */
    protected $company_name;

    /**
     *
     * @Column(type="string",nullable=true)
     */
    protected $commercial_name;

    /**
     *
     * @Column(type="string",nullable=true)
     */
    protected $website;

    /**
     *
     * @Column(type="string",nullable=true)
     */
    protected $phone;

    /**
     *
     * @Column(type="string",nullable=true)
     */
    protected $cif;

    /**
     *
     * @Column(type="string",nullable=true)
     */
    protected $regCom;

    /**
     *
     * @Column(type="string",nullable=true)
     */
    protected $address;

    /**
     *
     * @Column(type="string",nullable=true)
     */
    private $image;

    /**
     *
     * @Column(type="string",nullable=true)
     */
    protected $iban;

    /**
     *
     * @Column(type="string",nullable=true)
     */
    protected $city;

    /**
     *
     * @Column(type="string",nullable=true)
     */
    protected $bank;

    /**
     * @Column(type="string",nullable=true)
     */
    protected $send_order = 0;

    /**
     * @Column(type="date",nullable=true)
     */
    protected $available_from;

    /**
     * @Column(type="date",nullable=true)
     */
    protected $available_to;

    /**
     * default P = Pending
     * @Column(type="string",nullable=true)
     */
    protected $status = "P";

    /**
     * @OneToOne(targetEntity="User",inversedBy="company")
     * @JoinColumn(name="id_user", referencedColumnName="id_user" ,onDelete="CASCADE")
     */
    protected $user;

    /**
     * @OneToMany(targetEntity="SubscriptionOptionOrder",mappedBy="company",cascade={"persist"})
     * @OrderBy({"id_option_order" = "desc"})
     */
    protected $option_orders;

    /**
     * @OneToMany(targetEntity="Invoice",mappedBy="company",cascade={"persist"})
     * @OrderBy({"id_invoice" = "desc"})
     */
    protected $invoices;

    function __construct() {
        $this->option_orders = new ArrayCollection();
        $this->invoices = new ArrayCollection();
    }

    public function setUser(User $user) {
        $this->user = $user;
    }

    /**
     * 
     * @return \Dealscount\Models\Entities\User
     */
    public function getUser() {
        return $this->user;
    }

    public function getId_company() {
        return $this->id_company;
    }

    public function setId_company($id_company) {
        $this->id_company = $id_company;
    }

    public function getCompany_name() {
        return $this->company_name;
    }

    public function setCompany_name($company_name) {
        $this->company_name = $company_name;
    }

    public function getCif() {
        return $this->cif;
    }

    public function setCif($cif) {
        $this->cif = $cif;
    }

    public function getRegCom() {
        return $this->regCom;
    }

    public function setRegCom($regCom) {
        $this->regCom = $regCom;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function getIban() {
        return $this->iban;
    }

    public function setIban($iban) {
        $this->iban = $iban;
    }

    public function getBank() {
        return $this->bank;
    }

    public function setBank($bank) {
        $this->bank = $bank;
    }

    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function getIterationArray() {
        $iteration = array();
        foreach ($this as $key => $value) {
            if (!is_object($value) || ($value instanceof \DateTime))
                $iteration[$key] = $value;
        }
        return $iteration;
    }

    public function getWebsite() {
        return $this->website;
    }

    public function setWebsite($website) {
        $this->website = $website;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function getDistrict() {
        return $this->district;
    }

    public function setDistrict($district) {
        $this->district = $district;
    }

    public function getDistrict_code() {
        return $this->district_code;
    }

    public function setDistrict_code($district_code) {
        $this->district_code = $district_code;
    }

    public function getCity() {
        return $this->city;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function getSend_order() {
        return $this->send_order;
    }

    public function setSend_order($send_order) {
        $this->send_order = $send_order;
    }

    public function getCommercial_name() {
        return $this->commercial_name;
    }

    public function setCommercial_name($commercial_name) {
        $this->commercial_name = $commercial_name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    public function getAvailable_from() {
        return $this->available_from;
    }

    public function getAvailable_to() {
        return $this->available_to;
    }

    public function setAvailable_from($available_from) {
        $this->available_from = $available_from;
        return $this;
    }

    public function setAvailable_to($available_to) {
        $this->available_to = $available_to;
        return $this;
    }

    public function addOptionOrder(SubscriptionOptionOrder $order) {
        $this->option_orders->add($order);
        $order->setCompany($this);
    }

    public function isActive() {
        $cDate = date("Y-m-d");
        
        if (!$this->getAvailable_from() || !$this->getAvailable_to())
            return false;
        
        return ($this->getAvailable_from()->format("Y-m-d") <= $cDate && $cDate <= $this->getAvailable_to()->format("Y-m-d"));
    }

    public function getInvoices() {
        return $this->invoices;
    }

    public function addInvoice($invoice) {
        $this->invoices->add($invoice);
        $invoice->setCompany($this);
    }

}

?>
