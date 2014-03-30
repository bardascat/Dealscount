<?php

namespace Dealscount\Models\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity 
 * @Table(name="item_attributes")
 */
class Attribute {

    /**
     *
     * @Id  @Column(type="integer")
     * @GeneratedValue
     */
    private $id_attribute;

    /**
     *
      @Column(type="string",unique=true)
     */
    private $name;
    
    public function getId_attribute() {
        return $this->id_attribute;
    }

    public function setId_attribute($id_attribute) {
        $this->id_attribute = $id_attribute;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }


}

?>
