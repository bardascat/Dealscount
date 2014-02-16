<?php

namespace Dealscount\Models\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity 
 * @Table(name="acl_resources")
 */
class AclResource extends AbstractEntity {

    /**
     *
     * @Id  @Column(type="integer")
     * @GeneratedValue
     */
    protected $id_resource;

    /**
     * @Column(type="string")
     */
    protected $name;

    /**
     * @Column(type="string")
     */
    protected $alias;

    /**
     * @Column(type="string",nullable=true)
     */
    protected $description;

    function __construct() {
        
    }
    
    
    public function getId_resource() {
        return $this->id_resource;
    }

    public function getName() {
        return $this->name;
    }

    public function getAlias() {
        return $this->alias;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setId_resource($id_resource) {
        $this->id_resource = $id_resource;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setAlias($alias) {
        $this->alias = $alias;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }



}

?>
