<?php

namespace Dealscount\Models\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity 
 * @Table(name="users")
 */
class User extends AbstractEntity {

    /**
     *
     * @Id  @Column(type="integer")
     * @GeneratedValue
     */
    protected $id_user;

    /**
     *
     * @Column(type="string",nullable=true) @var string 
     */
    protected $lastname;

    /**
     * @Column(type="string",nullable=true) @var string 
     */
    protected $firstname;

    /**
     * @Column(type="string",nullable=true) @var string 
     */
    protected $phone;

    /**
     * @Column(type="string",unique=true) @var string 
     */
    protected $email;

    /**
     * @Column(type="string",unique=true) @var string 
     */
    protected $username;

    /**
     * @Column(type="string") @var string 
     */
    protected $gender;

    /**
     * @Column(type="string") @var string 
     */
    private $password;

    /**
     * @Column(type="string") @var string 
     * Level 1 admin, level 2 partener, level 3 user
     */
    protected $access_level = 3;
    protected $fromFb = 0;

    /**
     * @Column(type="datetime")
     */
    protected $created_date;

    /**
     * @OneToMany(targetEntity="Item",mappedBy="company")
     */
    protected $items;

    /**
     * @OneToOne(targetEntity="Company",mappedBy="user",cascade={"persist"})
     */
    protected $company;

    /**
     * @OneToMany(targetEntity="Order",mappedBy="user",cascade={"persist"})
     * @OrderBy({"id_order" = "desc"})
     */
    protected $orders;

    /**
     * @OneToMany(targetEntity="Invoice",mappedBy="user",cascade={"persist"})
     * @OrderBy({"id_invoice" = "desc"})
     */
    protected $invoices;

    function __construct() {
        $this->created_date = new \DateTime("now");
        $this->item = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->invoices = new ArrayCollection();
    }

    public function addItem(Item $item) {
        $this->items->add($item);
        $item->setUser($this);
    }

    /**
     * 
     * @return \NeoMvc\Models\Entity\Item
     */
    public function getPartnersItems() {
        return $this->items;
    }

    public function addOrder(Order $order) {
        $this->orders->add($order);
        $order->setUser($this);
    }

    /**
     * Intoarce toate comenzile userului
     * @return OrderItem
     */
    public function getOrders() {
        return $this->orders;
    }

    public function getId_user() {
        return $this->id_user;
    }

    public function setId_user($id_user) {
        $this->id_user = $id_user;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * 
     * @return \NeoMvc\Models\Entity\Company
     */
    public function getCompanyDetails() {
        return $this->company;
    }

    public function setCompany(Company $company) {
        $this->company = $company;
        $company->setUser($this);
    }

    public function getIterationArray() {

        $iteration = array();
        foreach ($this as $key => $value) {
            if (!is_object($value) || ($value instanceof \DateTime))
                $iteration[$key] = $value;
        }

        //adaugam detaliile companiei
        $company = $this->getCompanyDetails();
        if ($company) {
            $extra = $company->getIterationArray();
            foreach ($extra as $key => $value)
                $iteration[$key] = $value;
        }
        return $iteration;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function getInvoices() {
        return $this->invoices;
    }

    public function addInvoice($invoice) {
        $this->invoices->add($invoice);
        $invoice->setUser($this);
    }

    public function getFromFb() {
        return $this->fromFb;
    }

    public function setFromFb($fromFb) {
        $this->fromFb = $fromFb;
    }

    public function getLastname() {
        return $this->lastname;
    }

    public function getFirstname() {
        return $this->firstname;
    }

    public function getCreated_date() {
        return $this->created_date->format('d-m-Y H:i');
    }

    public function setLastname($lastname) {
        $this->lastname = $lastname;
        return $this;
    }

    public function setFirstname($firstname) {
        $this->firstname = $firstname;
        return $this;
    }

    public function setCreated_date($created_date) {
        $this->created_date = $created_date;
        return $this;
    }

    public function getAccessLevel() {
        return $this->access_level;
    }

    public function setAccess_level($access_level) {
        $this->access_level = $access_level;
        return $this;
    }
    
    public function getUsername() {
        return $this->username;
    }

    public function getGender() {
        return $this->gender;
    }

    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    public function setGender($gender) {
        $this->gender = $gender;
        return $this;
    }



}

?>
