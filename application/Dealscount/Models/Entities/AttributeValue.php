<?php

namespace Dealscount\Models\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity 
 * @Table(name="attribute_values")
 */
class AttributeValue {

    /**
     *
     * @Id  @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     *
     * @Column(type="integer")
     */
    private $id_attribute;

    /**
     * @Column (type="integer")
     */
    private $id_variant;

    /**
     * @Column (type="string")
     */
    private $value;

    /**
     * @ManyToOne(targetEntity="Attribute")
     * @JoinColumn(name="id_attribute", referencedColumnName="id_attribute")
     */
    private $attribute;

    /**
     * @ManyToOne(targetEntity="ItemVariant",inversedBy="attributesValue")
     * @JoinColumn(name="id_variant", referencedColumnName="id_variant",onDelete="CASCADE"))
     */
    private $ItemVariant;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId_attribute() {
        return $this->id_attribute;
    }

    public function setId_attribute($id_attribute) {
        $this->id_attribute = $id_attribute;
    }

    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
    if (!strlen($value)){
            throw new \Exception("Eroare: Completati valorile campurilor pentru oferta multipla");
    }
        $this->value = $value;
    }

    public function getId_variant() {
        return $this->id_variant;
    }

    public function setId_variant($id_variant) {
        $this->id_variant = $id_variant;
    }

    /**
     * 
     * @return \Dealscount\Models\Entities\Attribute
     */
    public function getAttribute() {
        return $this->attribute;
    }

    public function setAttribute($attribute) {
        $this->attribute = $attribute;
    }

    public function getItemVariant() {
        return $this->ItemVariant;
    }

    public function setItemVariant($ItemVariant) {
        $this->ItemVariant = $ItemVariant;
        return $this;
    }

}

?>
