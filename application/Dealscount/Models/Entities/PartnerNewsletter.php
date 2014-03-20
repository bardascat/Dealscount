<?php

namespace Dealscount\Models\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity 
 * @Table(name="partner_newsletter")
 */
class PartnerNewsletter extends AbstractEntity {

    /**
     * @Id  @Column(type="integer")
     * @GeneratedValue
     */
    private $id_newsletter;

    /**
     * @Column(type="string")
     */
    protected $name;

    /**
     * @Column(type="datetime")
     */
    protected $scheduled;

    /**
     * @Column(type="datetime")
     */
    protected $created;

    /**
     * @Column(type="text")
     */
    protected $filters;

    /**
     * @Column(type="text")
     */
    protected $offers;

    /**
     * @Column(type="string")
     */
    protected $status;

    /**
     * @Column(type="integer",nullable=true)
     */
    protected $sentTo;

    /**
     * @Column(type="integer",nullable=true)
     */
    protected $opened;

    /**
     * @Column(type="integer",nullable=true)
     */
    protected $clicks;

    /**
     * @ManyToOne(targetEntity="User",inversedBy="partnerNewsletter")
     * @JoinColumn(name="id_user", referencedColumnName="id_user" ,onDelete="CASCADE")
     */
    private $user;

    /**
     * @OneToOne(targetEntity="ActiveOption",cascade={"persist"})
     * @JoinColumn(name="id_active_option", referencedColumnName="id")
     */
    protected $option;

    /**
     * @Column(type="integer",nullable=true)
     */
    protected $id_active_option;

    function __construct() {
        $this->created = new \DateTime('now');
    }

    public function getId_newsletter() {
        return $this->id_newsletter;
    }

    public function getName() {
        return $this->name;
    }

    public function getScheduled() {
        return $this->scheduled;
    }

    public function getFilters() {
        return $this->filters;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getSentTo() {
        return $this->sentTo;
    }

    public function getOpened() {
        return $this->opened;
    }

    public function getClicks() {
        return $this->clicks;
    }

    public function setId_newsletter($id_newsletter) {
        $this->id_newsletter = $id_newsletter;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setScheduled($scheduled) {
        $this->scheduled = $scheduled;
        return $this;
    }

    public function setFilters($filters) {
        $this->filters = $filters;
        return $this;
    }

    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    public function setSentTo($sentTo) {
        $this->sentTo = $sentTo;
        return $this;
    }

    public function setOpened($opened) {
        $this->opened = $opened;
        return $this;
    }

    public function setClicks($clicks) {
        $this->clicks = $clicks;
        return $this;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
        return $this;
    }

    public function getOffers() {
        return $this->offers;
    }

    public function setOffers($offers) {
        $this->offers = $offers;
        return $this;
    }

    public function getCreated() {
        return $this->created;
    }

    public function setCreated($created) {
        $this->created = $created;
        return $this;
    }

    /**
     * 
     * @return \Dealscount\Models\Entities\ActiveOption
     */
    public function getOption() {
        return $this->option;
    }

    public function setOption($option) {
        $this->option = $option;
        return $this;
    }
    
    public function getId_active_option() {
        return $this->id_active_option;
    }

    public function setId_active_option($id_active_option) {
        $this->id_active_option = $id_active_option;
        return $this;
    }






}

?>
