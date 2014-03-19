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
     * @Column(type="integer",nullable=true) @var string
     */
    protected $used;

    /**
     * Salvam cum s a folosit aceasta optiune
     * @Column(type="text",nullable=true) @var string
     */
    protected $used_on;

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



}

?>
