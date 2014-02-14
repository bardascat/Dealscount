<?php

namespace Dealscount\Models\Entities;

/**
 * @Entity 
 * @Table(name="items_stats")
 */
use Doctrine\Common\Collections\ArrayCollection;

class ItemStats extends AbstractEntity {

    /**
     *
     * @Id  @Column(type="integer")
     * @GeneratedValue
     */
    protected $id_stats;

    /**
     *
     * @Column(type="integer")
     */
    protected $id_item;

    /**
     *
     * @Column(type="datetime")
     */
    protected $lastUpdate;

    /**
     * @Column(type="float")
     */
    protected $rating = 0;

    /**
     * @Column(type="integer")
     */
    protected $sales = 0;

    /**
     * @Column(type="integer")
     */
    protected $views = 0;

    public function __construct() {
        $this->lastUpdate = new \DateTime("now");
    }

    public function getId_stats() {
        return $this->id_stats;
    }

    public function setId_stats($id_stats) {
        $this->id_stats = $id_stats;
    }

    public function getLastUpdate() {
        return $this->lastUpdate;
    }

    public function setLastUpdate($lastUpdate) {
        $this->lastUpdate = $lastUpdate;
    }

    public function getRating() {
        return $this->rating;
    }

    public function setRating($rating) {
        $this->rating = $rating;
    }

    public function getViews() {
        return $this->views;
    }

    public function setViews($views) {
        $this->views = $views;
    }

    public function getId_item() {
        return $this->id_item;
    }

    public function setId_item($id_item) {
        $this->id_item = $id_item;
    }
    
    public function getSales() {
        return $this->sales;
    }
    public function setSales($sales) {
        $this->sales = $sales;
        return $this;
    }



}

?>
