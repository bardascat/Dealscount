<?php

namespace Dealscount\Models\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity 
 * @Table(name="users")
 */
class User extends AbstractEntity {

    /**
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
     * @Column(type="string",unique=true,nullable=true) @var string 
     */
    protected $username;

    /**
     * @Column(type="string") @var string 
     */
    protected $gender;

    /**
     * @Column(type="string") @var string 
     */
    protected $age;

    /**
     * @Column(type="string",nullable=true) @var string 
     */
    protected $address;

    /**
     * @Column(type="string",nullable=false) @var string 
     */
    protected $city;

    /**
     * @Column(type="string") @var string 
     */
    private $password;

    /**
     * @Column(type="integer",nullable=true) @var string 
     */
    protected $id_role;

    /**
     * @ManyToOne(targetEntity="AclRole")
     * @JoinColumn(name="id_role", referencedColumnName="id_role")
     * */
    private $AclRole;

    /**
     * @Column(type="integer") @var string 
     */
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
     * @OneToMany(targetEntity="PartnerNewsletter",mappedBy="user",cascade={"persist"})
     * @OrderBy({"status"="desc","scheduled" = "asc"})
     */
    protected $partnerNewsletter;

    /**
     * @OneToMany(targetEntity="Item",mappedBy="operator")
     */
    protected $operator_items;

    /**
     * @OneToOne(targetEntity="Company",mappedBy="user",cascade={"persist"})
     */
    protected $company;

    /**
     * @OneToMany(targetEntity="Order",mappedBy="user",cascade={"persist"})
     * @OrderBy({"id_order" = "desc"})
     */
    protected $orders;

    private $realPassword;

    function __construct() {
        $this->created_date = new \DateTime("now");
        $this->items = new ArrayCollection();
        $this->operator_items = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->invoices = new ArrayCollection();
        $this->partnerNewsletter=new ArrayCollection();
    }

    public function addOperatorItem(Item $item) {
        $this->operator_items->add($item);
        $item->setOperator($this);
    }

    public function getOperatorItems() {
        return $this->operator_items;
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
     * @return \Dealscount\Models\Entities\Company
     */
    public function getCompanyDetails() {
        return $this->company;
    }

    public function setCompany(Company $company) {
        $this->company = $company;
        $company->setUser($this);
    }

    public function getIterationArray() {

        //proprietatile userului
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

        //adaugam rolul
        $role = $this->getAclRole();
        $iteration[$role->getId_role()] = $role->getId_role();
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

    public function getId_role() {
        return $this->id_role;
    }

    /**
     * 
     * @return \Dealscount\Models\Entities\AclRole
     */
    public function getAclRole() {
        return $this->AclRole;
    }

    public function setId_role($id_role) {
        $this->id_role = $id_role;
        return $this;
    }

    public function setAclRole(AclRole $AclRole) {
        $this->AclRole = $AclRole;
        return $this;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
        return $this;
    }

    public function getCity() {
        return $this->city;
    }

    public function setCity($city) {
        $this->city = $city;
        return $this;
    }

    public function getRealPassword() {
        return $this->realPassword;
    }

    public function setRealPassword($realPassword) {
        $this->realPassword = $realPassword;
        return $this;
    }

    /**
     * 
     * @return \Dealscount\Models\Entities\Item
     */
    public function getItems() {
        return $this->items;
    }

    public function setItems($items) {
        $this->items = $items;
        return $this;
    }

    public function getAge() {
        return $this->age;
    }

    public function setAge($age) {
        $this->age = $age;
        return $this;
    }

    /**
     * @return \Dealscount\Models\Entities\PartnerNewsletter
     */
    public function getPartnerNewsletters() {
        return $this->partnerNewsletter;
    }

    public function addPartnerNewsletter(PartnerNewsletter $partnerNewsletter) {
        $this->partnerNewsletter->add($partnerNewsletter);
        $partnerNewsletter->setUser($this);
    }


}

?>
