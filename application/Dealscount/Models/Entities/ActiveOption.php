<?php

namespace Dealscount\Models\Entities;

/**
 * @Entity 
 * @Table(name="active_options")
 */
class ActiveOption extends AbstractEntity {

    /**
     * @Id  @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     *  @Column(type="string")
     */
    protected $name;

    /**
     *  @Column(type="integer")
     */
    protected $id_company;

    /**
     *  @Column(type="integer")
     */
    protected $id_option;

    /**
     *  @Column(type="integer")
     */
    protected $id_option_order;

    /**
     * @ManyToOne(targetEntity="Company",inversedBy="active_options")
     * @JoinColumn(name="id_company", referencedColumnName="id_company" ,onDelete="CASCADE")
     */
    protected $company;

    /**
     * @ManyToOne(targetEntity="SubscriptionOption",cascade={"persist"})
     * @JoinColumn(name="id_option", referencedColumnName="id_option")
     */
    protected $option;

    /**
     * @Column(type="datetime",nullable=true) @var string
     */
    protected $used_at;

    /**
     * diferenta intre activated si used este:
     * Used_at este data cand se aplica optiunea pe oferta
     * activated este data cand este activata optiunea de catre job
     * @Column(type="datetime",nullable=true) @var string
     */
    protected $activated;

    /**
     * @Column(type="integer",nullable=true) @var string
     */
    protected $used;

    /**
     * @Column(type="date",nullable=true) @var string
     */
    protected $scheduled;

    /**
     * Salvam id-ului ofertei sau a newsletterul pe care s-a folosit aceasta optiune
     * @Column(type="integer",nullable=true) @var string
     */
    protected $used_on;

    /**
     * Pentru optiunile de promovare a ofertelor in lista salvam pozitia ofertei
     * @Column(type="integer",nullable=true) @var string
     */
    protected $position;

    /**
     * Salvam detalii despre ce impact a avut optiunea asupra ofertelor
     * @Column(type="text",nullable=true) @var string
     */
    protected $details;

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getId_company() {
        return $this->id_company;
    }

    public function getCompany() {
        return $this->company;
    }

    /**
     * 
     * @return \Dealscount\Models\Entities\SubscriptionOption
     */
    public function getOption() {
        return $this->option;
    }

    public function getUsed_at() {
        return $this->used_at;
    }

    public function getUsed() {
        return $this->used;
    }

    public function getUsed_on() {
        return $this->used_on;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setId_company($id_company) {
        $this->id_company = $id_company;
        return $this;
    }

    public function setCompany($company) {
        $this->company = $company;
        return $this;
    }

    public function setOption($option) {
        $this->option = $option;
        return $this;
    }

    public function setUsed_at($used_at) {
        $this->used_at = $used_at;
        return $this;
    }

    public function setUsed($used) {
        $this->used = $used;
        return $this;
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

    public function getId_option_order() {
        return $this->id_option_order;
    }

    public function setId_option_order($id_option_order) {
        $this->id_option_order = $id_option_order;
        return $this;
    }

    public function getDetails() {
        return $this->details;
    }

    public function setDetails($details) {
        $this->details = $details;
        return $this;
    }

    public function getScheduled() {
        return $this->scheduled;
    }

    public function setScheduled($scheduled) {
        $this->scheduled = $scheduled;
        return $this;
    }

    public function getAvailable() {
        return $this->available;
    }

    public function setAvailable($available) {
        $this->available = $available;
        return $this;
    }

    public function getPosition() {
        return $this->position;
    }

    public function setPosition($position) {
        $this->position = $position;
        return $this;
    }
    
    public function getActivated() {
        return $this->activated;
    }

    public function setActivated($activated) {
        $this->activated = $activated;
        return $this;
    }



}

?>
