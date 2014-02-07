<?php

namespace Dealscount\Models\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity 
 * @Table(name="company")
 */
class Company extends AbstractEntity {

    /**
     *
     * @Id  @Column(type="integer")
     * @GeneratedValue
     */
    protected $id_company;

    /**
     *
     * @Column(type="string",nullable=false)
     */
    protected $description;

    /**
     *
     * @Column(type="string",nullable=false)
     */
    protected $company_name;

    /**
     *
     * @Column(type="string",nullable=false)
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
     *
     * @Column(type="string",nullable=true)
     */
    protected $send_order = 0;

    /**
     * @OneToOne(targetEntity="User",inversedBy="company")
     * @JoinColumn(name="id_user", referencedColumnName="id_user" ,onDelete="CASCADE")
     */
    protected $user;

    public function setUser(User $user) {
        $this->user = $user;
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



}

?>
