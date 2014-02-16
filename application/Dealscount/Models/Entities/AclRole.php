<?php

namespace Dealscount\Models\Entities;

/**
 * @Entity 
 * @Table(name="acl_role")
 */
class AclRole extends AbstractEntity {

    /**
     *
     * @Id  @Column(type="integer")
     * @GeneratedValue
     */
    protected $id_role;

    /**
     * @Column(type="string")
     */
    protected $name;

  
    function __construct() {
       
    }
    public function getId_role() {
        return $this->id_role;
    }

    public function getName() {
        return $this->name;
    }

    public function setId_role($id_role) {
        $this->id_role = $id_role;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }



}

?>
