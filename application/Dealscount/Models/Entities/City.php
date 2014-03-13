<?php

namespace Dealscount\Models\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity 
 * @Table(name="cities")
 */
class City extends AbstractEntity {

    /**
     * @Id  @Column(type="integer")
     * @GeneratedValue
     */
    protected $id_city;

    /**
     * @Column(type="string")
     */
    protected $district;

    public function getId_city() {
        return $this->id_city;
    }

    public function setId_city($id_city) {
        $this->id_city = $id_city;
        return $this;
    }

    
    public function getDistrict() {
        return $this->district;
    }

    public function setDistrict($district) {
        $this->district = $district;
        return $this;
    }

}

?>
